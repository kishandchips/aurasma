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
 */

get_header(); ?>
	<div id="front-page">
	    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/plugins/jquery.scroll-carousel.js"></script>
		<div id="main" class="site-main">
		<?php 
        $custom_query = new WP_Query( array('post_parent' => $post->ID, 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'asc', 'posts_per_page' => -1) );
        ?>
        <?php if ( $custom_query->have_posts() ) : ?>
        	<div id="scroll-carousel" class="clearfix">

				<ul id="left-navigation" class="slide-navigation">
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
					<li><a class="slide-btn ir" data-id="<?php the_ID();?>"><?php the_title();?></a></li>
                	<?php endwhile;?>
				</ul>

				<ul id="slides-container">
					<?php
                    $i = 0;
                    while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
                        $image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
                    ?>
					<li class="slide-item" data-index="<?php echo $i; ?>" data-id="<?php the_ID(); ?>" data-url="<?php echo $post->post_name; ?>">
						<div class="content">
							<?php the_content(); ?>							
						</div>
						<div class="bg">
							<img class="slide-bg-image" src="<?php echo $image; ?>" />
						</div>

					</li>
					<?php $i++;?>
                	<?php endwhile;?>

				</ul>
				

<!-- 				<div id="bottom-navigation">
					<ul>
						<li class="seven column alpha">
							<h4 class="light-blue"><a href="auras/" class="light-blue">Explore</a></h4>
							<h5 class="grey">How to use Aurasma</h5>
						</li>
						<li data-id="3" class="eight column slide-btn">
							<h4 class="plum"><a href="partners/" class="plum">Partners</a></h4>
							<h5 class="grey">What can Aurasma do for you?</h5>
						</li>
						<li data-id="4" class="five column omega slide-btn">
							<h4 class="emerald"><a href="campaigns/" class="emerald">Campaigns</a></h4>
							<h5 class="grey">View the latest live Auras</h5>
						</li>
					</ul>

				</div> -->

			</div>
			<ul id="mobile-home-page">
			<?php
                    $i = 0;
                    while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
                        $image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
                    ?>
                    
					<li style="background: url('<?php echo $image; ?>');">
					 <?php the_content(); ?>
					</li>
					
			<?php $i++;?>
            <?php endwhile;?>		
			</ul>
	    <?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>