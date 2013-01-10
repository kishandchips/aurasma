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

get_header(); 

$page_id = '45'; ?>


<section id="top-content" class="red-border">
	<div class="container">

		<?php 
			echo do_shortcode(get_post_meta($page_id, 'topcontent_left', true)); 
			echo do_shortcode(get_post_meta($page_id, 'topcontent_right', true)); 
		?>

	</div>
</section>

<div id="main" class="site-main">
	<div class="container">

		<section id="category" class="fourteen column alpha">

			<?php if (is_category()): ?>

			<h3><?php
				printf( __( 'Category Archives: %s', 'aurasma' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			?></h3>

			<?php
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
			?>


			<?php endif; ?>
			
			<?php
			if (is_home()) {
			  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts( "cat=-3,-4,-5&paged=$paged" );
			}
			?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article class="post">

				<div class="featured-image">

					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) { ?> 
							<?php the_post_thumbnail('news_post_image'); ?>
						<?php } else { ?>
							<img src="/wp-content/uploads/Aurasma_WhatsYourAura_crop-666x290.jpg" alt="<?php the_title();?>"/>
						<?php } ?>
					</a>

					<div class="post-title">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</div>

				</div>

				<div class="post-text">

					<div class="post-meta">

						<span class="date dark-grey"><?php the_time(get_option('date_format')); ?></span>
						
						<?php if ( 'post' == get_post_type() ) :  ?>
						<?php
							$categories_list = get_the_category_list( __( ', ', 'aurasma' ) );
							if ( $categories_list ):
						?>
						<span class="cat-links">
							<span class="the-category"><?php _e('Posted in', 'aurasma') ?> <?php echo($categories_list) ?></span>
							<?php $show_sep = true; ?>
						</span>
						<?php 
							endif; 
						endif;
						?>

					</div>

					<?php echo get_the_excerpt(); ?>
					<br/>
					<p><a href="<?php the_permalink(); ?>">Read More &rarr;</a></p>
					<?php //the_content(); ?>
				</div>

			</article>

			<div id="pagination_links">
				<?php echo custom_pagination_links(); ?>
			</div>

			<?php endwhile; ?>

			<?php else: ?>
				
				<p><?php _e('No posts were found. Sorry!'); ?></p>
				
			<?php endif; ?>

		</section>

		<?php get_sidebar('sidebar'); ?>

	</div>

</div>

<?php get_footer(); ?>