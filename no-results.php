<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package aurasma
 * @since aurasma 1.0
 */

?>

		<h3 class="gotham-book violet"><?php _e('Nothing found', 'aurasma'); ?></h3>

	<?php if ( is_home() ) : ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'editer' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'editer' ); ?></p>

	<?php else : ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'editer' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
