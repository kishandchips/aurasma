<?php 
add_action('admin_init', 'add_custom_boxes');
add_action('admin_head', 'load_externals');

function add_custom_boxes(){
	$post_id = NULL;
	if(isset($_GET['post'])){
		$post_id = $_GET['post'];
	} elseif(isset($_POST['post_ID'])){
		$post_id = $_POST['post_ID'];
	}
	$post = get_post($post_id);

	add_meta_box(
		"partners-meta", 
		"Partner Options",
		"partner_meta_options", 
		"partner",
		"side", 
		"high"
	);

	add_meta_box(
		"campaigns-meta", 
		"Campaign Options",
		"campaign_meta_options", 
		"campaign",
		"side", 
		"high"
	);

	add_meta_box(
		"teammembers-meta", 
		"Team member Options",
		"teammember_meta_options", 
		"team-member",
		"normal", 
		"high"
	);

	add_meta_box(
		"page-topcontent", 
		"Top Content",
		"page_topcontent", 
		"page",
		"normal", 
		"high"
	);
	
	add_meta_box(
		"post_links", 
		"Bottom Links",
		"post_links", 
		"post",
		"normal", 
		"high"
	);
	
	add_meta_box(
		"press_link", 
		"Additional Content",
		"press_link", 
		"press-item",
		"normal", 
		"high"
	);

	
	if(isset($post)){
		if($post->ID == 113){

			add_meta_box(
				"extracontent", 
				"Extra Content",
				"page_extracontent", 
				"page",
		        "normal",
		        "low"
			);
		}
	}
}



// partners options

function partner_meta_options(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom = get_post_custom($post->ID);
	$external_url = $custom["external_url"][0];
	$case_study_url = $custom["case_study_url"][0];
	$youtube_video_id = $custom["youtube_video_id"][0];
	$has_casestudy_checked = (($custom["has_casestudy"][0]) ? 'checked="checked"' : '');
	
?>

<input type="hidden" name="partner_meta_nonce" value="<?php echo wp_create_nonce('partner_meta');?>" />
<div class="custom_extras">

<?php
	$case_study_url = ($case_study_url == "") ? "http://" : $case_study_url;
?>

	<div class="row clearfix">
		<label for="has_casestudy" class="checkbox">Case Study:</label>
		<input type="checkbox" id="has_casestudy" name="has_casestudy" <?php echo $has_casestudy_checked; ?> />
	</div>
	<div <?php if($has_casestudy_checked == ''): ?>class="hidden"<?php endif; ?>>
		<div class="row casestudy ">
			<label for="case_study_url">Insert PDF Download Link:</label>
			<input id="case_study_url" name="case_study_url" type="text" value="<?php echo $case_study_url; ?>" />
		</div>
		<div class="row">
			<label for="external_url">Insert External URL:</label>
			<input id="external_url" name="external_url" type="text" value="<?php echo $external_url; ?>" />
		</div>
		<div class="row">
			<label for="youtube_video_id">Video/Image embed code:</label>
			<textarea id="youtube_video_id" name="youtube_video_id"><?php echo $youtube_video_id; ?></textarea>
			<em>Maximum width: 617 px - Maximum height: 378 px</em>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(function(){
		jQuery('#has_casestudy').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('div.hidden').slideDown('fast');
			} else {
				jQuery('div.hidden').slideUp('fast');
			}
		});
	})
</script>


<?php

}

add_action('save_post', 'partner_save_extras');

function partner_save_extras(){
	global $post;
	
	if(isset($_POST['partner_meta_nonce'])){
		if (!wp_verify_nonce($_POST['partner_meta_nonce'], 'partner_meta')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		if($_POST["has_casestudy"]) { $has_casestudy = 'on'; } else { $has_casestudy = ''; };
		update_post_meta($post->ID, "has_casestudy", $has_casestudy);
		update_post_meta($post->ID, "external_url", $_POST["external_url"]);
		update_post_meta($post->ID, "case_study_url", $_POST["case_study_url"]);
		update_post_meta($post->ID, "youtube_video_id", $_POST["youtube_video_id"]);
	}
}

add_filter("manage_edit-partners_columns", "partner_edit_columns");

function partner_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Partner Name",
		"description" => "Description",
		"external_url" => "External URL",
		"case_study_url" => "Case study URL",
		"youtube_video_id" => "Youtube Video ID",
	);
	return $columns;
}

