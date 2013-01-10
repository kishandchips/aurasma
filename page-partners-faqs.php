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

<article class="container single-partner">

	<div class="push-eighteen two column alpha omega close">
		<a href="#" class="close-button">
			Close
		</a>
	</div>		

	<div class="clearfix">
		<div class="post-text partners-faqs">
			<h3 class="large faq"><?php the_title() ?></h3>
			<?php the_content(); ?>
		</div>
	</div>

</article>

<?php 
	endwhile; 
endif;


if(!isset($_GET['ajax']) || $_GET['ajax'] != true) {
	echo ('</div>');
	get_footer(); 
} 

?>

