<?php
	get_header(); 
	global $post; 
?>
<div id="archive-press-item">
	<section id="top-content" class="red-border">
		<div class="container press-header">
	      <h2><?php $termname = $wp_query->queried_object->name; echo $termname; ?></h2>
	      <a class="button" href="/news">Back to News</a>
		</div>
	</section>

	<div id="main">
		<div class="container">
			<section id="posts" class="fourteen column alpha">
				<?php
				while ( have_posts() ) : the_post(); ?>
					
					<article class="clearfix post press-item">
						<div class="left press-image-holder"><?php the_post_thumbnail('press', array('class' => 'press-image'));?></div>
						
						<div class="left press-text">
							<h3><?php the_title();?></h3>
						    <span class="date"><?php the_time('d F y');?></span>
							<p><?php the_excerpt();?></p>
							<p>
								<?php if($myImageFileName = get_post_meta($post->ID, 'link1', true)){ ?>
									<a href="<?php echo get_post_meta($post->ID, 'link1', true);?>" class="button" target="_blank">More</a>
								<?php } else { ?>
									<a href="<?php the_permalink();?>" class="button">Read Article</a>
								<?php } ?>
							</p>
						</div>
						
					</article>	
					<hr />			
				<?php endwhile; ?>

				<div id="pagination_links">
				<?php echo custom_pagination_links(); ?>
				</div>
			</section>
			
			<?php get_sidebar('sidebar'); ?>
			  
		</div>
	</div>
</div>
<?php  get_footer(); ?>