add_action("manage_partners_posts_custom_column", "partner_custom_columns");

function partner_custom_columns($column){
	global $post;
	$custom = get_post_custom();
	switch ($column)
		{
		case "description":
			the_excerpt();
			break;
		case "external_url":
			echo $custom["external_url"][0];
			break;
		case "case_study_url":
			echo $custom["case_study_url"][0];
			break;
		case "youtube_video_id":
			echo $custom["youtube_video_id"][0];
			break;
	}
}




// campaigns options

function campaign_meta_options(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom = get_post_custom($post->ID);
	$release_date = isset($custom["release_date"][0]) ? $custom["release_date"][0] : '';
	$channel = isset($custom["channel"][0]) ? $custom["channel"][0] : '';
	$website_url = isset($custom["website_url"][0]) ? $custom["website_url"][0] : '';
	$is_latest = $custom["is_latest"][0];
	$show_vid = $custom["show_vid"][0];
	$show_links = $custom["show_links"][0];
	$link1 = isset($custom["link1"][0]) ? $custom["link1"][0] : '';
	$link2 = isset($custom["link2"][0]) ? $custom["link2"][0] : '';
	$link3 = isset($custom["link3"][0]) ? $custom["link3"][0] : '';
	$link4 = isset($custom["link4"][0]) ? $custom["link4"][0] : '';
	$link5 = isset($custom["link5"][0]) ? $custom["link5"][0] : '';
	$link6 = isset($custom["link6"][0]) ? $custom["link6"][0] : '';
	$link7 = isset($custom["link7"][0]) ? $custom["link7"][0] : '';
	$link8 = isset($custom["link8"][0]) ? $custom["link8"][0] : '';
	$link9 = isset($custom["link9"][0]) ? $custom["link9"][0] : '';
	$link10 = isset($custom["link10"][0]) ? $custom["link10"][0] : '';
	$linktitle1 = isset($custom["linktitle1"][0]) ? $custom["linktitle1"][0] : '';
	$linktitle2 = isset($custom["linktitle2"][0]) ? $custom["linktitle2"][0] : '';
	$linktitle3 = isset($custom["linktitle3"][0]) ? $custom["linktitle3"][0] : '';
	$linktitle4 = isset($custom["linktitle4"][0]) ? $custom["linktitle4"][0] : '';
	$linktitle5 = isset($custom["linktitle5"][0]) ? $custom["linktitle5"][0] : '';
	$linktitle6 = isset($custom["linktitle6"][0]) ? $custom["linktitle6"][0] : '';
	$linktitle7 = isset($custom["linktitle7"][0]) ? $custom["linktitle7"][0] : '';
	$linktitle8 = isset($custom["linktitle8"][0]) ? $custom["linktitle8"][0] : '';
	$linktitle9 = isset($custom["linktitle9"][0]) ? $custom["linktitle9"][0] : '';
	$linktitle10 = isset($custom["linktitle10"][0]) ? $custom["linktitle10"][0] : '';
		
?>

<input type="hidden" name="campaign_meta_nonce" value="<?php echo wp_create_nonce('campaign_meta');?>" />
<div class="custom_extras">

<?php
	$website_url = ($website_url == "") ? "http://" : $website_url;
	$is_latest_checked = (($is_latest) ? 'checked="checked"' : '');
	$show_vid_checked = (($show_vid) ? 'checked="checked"' : '');
	$show_links_checked = (($show_links) ? 'checked="checked"' : '');

?>

	<div class="row">
		<label for="release_date">Release date:</label>
		<input type="text" id="release_date"name="release_date" value="<?php echo $release_date; ?>" />
	</div>
	
	<div class="row">
		<label for="channel">Channel (Follow this Aura):</label>
		<input type="text" id="channel" name="channel" value="<?php echo $channel; ?>" />
	</div>

	<div class="row">
		<label for="website_url">Video URL:</label>
		<input type="text" id="website_url" name="website_url" value="<?php echo $website_url; ?>" />
	</div>
	
	<div class="row clearfix">
		<label for="show_vid" class="checkbox">Show Video?:</label>
		<input type="checkbox" id="show_vid" name="show_vid" <?php echo $show_vid_checked; ?> />
	</div>
	
	<div class="row clearfix">
		<label for="is_latest" class="checkbox">Latest Campaign:</label>
		<input type="checkbox" id="is_latest" name="is_latest" <?php echo $is_latest_checked; ?> />
	</div>
	
	<hr/>
	
	<div class="row clearfix">
		<label for="show_links" class="checkbox">Show Further Coverage Links?:</label>
		<input type="checkbox" id="show_links" name="show_links" <?php echo $show_links_checked; ?> />
	</div>
	
	<div class="row">
		<label for="linktitle1">Further Coverage Link 1 Title:</label>
		<input type="text" id="linktitle1" name="linktitle1" value="<?php echo $linktitle1; ?>" />
		
		<label for="link1">Further Coverage Link 1 URL:</label>
		<input type="text" id="link1" name="link1" value="<?php echo $link1; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle2">Further Coverage Link 2 Title:</label>
		<input type="text" id="linktitle2" name="linktitle2" value="<?php echo $linktitle2; ?>" />
		
		<label for="link2">Further Coverage Link 2 URL:</label>
		<input type="text" id="link2" name="link2" value="<?php echo $link2; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle3">Further Coverage Link 3 Title:</label>
		<input type="text" id="linktitle3" name="linktitle3" value="<?php echo $linktitle3; ?>" />

		<label for="link3">Further Coverage Link 3 URL:</label>
		<input type="text" id="link3" name="link3" value="<?php echo $link3; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle4">Further Coverage Link 4 Title:</label>
		<input type="text" id="linktitle4" name="linktitle4" value="<?php echo $linktitle4; ?>" />
		
		<label for="link4">Further Coverage Link 4 URL:</label>
		<input type="text" id="link4" name="link4" value="<?php echo $link4; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle5">Further Coverage Link 5 Title:</label>
		<input type="text" id="linktitle5" name="linktitle5" value="<?php echo $linktitle5; ?>" />

		<label for="link5">Further Coverage Link 5 URL:</label>
		<input type="text" id="link5" name="link5" value="<?php echo $link5; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle6">Further Coverage Link 6 Title:</label>
		<input type="text" id="linktitle6" name="linktitle6" value="<?php echo $linktitle6; ?>" />

		<label for="link6">Further Coverage Link 6 URL:</label>
		<input type="text" id="link6" name="link6" value="<?php echo $link6; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle7">Further Coverage Link 7 Title:</label>
		<input type="text" id="linktitle7" name="linktitle7" value="<?php echo $linktitle7; ?>" />

		<label for="link7">Further Coverage Link 7 URL:</label>
		<input type="text" id="link7" name="link7" value="<?php echo $link7; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle8">Further Coverage Link 8 Title:</label>
		<input type="text" id="linktitle8" name="linktitle8" value="<?php echo $linktitle8; ?>" />

		<label for="link8">Further Coverage Link 8 URL:</label>
		<input type="text" id="link8" name="link8" value="<?php echo $link8; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle9">Further Coverage Link 9 Title:</label>
		<input type="text" id="linktitle9" name="linktitle9" value="<?php echo $linktitle9; ?>" />

		<label for="link9">Further Coverage Link 9 URL:</label>
		<input type="text" id="link9" name="link9" value="<?php echo $link9; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle10">Further Coverage Link 10 Title:</label>
		<input type="text" id="linktitle10" name="linktitle10" value="<?php echo $linktitle10; ?>" />
		
		<label for="link10">Further Coverage Link 10 URL:</label>
		<input type="text" id="link10" name="link10" value="<?php echo $link10; ?>" />
	</div>

</div>

<?php

}

