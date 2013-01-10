
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package aurasma
 * @since aurasma 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- <meta name="viewport" content="width=device-width" /> -->
	<title><?php wp_title( '&mdash;', true, 'right' ); ?></title>

	<link href="<?php bloginfo( 'template_url' ); ?>/css/ipadP.css" rel="stylesheet" media="only screen and (device-width:  768px) and (orientation: portrait)">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/style-ie.css" />
	<script src="<?php bloginfo( 'template_url' ); ?>/js/plugins/html5shiv.js"></script><![endif]-->
	<!--[if (gt IE 8)|!(IE)]><!--><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/style.css" /><!--<![endif]-->
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
    
    
    
    
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    
    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
		var currUrl = '<?php echo current_url(); ?>';
	</script>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/libs/modernizr.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php bloginfo( 'template_url' ); ?>/js/libs/jquery.1.8.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/plugins/jquery.plugins.js"></script>
	<script src="<?php bloginfo( 'template_url' ); ?>/js/libs/css_browser_selector.js" type="text/javascript"></script>
<?php 
	wp_head(); 
	global $wp_query;
	$page_id = (isset($wp_query->post->ID)) ? $wp_query->post->ID : '';
?>

</head>


<body id="<?php print_body_id($page_id) ?>" <?php body_class(); ?>>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>


	<header id="header" class="site-header" role="banner">

		<div class="container">

			<h1 class="three column alpha logo-container">
				<a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
			</h1>

			<div class="push-four thirteen column omega alignright">

				<div class="column right omega search">
					<?php get_search_form(); ?>
				</div>
					<br/>
				<nav class="site-navigation main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix', 'container' => false ) ); ?>
				</nav>

			</div>

		</div>

	</header>
	<div id="page">

