<?php

/**
 * The Template for displaying all single posts.
 *
 * @package aurasma
 * @since aurasma 1.0
 */

get_header(); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-508ab989208cc6c0"></script>
<?php if(is_tax('campaign-category')) echo'<div id="archive-campaign">';?>

<section id="slider" class="violet-border">
	<div class="container">
		<hgroup>
			<h2><?php _e('Latest campaigns', 'aurasma'); ?></h2>
			<h3><?php _e("What's hot on Aurasma right now:", 'aurasma'); ?></h3>
		</hgroup>

		<?php echo build_campaign_slider() ?>

	</div>
</section>

<div id="main" class="site-main">
	<div class="clearfix">
			
		<section id="category" class="twenty alpha omega">

			<?php

				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			?>

			<h2><?php echo $term->name; ?></h2>

			<?php echo get_campaign_labels('campaign-category', 'Category:', 'orderby=count&order=DESC&hide_empty=0', $term->slug); ?>
			<?php echo get_campaign_labels('region', 'Region:', 'orderby=count&order=DESC&hide_empty=0', $term->slug) ?>

			<?php echo build_campaigns_grid(20); ?>
			<div id="pagination_links">
				<?php echo custom_pagination_links(); ?>
			</div>

			<!-- <div class="thumbnails">

				<?php 
					$i = 0;
					while ( have_posts() ) : the_post(); 

						$campaigns_per_full_row = 5;
						$campaign_thumb = get_the_post_thumbnail($post->ID, 'thumbnail');
						$i++;
						$post_position = $i % $campaigns_per_full_row;


						switch( $post_position ) {


							case 0:
								$post_class = "post four column omega";
								break;
							case 1:
								$post_class = "post four column alpha";
								break;
							default:
								$post_class = "post four column";
								break;
						}

				?>

				<div class="<?php echo($post_class) ?>">
					<a href="<?php the_permalink(); ?>?ajax=true" class="lightbox-btn" title="<?php the_title(); ?>">
						<?php echo($campaign_thumb); ?>
					</a>
				</div>

				<?php endwhile; // end of the loop. ?>

			</div>
 -->
		</section>

	</div>	
<?php if(is_tax('campaign-category')) echo'</div>';?>
<?php get_footer(); ?>