<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package aurasma
 * @since aurasma 1.0
 */

get_header(); ?>

<section id="top-content" class="red-border">
	<div class="container">

		<h2><?php _e('Not found', 'aurasma'); ?></h2>

	</div>
</section>

<div id="main" class="site-main">
	<div class="container">


		<h3 class="gotham-book violet"><?php _e('Page not found', 'aurasma'); ?></h3>

		<p class="gotham-book big"><?php _e('Sorry, the page you are looking for does not exist.', 'aurasma'); ?></p>

		<a class="button prev" href="<?php echo get_bloginfo('url') ?>"><?php _e('Back to home', 'aurasma'); ?></a>


	</div>

<?php get_footer(); ?>