<?php
	get_header(); 
	global $post; 
?>

<section id="top-content">
	<div class="container">

		<?php 
			echo do_shortcode(get_post_meta($page_id, 'topcontent_left', true)); 
			echo do_shortcode(get_post_meta($page_id, 'topcontent_right', true)); 
		?>

	</div>
</section>

<div id="press-releases">
	<div id="main">
		<div class="container">
			<ul class="press-releases">
			  <?php
  			if (is_home()) {
  				query_posts( "cat=2" );
  			}
  			?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<li class="clearfix">
						<div class="floatleft press-image-holder"><?php the_post_thumbnail('press', array('class' => 'press-image'));?></div>
						
						<div class="floatleft press-text">
							<h3><?php the_title();?></h3>
						    <span class="date"><?php the_time('d F y');?></span>
							<p><?php the_excerpt();?></p>
							<p><a href="<?php the_permalink();?>" class="button">More</a></p>
						</div>
					</li>
					
					<hr />
				<?php endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>

<?php  get_footer(); ?>

