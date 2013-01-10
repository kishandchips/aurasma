<?php
/**
 * aurasma functions and definitions
 *
 * @package aurasma
 * @since aurasma 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since aurasma 1.0
 */

if ( ! function_exists( 'aurasma_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since aurasma 1.0
 */
function aurasma_setup() {
	global $wp_query;
	require( get_template_directory() . '/inc/post_types.php' );

	require( get_template_directory() . '/inc/metaboxes.php' );

	require( get_template_directory() . '/inc/shortcodes.php' );

	require( get_template_directory() . '/inc/options.php' );
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on aurasma, use a find and replace
	 * to change 'aurasma' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'aurasma', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 176, 176, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary navigation', 'aurasma' ),
		'footer' => __( 'Footer navigation', 'aurasma' )
	) );



	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'campaign_full', 666, 9999, false);
		add_image_size( 'partner_logo', 140, 140, false);
		add_image_size( 'custom_thumbnail', 176, 176, false);
		add_image_size( 'news_post_image', 666, 9999, false);
	}

}
endif; // aurasma_setup
add_action( 'after_setup_theme', 'aurasma_setup' );



/**
 * Remove admin menu and meta items
 *
 * @since aurasma 1.0
 */
add_action( 'admin_menu', 'my_remove_menus_and_metas', 999 );

function my_remove_menus_and_metas() {
	remove_menu_page( 'link-manager.php' );
	remove_menu_page( 'edit-comments.php' );
	remove_meta_box( 'pageparentdiv', 'campaign', 'side' );
	remove_meta_box( 'pageparentdiv', 'partner', 'side' );
}





/**
 * Tweak posts per page based on archive type
 *
 * @since aurasma 1.0
 */

add_filter('pre_get_posts', 'per_archive_basis');

function per_archive_basis($query){
	if ($query->is_post_type_archive || $query->is_tax) {
		if (is_post_type_archive('partner')){
			$query->set('posts_per_page', 24);
		} else if (is_post_type_archive('campaign') || (is_tax() && is_post_type_archive('campaign'))){
			$query->set('posts_per_page', 20);
		}
	}
	if ($query->is_search) {
		$query->set('posts_per_page', 5);
	}
	return $query;
}

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since aurasma 1.0
 */
