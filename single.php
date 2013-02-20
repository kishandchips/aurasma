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

get_header(); ?>

<?php $page_id = '45'; ?>

<?php aurasma_content_top($page_id); ?>

<div id="main" class="site-main">
	<div class="container">

		<section id="category" class="fourteen column alpha">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php
				$post_id = $post->ID;
				$custom = get_post_custom($post_id);
				$show_links = (isset($custom["show_links"][0])) ? $custom["show_links"][0] : '';
			?>

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
						
						<span class="dark-grey news-back"><a href="#" onclick="history.go(-1)">&larr; Go Back</a></span>
							
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
					
					<?php the_content(); ?>
					
					<?php if($show_links == 'on') { ?>
					<ul class="foot-links">
						<li>
							<a href="#"><h3>Further Coverage</h3></a>
							<ul>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link1', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link1', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle1', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link2', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link2', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle2', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link3', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link3', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle3', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link4', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link4', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle4', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link5', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link5', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle5', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link6', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link6', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle6', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link7', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link7', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle7', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link8', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link8', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle8', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link9', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link9', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle9', true);?></a></li><?php } ?>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link10', true)){ ?><li><a href="<?php echo get_post_meta($post->ID, 'link10', true);?>" target="_blank"><?php echo get_post_meta($post->ID, 'linktitle10', true);?></a></li><?php } ?>
							</ul>
						</li>
					</ul>
					<?php } ?>

				</div>

			</article>
 

			<?php endwhile; else: ?>
				
				<p><?php _e('No posts were found. Sorry!'); ?></p>
				
			<?php endif; ?>

		</section>

		<?php get_sidebar('sidebar'); ?>

	</div>

	<?php get_footer(); ?>