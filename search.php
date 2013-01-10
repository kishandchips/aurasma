<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package aurasma
 * @since aurasma 1.0
 */

get_header(); ?>


	<section id="top-content" class="red-border">
		<div class="container">


		<?php if ( have_posts() ) : ?>

			<h2><?php _e('Search Results', 'aurasma'); ?></h2>

		<?php else: ?>

			<h2><?php _e('Nothing found', 'aurasma'); ?></h2>

		<?php endif; ?>

			<?php get_search_form(); ?>

		</div>
	</section>

	<div id="main" class="site-main">
		<div class="container">

			<section id="category" class="fourteen column alpha">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article class="post">

					<div class="no-featured-image">

						<div class="post-title">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</div>

					</div>

					<div class="post-text">

						<?php if ( 'post' == get_post_type() || $post->post_excerpt ):  ?>

							<h3><?php echo get_the_excerpt(); ?></h3>

						<?php endif; ?>

						
						<p>...<?php echo substr(strip_tags(get_the_content($post->ID)), 0, 200); ?>...</p>

					</div>

				</article>

				<?php endwhile; ?>

				<div id="pagination_links">
					<?php echo custom_pagination_links(); ?>
				</div>


			<?php else : ?>

				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>

			</section>

			<?php get_sidebar('sidebar'); ?>

		</div>

		<?php get_footer(); ?>