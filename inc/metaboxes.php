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
	$show_case_study_url = isset($custom['show_case_study_url']) ? $custom["show_case_study_url"][0] : 'on';
	$show_external_url = isset($custom['show_external_url']) ? $custom["show_external_url"][0] : 'on';
	$show_youtube_video_id = isset($custom['show_youtube_video_id']) ? $custom["show_youtube_video_id"][0] : 'on';
	
?>

<input type="hidden" name="partner_meta_nonce" value="<?php echo wp_create_nonce('partner_meta');?>" />
<div class="custom_extras">

<?php
	$case_study_url = ($case_study_url == "") ? "http://" : $case_study_url;
	$show_case_study_url_checked = (($show_case_study_url) ? 'checked="checked"' : '');
	$show_external_url_checked = (($show_external_url) ? 'checked="checked"' : '');
	$show_youtube_video_id_checked = (($show_youtube_video_id) ? 'checked="checked"' : '');
?>

	<div class="row clearfix">
		<label for="has_casestudy" class="checkbox">Case Study:</label>
		<input type="checkbox" id="has_casestudy" name="has_casestudy" <?php echo $has_casestudy_checked; ?> />
	</div>
	<div <?php if($has_casestudy_checked == ''): ?>class="hidden"<?php endif; ?>>
		<div class="row casestudy ">
			<label for="case_study_url">PDF Download Link: <input type="checkbox" name="show_case_study_url" title="Show PDF Link" <?php echo $show_case_study_url; ?> /></label>
			<input id="case_study_url" name="case_study_url" type="text" value="<?php echo $case_study_url; ?>" />
		</div>
		<div class="row">
			<label for="external_url">External URL: <input type="checkbox" name="show_external_url" title="Show External Url" <?php echo $show_external_url; ?> /></label>
			<input id="external_url" name="external_url" type="text" value="<?php echo $external_url; ?>" />
		</div>
		<div class="row">
			<label for="youtube_video_id">Video/Image embed code: <input type="checkbox" name="show_youtube_video_id" title="Show Video/Image" <?php echo $show_youtube_video_id; ?> /></label>
			<textarea id="youtube_video_id" name="youtube_video_id"><?php echo $youtube_video_id; ?></textarea><br />
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

		if($_POST["show_case_study_url"]) { $show_case_study_url = 'on'; } else { $show_case_study_url = ''; };
		update_post_meta($post->ID, "show_case_study_url", $show_case_study_url);

		if($_POST["show_external_url"]) { $show_external_url = 'on'; } else { $show_external_url = ''; };
		update_post_meta($post->ID, "show_external_url", $show_external_url);
		if($_POST["show_youtube_video_id"]) { $show_youtube_video_id = 'on'; } else { $show_youtube_video_id = ''; };
		update_post_meta($post->ID, "show_youtube_video_id", $show_youtube_video_id);
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
	$show_release_date = isset($custom["show_release_date"][0]) ? $custom["show_release_date"][0] : 'on';
	$show_vid = isset($custom['show_vid']) ? $custom["show_vid"][0] : 'on';
	$show_channel = isset($custom['show_channel']) ? $custom["show_channel"][0] : 'on';
	$show_links = isset($custom['show_links']) ? $custom["show_links"][0] : 'on';
		
?>

<input type="hidden" name="campaign_meta_nonce" value="<?php echo wp_create_nonce('campaign_meta');?>" />
<div class="custom_extras">

<?php
	$website_url = ($website_url == "") ? "http://" : $website_url;
	$is_latest_checked = (($is_latest) ? 'checked="checked"' : '');
	$show_release_date_checked = (($show_release_date) ? 'checked="checked"' : '');
	$show_vid_checked = (($show_vid) ? 'checked="checked"' : '');
	$show_channel_checked = (($show_vid) ? 'checked="checked"' : '');
	$show_links_checked = (($show_links) ? 'checked="checked"' : '');

?>

	<div class="row">
		<label for="release_date">Release date: <input type="checkbox" name="show_release_date" title="Show Release Date" <?php echo $show_release_date_checked; ?> /></label>
		<input type="text" id="release_date"name="release_date" value="<?php echo $release_date; ?>" />
	</div>
	
	<div class="row">
		<label for="channel">Channel (Follow this Aura): <input type="checkbox" name="show_channel" title="Show Channel" <?php echo $show_channel_checked; ?> /></label>
		<input type="text" id="channel" name="channel" value="<?php echo $channel; ?>" />
	</div>

	<div class="row">
		<label for="website_url">Video URL: <input type="checkbox" name="show_vid" title="Show Video" <?php echo $show_vid_checked; ?> /></label>
		<input type="text" id="website_url" name="website_url" value="<?php echo $website_url; ?>" />
	</div>
	
	<div class="row clearfix">
		<label for="is_latest" class="checkbox">Latest Campaign:</label>
		<input type="checkbox" id="is_latest" name="is_latest" <?php echo $is_latest_checked; ?> />
	</div>
	
	<div class="row clearfix">
		<label for="show_links" class="checkbox">Show Further Coverage Links?:</label>
		<input type="checkbox" id="show_links" name="show_links" <?php echo $show_links_checked; ?> />
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
		if($_POST["show_release_date"]) { $show_release_date = 'on'; } else { $show_release_date = ''; };
		update_post_meta($post->ID, "show_release_date", $show_release_date);
		if($_POST["show_channel"]) { $show_channel = 'on'; } else { $show_channel = ''; };
		update_post_meta($post->ID, "show_channel", $show_channel);
		if($_POST["show_links"]) { $show_links = 'on'; } else { $show_links = ''; };
		update_post_meta($post->ID, "show_links", $show_links);

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

