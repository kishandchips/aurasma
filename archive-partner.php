<?php

/**
 * The Template for displaying all single posts.
 *
 * @package aurasma
 * @since aurasma 1.0
 */


get_header(); ?>


<?php $page_id = '113'; ?>

<div id="archive-partner">
	<section id="top-content" class="<?php echo(get_post_meta($page_id, 'topcontent_class', true)) ?>-border">
		<div class="container">

			<?php 
				echo do_shortcode(get_post_meta($page_id, 'topcontent_left', true)); 
				echo do_shortcode(get_post_meta($page_id, 'topcontent_right', true)); 
			?>

		</div>
	</section>

	<div id="main" class="site-main">
		<div class="clearfix">

			<section id="details" class="twenty alpha omega">
			</section>

			<section id="category" class="twenty alpha omega">
				<h3><?php _e('Our Partners Include:', 'aurasma') ?></h3>

				<?php echo build_partners_grid(); ?>

				<div id="pagination_links">
					<?php echo custom_pagination_links(); ?>
				</div>

			</section>

		</div>
	</div>
</div>
<?php get_footer(); ?>