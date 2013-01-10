<?php

/**
 * The Template for displaying all single posts.
 *
 * @package aurasma
 * @since aurasma 1.0
 */

get_header(); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-508ab989208cc6c0"></script>
<div id="archive-campaign">

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

				<h2><?php _e('More campaigns', 'aurasma'); ?></h2>
				<h3><?php _e('Have you tried these yet?', 'aurasma'); ?></h3>

				<?php echo get_campaign_labels('campaign-category', 'Category:'); ?>
				<?php echo get_campaign_labels('region', 'Region:') ?>

				<?php echo build_campaigns_grid(); ?>

				<div id="pagination_links">
					<?php echo custom_pagination_links(); ?>
				</div>

			</section>

		</div>	
	</div>
</div>
<?php get_footer(); ?>