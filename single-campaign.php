
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package aurasma
 * @since aurasma 1.0
 *
 */
	$page_id = '32';

	if(!isset($_GET['ajax']) || $_GET['ajax'] != "true"):
		get_header(); 
		aurasma_content_top($page_id); 
?>
<div id="main">

<?php endif; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
	$post_id = $post->ID;
	$custom = get_post_custom($post_id);
	$release_date = (isset($custom["release_date"][0])) ? $custom["release_date"][0] : '';
	$channel = (isset($custom["channel"][0])) ? $custom["channel"][0] : '';
	$website_url = (isset($custom["website_url"][0])) ? $custom["website_url"][0] : '';
	$big_image = get_the_post_thumbnail($post->ID, 'campaign_full');
	$show_vid = (isset($custom["show_vid"][0])) ? $custom["show_vid"][0] : 'on';
	$show_release_date = (isset($custom["show_release_date"][0])) ? $custom["show_release_date"][0] : 'on';
	$show_channel = (isset($custom["show_channel"][0])) ? $custom["show_channel"][0] : 'on';
	$show_links = (isset($custom["show_links"][0])) ? $custom["show_links"][0] : 'on';

	// if ($case_study_url != '' || $case_study_url != 'http://'){
	// 	$case_study_url= '<a class="download" href="' . $case_study_url . '" target="_blank">Download this case study <em>(PDF)</em></a>';
	// } else {
	// 	$case_study_url= '';
	// }
	if($release_date != '' && $show_release_date == 'on'){
		$release_date  = '<h5 class="post-item">Released ' . $release_date . '</h5>';
	}
	if(($channel != '') && $show_channel == 'on'){
		$channel  = '<h5 class="post-item" title="Search '.$channel.' within the Aurasma app"><a title="Follow this Aura" href="'.get_bloginfo('url').'/?s='.$channel.'">Follow this Aura in app: <span class="channel">'.$channel.'</span></a<</h5>';
	}

	if($website_url != '' && $website_url != 'http://' && $show_vid == 'on'){
		$website_url  = '<li><a href="'. $website_url . '" target="_blank">Watch the Video</a></li>';
	} else {
		$website_url = '';
	}

	$campaign_types = get_the_terms( $post_id, 'campaign-type' );
	$campaign_regions = get_the_terms( $post_id, 'region' );
	$regions = '';
	
	if($campaign_regions){
		foreach($campaign_regions as $region){
			if($region->name){
				$regions .= $region->name . "/";
			}
		}
		$regions = substr($regions, 0, -1);
	}
?>


<body id="single-campaign" class="lightbox">

	<article class="container campaign">

		<div class="push-eighteen two column alpha omega close">
			<a class="close-button">Close</a>
		</div>		

		<div class="clearfix">

			<div class="post-text six column alpha">
				
				<hgroup>
					<h2 class="post-title"><?php the_title() ?></h2>
					<?php echo($release_date) ?>
				</hgroup>

				<p><?php the_content() ?>

				<footer class="single-footer">
					<div class="foot-meta">
						<?php if ($regions): ?>
						<h5 class="post-item">Regions: <span><?php echo $regions ?></span></h5>
						<?php endif; ?>
						<?php echo($channel); ?>
						
							<ul class="foot-links">

								<?php if($show_links == 'on') { ?>
								<li class="drop">
									<a href="#">Further Coverage</a>
									<ul>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link1', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link1', true);?>"><?php echo get_post_meta($post->ID, 'linktitle1', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link2', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link2', true);?>"><?php echo get_post_meta($post->ID, 'linktitle2', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link3', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link3', true);?>"><?php echo get_post_meta($post->ID, 'linktitle3', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link4', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link4', true);?>"><?php echo get_post_meta($post->ID, 'linktitle4', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link5', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link5', true);?>"><?php echo get_post_meta($post->ID, 'linktitle5', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link6', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link6', true);?>"><?php echo get_post_meta($post->ID, 'linktitle6', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link7', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link7', true);?>"><?php echo get_post_meta($post->ID, 'linktitle7', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link8', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link8', true);?>"><?php echo get_post_meta($post->ID, 'linktitle8', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link9', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link9', true);?>"><?php echo get_post_meta($post->ID, 'linktitle9', true);?></a></li><?php } ?>
										<?php if($myImageFileName = get_post_meta($post->ID, 'link10', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link10', true);?>"><?php echo get_post_meta($post->ID, 'linktitle10', true);?></a></li><?php } ?>
									</ul>
								</li>
								
								<?php if($show_vid == 'on') echo $website_url; ?>
							</ul>
						
					</div>
					<div class="share">
						<h3 class="post-item">Share this:</h3>

						<div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php the_permalink(); ?>" addthis:title="<?php the_title(); ?>">
							<a class="addthis_button_facebook" />
							<a class="addthis_button_twitter"></a>
							<a class="addthis_button_email"></a> 
							<a class="addthis_button_print"></a> 
							<a class="addthis_button_compact"></a>
							<a class="addthis_counter addthis_bubble_style"></a>
						</div>
						<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50c719743abcf159"></script>
					</div>

					<div class="get">
						<h3 class="post-item">Get the App:</h3>
						<a class="app google" href="#" target="_blank">
							<img src="<?php bloginfo( 'template_url' ); ?>/images/icon_getit_google_big.png" alt="Get the App on Google Play" />
						</a>
						<a class="app store" href="#" target="_blank">
							<img src="<?php bloginfo( 'template_url' ); ?>/images/icon_getit_appstore_big.png" alt="Get the App on the App Store" />
						</a>
					</div>
				</footer>

			</div>

			<div class="post-media fourteen column omega">
				<?php echo($big_image) ?>
			</div>

		</div>

	</article>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-508ab989208cc6c0"></script>
<script type="text/javascript"> addthis.toolbox('.addthis_toolbox'); </script>
<script>
$('.drop ul').hide();
$('.drop > a').click(function(e){
	e.preventDefault();
	$('.drop ul').slideToggle();
});

</script>
</body>

<?php 
	endwhile; 
endif;

if(!isset($_GET['ajax']) || $_GET['ajax'] != "true") {
	echo ('</div>');
	get_footer(); 
} 

?>