<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package aurasma
 * @since aurasma 1.0
 * 
 * Template Name: Page - Full Width
 *
 */

get_header(); ?>

<?php 
	global $post; 
	$page_id = $post->ID; 

	aurasma_content_top($page_id);
?>

	<div id="main" class="site-main">
		<div class="clearfix">
			<section id="category" class="twenty alpha omega">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>
			</section>
		</div>

<?php get_footer(); ?>