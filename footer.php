        </div>
        <footer id="footer">
          <div class="container">
            <div class="push-one four column alpha">
              <h5><?php _e( 'Augmented Reality', 'aurasma' ); ?></h5>
              <a href="/supported-devices/">
                <img src="<?php bloginfo( 'template_url' ); ?>/images/icon_smartphones.png" alt="Augmented reality" class="augmented-reality" />
							</a>
						</div>
						<div class="push-one five column">

							<h5><?php _e( 'Get the App', 'aurasma' ); ?></h5>
							<a class="app google" href="http://auras.ma/s/android" target="_blank">
								<img src="<?php bloginfo( 'template_url' ); ?>/images/icon_getit_google.png" alt="Get the App on Google Play" />
							</a>
							<a class="app store" href="http://auras.ma/s/ios" target="_blank">
								<img src="<?php bloginfo( 'template_url' ); ?>/images/icon_getit_appstore.png" alt="Get the App on the App Store" />
							</a>
						</div>
						<div class="push-one four column">
							<h5><?php _e( 'Follow us', 'aurasma' ); ?></h5>
							<a href="http://www.facebook.com/aurasma" title="Follow us on Facebook" class="facebook small-button" target="_blank">Facebook</a>
							<a href="http://twitter.com/aurasma/" title="Follow us on Twitter" class="twitter small-button" target="_blank">Twitter</a>
							<a href="http://www.youtube.com/user/AurasmaLite" title="Follow us on Youtube" class="youtube small-button" target="_blank">Youtube</a>
							<a href="http://pinterest.com/aurasma/" title="Follow us on Pinterest" class="pinterest small-button" target="_blank">Pinterest</a>
						</div>
						<div class="six column alpha">
							<h5><?php _e( 'Get the newsletter', 'aurasma' ); ?></h5>
							<?php echo do_shortcode('[gravityform id=2 title=false description=false]'); ?>
							
						</div>
					</div>
					<div class="container footer-bottom">
						<div class="floatleft">
							<small>&copy; <?php echo date('Y'); ?> Aurasma</small>
						</div>
						<div class="floatright">
						  <div class="fb-like" data-href="http://www.facebook.com/aurasma" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false" data-font="verdana"></div>
							<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
						</div>
					</div>
				</footer>
			
			</div>
		</div>

		<?php wp_footer(); ?>

		<div class="lightbox-overlay semi-purple-bg"></div>
		<div class="lightbox"></div>

	    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/all.js"></script>
	    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36931947-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

      </script>
	</body>
</html>