add_action('save_post', 'campaign_save_extras');

function campaign_save_extras(){
	global $post;
	
	if(isset($_POST['campaign_meta_nonce'])){
		if (!wp_verify_nonce($_POST['campaign_meta_nonce'], 'campaign_meta')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post->ID, "release_date", $_POST["release_date"]);
		update_post_meta($post->ID, "channel", $_POST["channel"]);
		update_post_meta($post->ID, "website_url", $_POST["website_url"]);
		if($_POST["is_latest"]) { $is_latest = 'on'; } else { $is_latest = ''; };
		update_post_meta($post->ID, "is_latest", $is_latest);
		if($_POST["show_vid"]) { $show_vid = 'on'; } else { $show_vid = ''; };
		update_post_meta($post->ID, "show_vid", $show_vid);
		if($_POST["show_links"]) { $show_links = 'on'; } else { $show_links = ''; };
		update_post_meta($post->ID, "show_links", $show_links);
		update_post_meta($post->ID, "link1", $_POST["link1"]);
		update_post_meta($post->ID, "link2", $_POST["link2"]);
		update_post_meta($post->ID, "link3", $_POST["link3"]);
		update_post_meta($post->ID, "link4", $_POST["link4"]);
		update_post_meta($post->ID, "link5", $_POST["link5"]);
		update_post_meta($post->ID, "link6", $_POST["link6"]);
		update_post_meta($post->ID, "link7", $_POST["link7"]);
		update_post_meta($post->ID, "link8", $_POST["link8"]);
		update_post_meta($post->ID, "link9", $_POST["link9"]);
		update_post_meta($post->ID, "link10", $_POST["link10"]);
		update_post_meta($post->ID, "linktitle1", $_POST["linktitle1"]);
		update_post_meta($post->ID, "linktitle2", $_POST["linktitle2"]);
		update_post_meta($post->ID, "linktitle3", $_POST["linktitle3"]);
		update_post_meta($post->ID, "linktitle4", $_POST["linktitle4"]);
		update_post_meta($post->ID, "linktitle5", $_POST["linktitle5"]);
		update_post_meta($post->ID, "linktitle6", $_POST["linktitle6"]);
		update_post_meta($post->ID, "linktitle7", $_POST["linktitle7"]);
		update_post_meta($post->ID, "linktitle8", $_POST["linktitle8"]);
		update_post_meta($post->ID, "linktitle9", $_POST["linktitle9"]);
		update_post_meta($post->ID, "linktitle10", $_POST["linktitle10"]);

	}
}

