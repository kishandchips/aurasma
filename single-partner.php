
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
	$page_id = '113';

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
	$external_url = $custom["external_url"][0];
	$case_study_url = $custom["case_study_url"][0];
	$youtube_video_id = $custom["youtube_video_id"][0];
	$logo = get_the_post_thumbnail($post->ID, 'partner_logo');
	$show_external_url = (isset($custom["show_external_url"][0])) ? $custom["show_external_url"][0] : 'on';
	$show_case_study_url = (isset($custom["show_case_study_url"][0])) ? $custom["show_case_study_url"][0] : 'on';
	$show_youtube_video_id = (isset($custom["show_youtube_video_id"][0])) ? $custom["show_youtube_video_id"][0] : 'on';


	if ($external_url != '' && $show_external_url){
		$external_url= '<a data-url="' . $post->post_name . '" class="external_url" href="' . $external_url . '" target="_blank">View this case study</a>';
	} 
	if ($case_study_url != '' && $case_study_url != 'http://' && $show_case_study_url){
		$case_study_url= '<a data-url="' . $post->post_name . '" class="download" href="' . $case_study_url . '" target="_blank">Download this case study <em>(PDF)</em></a>';
	} else {
		$case_study_url= "";
	}
	if($youtube_video_id != '' && $show_youtube_video_id){
		$youtube_video  = '<div class="post-media thirteen column omega">';
		$youtube_video .= $youtube_video_id;
		$youtube_video .= '</div>';
	} else {
		$youtube_video = '';
	}

	$prev_post = get_the_adjacent_casestudy_partner('prev');
	$next_post = get_the_adjacent_casestudy_partner('next');

?>

<article class="container single-partner">

	<div class="push-eighteen two column alpha omega close">
		<a href="#" class="close-button">
			Close
		</a>
	</div>		

	<div class="clearfix">
		<div class="post-text seven column alpha">
			<?php the_post_thumbnail('partner_logo'); ?>
			<h3 class="large"><?php the_title() ?></h3>
			<p><?php the_content(); ?></p>
			<?php echo($external_url) ?>
			<?php echo($case_study_url) ?>
		</div>
		<?php echo($youtube_video); ?>
	</div>

	<div class="seven column alpha">
		<a href="<?php echo(get_permalink($prev_post->ID)) ?>?ajax=true" data-url="<?php echo $prev_post->post_name; ?>" class="button prev">Previous case study</a>
	</div>
	<div class="push-eight five column omega">
		<a href="<?php echo(get_permalink($next_post->ID)) ?>?ajax=true" data-url="<?php echo $next_post->post_name; ?>" class="button next">Next case study</a>
	</div>

</article>

<?php 
	endwhile; 
endif;


if(!isset($_GET['ajax']) || $_GET['ajax'] != "true") {
	echo ('</div>');
	get_footer(); 
} 

?>

