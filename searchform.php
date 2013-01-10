<?php
/**
 * The template for displaying search forms in editer
 *
 * @package aurasma
 * @since aurasma 1.0
 */
?>

	<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<input class="field" type="text" placeholder="<?php esc_attr_e( 'Search&hellip;', 'aurasma' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
		<input type="submit" class="submit" value="<?php _e( 'Search', 'aurasma' ); ?>" />
	</form>							