add_filter("manage_edit-campaigns_columns", "campaign_edit_columns");

function campaign_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Partner Name",
		"description" => "Description",
		"release_date" => "Release date",
		"website_url" => "Website URL",
		"is_latest" => "Latest Campaign"
	);
	return $columns;
}

add_action("manage_campaigns_posts_custom_column", "campaign_custom_columns");

function campaign_custom_columns($column){
	global $post;
	$custom = get_post_custom();
	switch ($column)
		{
		case "description":
			the_excerpt();
			break;
		case "release_date":
			echo $custom["release_date"][0];
			break;
		case "website_url":
			echo $custom["website_url"][0];
			break;
	}
}


// post options

function post_links(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom = get_post_custom($post->ID);

	$show_links = $custom["show_links"][0];
	$link1 = isset($custom["link1"][0]) ? $custom["link1"][0] : '';
	$link2 = isset($custom["link2"][0]) ? $custom["link2"][0] : '';
	$link3 = isset($custom["link3"][0]) ? $custom["link3"][0] : '';
	$link4 = isset($custom["link4"][0]) ? $custom["link4"][0] : '';
	$link5 = isset($custom["link5"][0]) ? $custom["link5"][0] : '';
	$link6 = isset($custom["link6"][0]) ? $custom["link6"][0] : '';
	$link7 = isset($custom["link7"][0]) ? $custom["link7"][0] : '';
	$link8 = isset($custom["link8"][0]) ? $custom["link8"][0] : '';
	$link9 = isset($custom["link9"][0]) ? $custom["link9"][0] : '';
	$link10 = isset($custom["link10"][0]) ? $custom["link10"][0] : '';
	$linktitle1 = isset($custom["linktitle1"][0]) ? $custom["linktitle1"][0] : '';
	$linktitle2 = isset($custom["linktitle2"][0]) ? $custom["linktitle2"][0] : '';
	$linktitle3 = isset($custom["linktitle3"][0]) ? $custom["linktitle3"][0] : '';
	$linktitle4 = isset($custom["linktitle4"][0]) ? $custom["linktitle4"][0] : '';
	$linktitle5 = isset($custom["linktitle5"][0]) ? $custom["linktitle5"][0] : '';
	$linktitle6 = isset($custom["linktitle6"][0]) ? $custom["linktitle6"][0] : '';
	$linktitle7 = isset($custom["linktitle7"][0]) ? $custom["linktitle7"][0] : '';
	$linktitle8 = isset($custom["linktitle8"][0]) ? $custom["linktitle8"][0] : '';
	$linktitle9 = isset($custom["linktitle9"][0]) ? $custom["linktitle9"][0] : '';
	$linktitle10 = isset($custom["linktitle10"][0]) ? $custom["linktitle10"][0] : '';
		
?>

<input type="hidden" name="post_links_meta_nonce" value="<?php echo wp_create_nonce('post_links_meta');?>" />
<div class="custom_extras">

<?php

	$show_links_checked = (($show_links) ? 'checked="checked"' : '');

?>


	<div class="row clearfix">
		<label for="show_links" class="checkbox">Show Further Coverage Links?:</label>
		<input type="checkbox" id="show_links" name="show_links" <?php echo $show_links_checked; ?> />
	</div>
	<div class="row">
		<label for="linktitle1">Further Coverage Link 1 Title:</label>
		<input type="text" id="linktitle1" name="linktitle1" value="<?php echo $linktitle1; ?>" />
		
		<label for="link1">Further Coverage Link 1 URL:</label>
		<input type="text" id="link1" name="link1" value="<?php echo $link1; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle2">Further Coverage Link 2 Title:</label>
		<input type="text" id="linktitle2" name="linktitle2" value="<?php echo $linktitle2; ?>" />
		
		<label for="link2">Further Coverage Link 2 URL:</label>
		<input type="text" id="link2" name="link2" value="<?php echo $link2; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle3">Further Coverage Link 3 Title:</label>
		<input type="text" id="linktitle3" name="linktitle3" value="<?php echo $linktitle3; ?>" />

		<label for="link3">Further Coverage Link 3 URL:</label>
		<input type="text" id="link3" name="link3" value="<?php echo $link3; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle4">Further Coverage Link 4 Title:</label>
		<input type="text" id="linktitle4" name="linktitle4" value="<?php echo $linktitle4; ?>" />
		
		<label for="link4">Further Coverage Link 4 URL:</label>
		<input type="text" id="link4" name="link4" value="<?php echo $link4; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle5">Further Coverage Link 5 Title:</label>
		<input type="text" id="linktitle5" name="linktitle5" value="<?php echo $linktitle5; ?>" />

		<label for="link5">Further Coverage Link 5 URL:</label>
		<input type="text" id="link5" name="link5" value="<?php echo $link5; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle6">Further Coverage Link 6 Title:</label>
		<input type="text" id="linktitle6" name="linktitle6" value="<?php echo $linktitle6; ?>" />

		<label for="link6">Further Coverage Link 6 URL:</label>
		<input type="text" id="link6" name="link6" value="<?php echo $link6; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle7">Further Coverage Link 7 Title:</label>
		<input type="text" id="linktitle7" name="linktitle7" value="<?php echo $linktitle7; ?>" />

		<label for="link7">Further Coverage Link 7 URL:</label>
		<input type="text" id="link7" name="link7" value="<?php echo $link7; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle8">Further Coverage Link 8 Title:</label>
		<input type="text" id="linktitle8" name="linktitle8" value="<?php echo $linktitle8; ?>" />

		<label for="link8">Further Coverage Link 8 URL:</label>
		<input type="text" id="link8" name="link8" value="<?php echo $link8; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle9">Further Coverage Link 9 Title:</label>
		<input type="text" id="linktitle9" name="linktitle9" value="<?php echo $linktitle9; ?>" />

		<label for="link9">Further Coverage Link 9 URL:</label>
		<input type="text" id="link9" name="link9" value="<?php echo $link9; ?>" />
	</div>
	
	<div class="row">
		<label for="linktitle10">Further Coverage Link 10 Title:</label>
		<input type="text" id="linktitle10" name="linktitle10" value="<?php echo $linktitle10; ?>" />
		
		<label for="link10">Further Coverage Link 10 URL:</label>
		<input type="text" id="link10" name="link10" value="<?php echo $link10; ?>" />
	</div>

</div>

<?php

}

