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
 */

	if(!isset($_GET['ajax']) || $_GET['ajax'] != "true"):
		get_header(); 
		global $post; 
		aurasma_content_top($post->ID);
?>
<div id="main">
	<div class="container">

<?php else: ?>

	<div class="container">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>

		</div>


<?php 

if(!isset($_GET['ajax']) || $_GET['ajax'] != "true") {
	echo ('</div>');
	get_footer(); 
} 

?>