function aurasma_widgets_init() {
	register_sidebar( array(
		'name' => __( 'News Sidebar', 'aurasma' ),
		'id' => 'sidebar',
		'class' => 'push-one widget-area five column omega',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}

add_action( 'widgets_init', 'aurasma_widgets_init' );


function get_the_adjacent_fukn_post($adjacent, $post_type = 'post', $category = array(), $post_parent = 0){
	global $post;
	$args = array( 
		'post_type' => $post_type,
		'order' => 'ASC',
		'posts_per_page' => -1,
		'category__in' => $category,
		'post_parent' => $post_parent
	);
	
	$curr_post = $post;
	$new_post = NULL;
	$custom_query = new WP_Query($args);

	$posts = $custom_query->get_posts();

	$total_posts = count($posts);
	$i = 0;
	foreach($posts as $a_post) {
		if($a_post->ID == $curr_post->ID){
			if($adjacent == 'next'){
				$new_i = ($i + 1 >= $total_posts) ? 0 : $i + 1; 
				$new_post = $posts[$new_i];	
			} else {
				$new_i = ($i - 1 <= 0) ? $total_posts - 1 : $i - 1; 
				$new_post = $posts[$new_i];	
			}
			break;	
		}
		$i++;
	}
	wp_reset_postdata();
	return $new_post;
}



function get_the_adjacent_casestudy_partner($adjacent){
	global $post;
	$curr_post = $post;
	$new_post = NULL;

	global $wpdb;
	$custom_query = "
		SELECT $wpdb->posts.* 
		FROM $wpdb->posts, $wpdb->postmeta
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
		AND $wpdb->postmeta.meta_key = 'has_casestudy' 
		AND $wpdb->postmeta.meta_value = 'on' 
		AND $wpdb->posts.post_status = 'publish' 
		AND $wpdb->posts.post_type = 'partner'
		ORDER BY $wpdb->posts.post_date ASC
	";

	$posts = $wpdb->get_results($custom_query, OBJECT);

	$total_posts = count($posts);

	if($total_posts) {
		$i = 0;
		foreach($posts as $a_post) {


			if($a_post->ID == $curr_post->ID){
				if($adjacent == 'next'){
					$new_i = ($i + 1 >= $total_posts) ? 0 : $i + 1; 
					$new_post = $posts[$new_i];	
				} else {
					$new_i = ($i - 1 < 0) ? $total_posts - 1 : $i - 1; 
					$new_post = $posts[$new_i];	
				}
				break;	
			} 
			$i++;
		}
	} else {
		$new_post = $curr_post;
	}

	return $new_post;
}




function get_aurasma_option($option){
	$options = get_option('aurasma_theme_options');
	return $options[$option];
}

if ( ! function_exists( 'array_insert' )) {
	function array_insert(&$array,$element,$position=null) {
		if (count($array) == 0) {
			$array[] = $element;
		} elseif (is_numeric($position) && $position < 0) {
			if((count($array)+position) < 0) {
				$array = array_insert($array,$element,0);
			} else {
				$array[count($array)+$position] = $element;
			}
		} else if (is_numeric($position) && isset($array[$position])) {
			$part1 = array_slice($array,0,$position,true);
			$part2 = array_slice($array,$position,null,true);
			$array = array_merge($part1,array($position=>$element),$part2);
			foreach($array as $key=>$item) {
				if (is_null($item)) {
					unset($array[$key]);
				}
			}
		} else if (is_null($position)) {
			$array[] = $element;
		} else if (!isset($array[$position])) {
			$array[$position] = $element;
		}
		$array = array_merge($array);
		return $array;
	}
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @since aurasma 1.0
 */

function aurasma_add_body_class( $classes ){
	// Adds a class of group-blog to blogs with more than 1 published author
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter( 'body_class', 'aurasma_add_body_class' );


if ( ! function_exists( 'aurasma_content_top' ) ):
/**
 * Display top content - if top content is not present, page title will be displayed
 *\
 * @since aurasma 1.0
 */

function aurasma_content_top( $page_id ) {

	if(get_post_meta($page_id, 'topcontent_left', true) || get_post_meta($page_id, 'topcontent_right', true)):

	?>

	<section id="top-content" class="<?php echo get_post_meta($page_id, 'topcontent_class', true) ?>-border">
		<div class="container">

			<?php echo do_shortcode(get_post_meta($page_id, 'topcontent_left', true)); ?>

			<?php echo do_shortcode(get_post_meta($page_id, 'topcontent_right', true)); ?>

		</div>
	</section>

	<section id="details" class="twenty alpha omega">
	</section>

	<?php else: ?>

	<section id="top-content" class="purple-border">
		<div class="container">

			<?php the_title('<h2>', '</h2>', $page_id) ?>

		</div>
	</section>

	<?php 
		endif; 
	}
endif;


function custom_pagination_links(){

	global $wp_query;
	$big = 999999999;
	$args = array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'show_all' => true,
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	);

	echo paginate_links( $args );
}


/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies() {
	register_taxonomy('campaign-category', array('campaign'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Campaign Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Campaign Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Campaign Categories' ),
			'all_items' => __( 'All Campaign Categories' ),
			'parent_item' => __( 'Parent Campaign Category' ),
			'parent_item_colon' => __( 'Parent Campaign Category:' ),
			'edit_item' => __( 'Edit Campaign Category' ),
			'update_item' => __( 'Update Campaign Category' ),
			'add_new_item' => __( 'Add New Campaign Category' ),
			'new_item_name' => __( 'New Campaign Category Name' ),
			'menu_name' => __( 'Campaign Categories' ),
		),

		'rewrite' => array(
			'slug' => 'campaign-category', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));

	register_taxonomy('region', array('campaign'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Regions', 'taxonomy general name' ),
			'singular_name' => _x( 'Region', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Regions' ),
			'all_items' => __( 'All Regions' ),
			'parent_item' => __( 'Parent Region' ),
			'parent_item_colon' => __( 'Parent Region:' ),
			'edit_item' => __( 'Edit Region' ),
			'update_item' => __( 'Update Region' ),
			'add_new_item' => __( 'Add New Region' ),
			'new_item_name' => __( 'New Region Name' ),
			'menu_name' => __( 'Regions' ),
		),
		'rewrite' => array(
			'slug' => 'region', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));
	

	register_taxonomy('press', array('press-item'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Press Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Region', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Press Categories' ),
			'all_items' => __( 'All Press Categories' ),
			'parent_item' => __( 'Parent Press Category' ),
			'parent_item_colon' => __( 'Parent Press Category:' ),
			'edit_item' => __( 'Edit Press Category' ),
			'update_item' => __( 'Update Press Category' ),
			'add_new_item' => __( 'Add New Press Category' ),
			'new_item_name' => __( 'New Press Category Name' ),
			'menu_name' => __( 'Press Categories' ),
		),
		'rewrite' => array(
			'slug' => 'press/category', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));

	//flush_rewrite_rules();
}
add_action( 'init', 'add_custom_taxonomies', 0 );






/* function to print taxonomy labels for campaigns */

function get_campaign_labels($taxonomy, $heading, $atts = 'orderby=count&order=DESC&hide_empty=0', $current = ''){

	$terms = get_terms( $taxonomy, $atts );
	$total_posts = wp_count_posts('campaign');
	$output  = '<div class="categories container">'; 

	$output .= '<div class="heading column two alpha">';
	$output .= '<p class="no-margin gotham-light">'. $heading .'</p>';
	$output .= '</div>';

	$output .= '<ul class="labels column eighteen">';
	$labels = '';
	foreach( $terms as $term ){
		if($term->count > 0){

			$current_class = ($current == $term->slug) ? ' class="active"' : '';

			$labels .= '<li' . $current_class . '>';
			$labels .= '<a href="'. get_bloginfo('url') . "/" . $term->taxonomy .'/' . $term->slug . '">';
			$labels .= '<strong>'. $term->name .'</strong>';
			$labels .= '</a>';
			$labels .= '</li>';
		}	
	}

	if( 'Region:' != $heading ){
		$output .= '<li>';
		$output .= '<a href="'. get_bloginfo('url') .'/campaigns">';
		$output .= '<strong>All</strong>';
		$output .= '</a>';
		$output .= '</li>';
	}

	return $output . $labels . '</ul></div>';

}



/* function to print a custom body or div id based on page/post type */

function print_body_id($page_id) {

	if( is_page($page_id) ){
		$body_id = get_query_var('name');
	} else if ( is_front_page() ){
		$body_id = 'home';
	} else if ( is_single() || is_home() || is_search() || is_category() ){
		$body_id = 'news';
	} else if ( is_404() ){
		$body_id = 'not-found';
	} else if ( is_post_type_archive() ){
		$body_id = sanitize_title_with_dashes(post_type_archive_title(null, false));
		//$body_id = 'archive-' . sanitize_title_with_dashes(post_type_archive_title(null, false));
	} else if ( is_tax('campaign-category') ){
		$body_id = 'campaigns';
		//$body_id = 'archive-campaigns';
	} else if ( is_tax('region') ){
		$body_id = 'campaigns';
		//$body_id = 'archive-campaigns';	
	} else {
		$body_id = '';
	}

	echo strtolower($body_id);

}

/* function to build 'latest campaigns' slider */

function build_campaign_slider(){

	global $wpdb;

	$querystr = "
		SELECT $wpdb->posts.* 
		FROM $wpdb->posts, $wpdb->postmeta
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
		AND $wpdb->postmeta.meta_key = 'is_latest' 
		AND $wpdb->postmeta.meta_value = 'on' 
		AND $wpdb->posts.post_status = 'publish' 
		AND $wpdb->posts.post_type = 'campaign'
		ORDER BY $wpdb->posts.post_date DESC
	";

	$pageposts = $wpdb->get_results($querystr, OBJECT);


	//query_posts( array( 'post_type' => 'campaign', 'is_latest' => 'on' ) );

	$output  = '<div id="gallery-wrap">';
	$output .= '<ul id="gallery">';

	if ($pageposts):
		global $post;
		foreach ($pageposts as $post):
			setup_postdata($post);

			$slug = $post->post_name;
			$output .= '<li><a data-url="' . $slug . '" class="lightbox-btn" href="'. get_permalink() .'?ajax=true">'. get_the_post_thumbnail($post->ID, 'thumbnail') . '</a></li>';

		endforeach; 

		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div id="gallery-controls">';
		$output .= '<a href="#" id="gallery-prev"><img src="' . get_bloginfo('template_url') . '/images/icon_prev_big.png" alt="" /></a>';
		$output .= '<a href="#" id="gallery-next"><img src="' . get_bloginfo('template_url') . '/images/icon_next_big.png" alt="" /></a>';
		$output .= '</div>';

	endif; wp_reset_query();

	return $output;

}


/**
 * Prints the partners grid in partners archive.
 *
 *	int 	$partners_posts_per_page 	default: 21		n. of posts per archive page.
 *	int 	$partners_left_box 			default: 6		n. of cells in the box on the side of the extra square
 *	int 	$partners_per_box_row		default: 3		n. of cells in a row inside the box
 *	int 	$partners_per_full_row		default: 5		n. of cells in a full row (outside the box - normal row)
 *	bool 	$simple_page				default: false	if set to true, builds a page without any extra box
 *
 *
 * @since aurasma 1.0
 */

	function build_partners_grid( $partners_posts_per_page = 26, $partners_left_box = 6, $partners_per_box_row = 3, $partners_per_full_row = 6, $simple_page = false ) {

	global $wp_query;

	// retrieve current page and query posts.

	$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
	$args = array(
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'partner',
		'posts_per_page' => $partners_posts_per_page,
		'paged' => $paged
	);

	wp_reset_query();
	query_posts($args);
	$partners_posts = $wp_query->post_count;
	$ignore_purple_square = false;

	// if current page > 1, the function must print regular cells without another extra purple square.
	if($paged > 1) {
		$partners_left_box = 6;
		$partners_per_box_row = 6;
		$ignore_purple_square = true;

		// to avoid the output of empty squares, decomment this line and comment the 3 above.
		//$simple_page = true;
	}

	// open thumbnail div
	
	$output = '<div class="thumbnails">';

	// if is not simple page, the function must print a full grid, including calculations for extra empty boxes based on input vars.

	if(!$simple_page) {

		$i = 0;
		for ( $c = $partners_left_box; $c <= $partners_posts_per_page; $c = $c + $partners_per_full_row ){

			if( $i < $partners_posts && $partners_posts <= $c ) {
				$empty_boxes = $c - $partners_posts;
				$full_boxes = $partners_left_box - $empty_boxes;
				$posts_in_full_rows = $partners_posts - $full_boxes;
				//echo('c: ' . $c . ' - partners posts: ' . $partners_posts . ' - empty boxes: ' . $empty_boxes . ' - full boxes: ' . $full_boxes . ' - posts in full rows: ' . $posts_in_full_rows); 
				break;
			}

			$i = $c;
		}

		$i = 0;
		$c = 0;
		$do_reset = true;

		global $post;
		while ( have_posts() ) : the_post(); 

			$i++; 

			$logo = get_the_post_thumbnail($post->ID, 'partner_logo');
			$slug = $post->post_name;

			$has_casestudy = get_post_meta($post->ID, 'has_casestudy', true);
			if($has_casestudy){
				$data_url = 'data-url="'. $slug .'"';
				$post_link = get_permalink() . '?ajax=true';
				$link_class = '';
				$corner_div = '<div class="corner">Open case study</div>';
			} else {
				$data_url = '';
				$post_link = '#';
				$link_class = 'class="no-click"';
				$corner_div = '';
			}

			// if row counter is lower than the number of posts that must be printed in a regular width row,
			// print a regular row. Else, reset the column counter and print a box row.

			if($i <= $posts_in_full_rows){
				$partners_per_row = $partners_per_full_row;
			} else {
				$partners_per_row = $partners_per_box_row;

				if($do_reset) $reset = true;
				$do_reset = false;
			}

			if(isset($reset) && $reset == true) {
				$c = 0;
				$reset = false;
			};
			$c++;

			// add row divs and post classes based of column position

			$post_position = $c % $partners_per_row;

			switch( $post_position ) {

				case 0:
					$pre_post = '';
					$post_class = "post four column omega clear-right";
					$post_post = '</div>';
					break;

				case 1:
					$pre_post = '<div class="row">';
					$post_class = "post four column alpha clear-left";
					$post_post = '';
					break;

				default:
					$pre_post = '';
					$post_class = "post four column";
					$post_post = '';
					break;
			}

			$output .= $pre_post;
			$output .= '<div class="' . $post_class . '">';
			$output .= '<a ' . $data_url . ' href="'. $post_link .'" ' . $link_class . ' title="'.  get_the_title() .'">';
			$output .= $corner_div . $logo;
			$output .= '</a>';
			$output .= '</div>';
			$output .= $post_post;

		endwhile; 

		// if empty boxes are present, generate and add them to the output.

		if(isset($empty_boxes)):

			for($i = ($partners_left_box - $empty_boxes) + 1; $i <= $partners_left_box; $i++):

				$box_position = $i % $partners_per_box_row;

				switch( $box_position ) {

					case 0:
						$pre_post = '';
						$post_class = "post four column omega clear-right";
						$post_post = '</div>';
						break;

					case 1:
						$pre_post = '<div class="row">';
						$post_class = "post four column alpha clear-left";
						$post_post = '';
						break;

					default:
						$pre_post = '';
						$post_class = "post four column";
						$post_post = '';
						break;
				}

				$output .= $pre_post;
				$output .= '<div class="' . $post_class . '">';
				$output .= '<a href="#" class="no-click">&nbsp;</a>';
				$output .= '</div>';
				$output .= $post_post;

			endfor;
		endif;

		// if purple square must not be ignored, add it to the output.

		if(!$ignore_purple_square) {
			$output .= '<div class="square">';
			$output .= get_post_meta(113, 'extra_content', true);
			$output .= '</div>';
		}

		$output .= '</div>';

	} else {

		// else print a regular grid without purple box and added empty boxes.

		$i = 0;
		while ( have_posts() ) : the_post(); 

			$logo = get_the_post_thumbnail($post->ID, 'partner_logo');
			$i++;
			$post_position = $i % $partners_per_full_row;

			$has_casestudy = get_post_meta($post->ID, 'has_casestudy', true);
			if($has_casestudy){
				$data_url = 'data-url="'. $slug .'"';
				$post_link = get_permalink() . '?ajax=true';
				$link_class = '';
				$corner_div = '<div class="corner">Open case study</div>';
			} else {
				$data_url = '';
				$post_link = '#';
				$link_class = 'class="no-click"';
				$corner_div = '';
			}


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

			$output .= $pre_post;
			$output .= '<div class="' . $post_class . '">';
			$output .= '<a ' . $data_url . ' href="'. $post_link .'" ' . $link_class . ' title="'.  get_the_title() .'">';
			$output .= $corner_div . $logo;
			$output .= '</a>';
			$output .= '</div>';
			$output .= $post_post;

		endwhile; 

	}

	// close thumbnail div and return output

	$output .= '</div>';
	wp_reset_query();
	return $output;

}


function build_campaigns_grid( $campaigns_posts_per_page = 21 ) {

	global $wp_query;

	// retrieve current page and query posts.

	$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => 'campaign',
		'posts_per_page' => $campaigns_posts_per_page,
		'paged' => $paged,
		'order' => 'ASC',
		'orderby' => 'menu_order'
	);
	wp_reset_query();
	query_posts(array_merge( $wp_query->query_vars, $args)); 	
	$campaigns_posts = $wp_query->post_count;

	$output = '<div class="thumbnails">';

	$i = 0;
	$campaigns_per_full_row = 5;
	global $post;
	while ( have_posts() ) : the_post(); 

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

		$output .= '<div class="' . $post_class . '">';
		$output .= '<a data-url="'. $post->post_name .'" href="'. get_permalink() .'?ajax=true" class="lightbox-btn" title="'.  get_the_title() .'">';
		$output .= $campaign_thumb;
		$output .= '</a>';
		$output .= '</div>';

	endwhile; 

	$output .= '</div>';
	//wp_reset_query();
	return $output;


}

function current_url() {
	$url = 'http';
	if ($_SERVER['HTTPS'] == 'on') $url .= 's';
	$url .= '://';
	if ($_SERVER['SERVER_PORT'] != '80') {
		$url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
	} else {
		$url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	return $url;
}