add_action('save_post', 'post_links_save_extras');

function post_links_save_extras(){
	global $post;
	
	if(isset($_POST['post_links_meta_nonce'])){
		if (!wp_verify_nonce($_POST['post_links_meta_nonce'], 'post_links_meta')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		if($_POST["show_links"]) { $show_links = 'on'; } else { $show_links = ''; };
		update_post_meta($post->ID, "show_links", $show_links);
		update_post_meta($post->ID, "link1", $_POST["link1"]);
		update_post_meta($post->ID, "link2", $_POST["link2"]);
		update_post_meta($post->ID, "link3", $_POST["link3"]);
		update_post_meta($post->ID, "link4", $_POST["link4"]);
		update_post_meta($post->ID, "link5", $_POST["link5"]);
		update_post_meta($post->ID, "link6", $_POST["link6"]);
		update_post_meta($post->ID, "link7", $_POST["link7"]);
		update_post_meta($post->ID, "link8", $_POST["link8"]);
		update_post_meta($post->ID, "link9", $_POST["link9"]);
		update_post_meta($post->ID, "link10", $_POST["link10"]);
		update_post_meta($post->ID, "linktitle1", $_POST["linktitle1"]);
		update_post_meta($post->ID, "linktitle2", $_POST["linktitle2"]);
		update_post_meta($post->ID, "linktitle3", $_POST["linktitle3"]);
		update_post_meta($post->ID, "linktitle4", $_POST["linktitle4"]);
		update_post_meta($post->ID, "linktitle5", $_POST["linktitle5"]);
		update_post_meta($post->ID, "linktitle6", $_POST["linktitle6"]);
		update_post_meta($post->ID, "linktitle7", $_POST["linktitle7"]);
		update_post_meta($post->ID, "linktitle8", $_POST["linktitle8"]);
		update_post_meta($post->ID, "linktitle9", $_POST["linktitle9"]);
		update_post_meta($post->ID, "linktitle10", $_POST["linktitle10"]);

	}
}



// press options

function press_link(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom = get_post_custom($post->ID);

	$link1 = isset($custom["link1"][0]) ? $custom["link1"][0] : '';
		
?>

<input type="hidden" name="press_link_meta_nonce" value="<?php echo wp_create_nonce('press_link_meta');?>" />
<div class="custom_extras">


	<div class="row">
		<label for="link1">Link 'More Button' To:</label>
		<input type="text" id="link1" name="link1" value="<?php echo $link1; ?>" />
	</div>


</div>

<?php

}

add_action('save_post', 'press_link_save_extras');

function press_link_save_extras(){
	global $post;
	
	if(isset($_POST['press_link_meta_nonce'])){
		if (!wp_verify_nonce($_POST['press_link_meta_nonce'], 'press_link_meta')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post->ID, "link1", $_POST["link1"]);

	}
}

// team members options

/*

function teammember_meta_options(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom      = get_post_custom($post->ID);
	$role     = $custom["role"][0];
	$branch = $custom["branch"][0];
	$linkedin_url = $custom["linkedin_url"][0];
	$twitter_user = $custom["twitter_user"][0];
	
?>



<div class="custom_extras">

<?php
	$linkedin_url = ($linkedin_url == "") ? "http://" : $linkedin_url;
?>

	<div><label for="role">Role:</label><input name="role" value="<?php echo $role; ?>" /></div>
	<div><label for="branch">Branch:</label><input name="branch" value="<?php echo $branch; ?>" /></div>
	<div><label for="linkedin_url">Linkedin URL:</label><input id="linkedin_url" name="linkedin_url" value="<?php echo $linkedin_url; ?>" /></div>
	<div><label for="twitter_user">Twitter user:</label><input id="twitter_user" name="twitter_user" value="<?php echo $twitter_user; ?>" /></div>
</div>

<?php

}

add_action('save_post', 'teammember_save_extras');

function teammember_save_extras(){
	global $post;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	} else {
		update_post_meta($post->ID, "role", $_POST["role"]);
		update_post_meta($post->ID, "branch", $_POST["branch"]);
		update_post_meta($post->ID, "linkedin_url", $_POST["linkedin_url"]);
		update_post_meta($post->ID, "twitter_user", $_POST["twitter_user"]);
	}
}

add_filter("manage_edit-team-members_columns", "teammember_edit_columns");

function teammember_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Name",
		"role" => "Role",
		"branch" => "Branch"
	);
	return $columns;
}

add_action("manage_team-members_posts_custom_column", "teammember_custom_columns");

function teammember_custom_columns($column){
	global $post;
	$custom = get_post_custom();
	switch ($column)
		{
		case "role":
			echo $custom["role"][0];
			break;
		case "branch":
			echo $custom["branch"][0];
			break;
	}
}

*/


// page top content options


function page_topcontent(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom      = get_post_custom($post->ID);
	$topcontent_left = isset($custom["topcontent_left"][0]) ? $custom["topcontent_left"][0] : '';
	$topcontent_right = isset($custom["topcontent_right"][0]) ? $custom["topcontent_right"][0] : '';
	$topcontent_class = isset($custom["topcontent_class"][0]) ? $custom["topcontent_class"][0] : '';

	$colors = array(
				array(
					"class" => "purple",
					"name" => "Purple"
				),
				array(
					"class" => "dark-purple",
					"name" => "Dark purple"
				),
				array(
					"class" => "violet",
					"name" => "Violet"
				),
				array(
					"class" => "blue",
					"name" => "Light blue"
				),
				array(
					"class" => "red",
					"name" => "Plum"
				)
			);
	
?>

<input type="hidden" name="page_topcontent_nonce" value="<?php echo wp_create_nonce('page_topcontent');?>" />
<div class="custom_extras full-page">

	<div class="row clearfix">
		<div class="topcontent_left_box">
			<label for="topcontent_left">Left:</label><?php wp_editor( $topcontent_left, 'topcontent_left' ); ?>
		</div>
		<div class="topcontent_right_box">
			<label for="topcontent_right">Right:</label><?php wp_editor( $topcontent_right, 'topcontent_right' ); ?>
		</div>
	</div>

	<div class="clearfix">
		<label for="topcontent_class">Top content colour:</label>
		<select id="topcontent_class" name="topcontent_class">
			<option value="" data-color="">Select a colour</option>
			<?php 
				foreach($colors as $color): 
					$selected_class = ($color['class'] == $topcontent_class ? ' selected="selected"' : '');
			?>
				<option value="<?php echo $color['class']?>" <?php echo $selected_class?>><?php echo $color['name']?></option>
			<?php endforeach; ?>

		</select>
		<span id="topcontent_class_colorsample" class="<?php echo $topcontent_class?>">&nbsp;</span>

		<script type="text/javascript">
			jQuery('#topcontent_class').change(function(){
				var topcontent_class = jQuery('option:selected', this).val();
				jQuery('#topcontent_class_colorsample').removeClass().addClass(topcontent_class);
			});
		</script>

	</div>
</div>

<?php

}


add_action('save_post', 'topcontent_save_extras');

function topcontent_save_extras(){
	global $post;
	
	if(isset($_POST['page_topcontent_nonce'])){
		if (!wp_verify_nonce($_POST['page_topcontent_nonce'], 'page_topcontent')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post->ID, "topcontent_left", $_POST["topcontent_left"]);
		update_post_meta($post->ID, "topcontent_right", $_POST["topcontent_right"]);
		update_post_meta($post->ID, "topcontent_class", $_POST["topcontent_class"]);
	}
}




function page_extracontent(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		
	$custom      = get_post_custom($post->ID);
	$extracontent = isset($custom["extra_content"][0]) ? $custom["extra_content"][0] : '';
	
?>

<input type="hidden" name="page_extracontent_nonce" value="<?php echo wp_create_nonce('page_extracontent');?>" />
<div class="custom_extras full-page">

	<div class="row clearfix">
		<label for="extra_content">Partner Box Content:</label><?php wp_editor( $extracontent, 'extra_content' ); ?>
	</div>
</div>

<?php

}


add_action('save_post', 'page_extracontent_save_extras');

function page_extracontent_save_extras(){
	global $post;
	
	if(isset($_POST['page_extracontent_nonce'])){
		if (!wp_verify_nonce($_POST['page_extracontent_nonce'], 'page_extracontent')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta($post->ID, "extra_content", $_POST["extra_content"]);
	}
}



function load_externals(){
	?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/admin.css" />
	<script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>/';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
	
	<!--script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/admin.js"></script-->
    <?php
}

