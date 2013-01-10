<?php
remove_filter('template_redirect', 'redirect_canonical');
add_action('init', 'post_types_init');
function post_types_init(){


	/*****Partners*****/

	$labels = array(
		'name' => _x('Partners', 'post type general name'),
		'singular_name' => _x('Partner', 'post type singular name'),
		'add_new' => _x('Add New', 'aurasma'),
		'add_new_item' => __('Add New Partner'),
		'edit_item' => __('Edit Partner'),
		'new_item' => __('New Partner'),
		'all_items' => __('All Partners'),
		'view_item' => __('View Partner'),
		'search_items' => __('Search Partners'),
		'not_found' =>  __('No Partner found'),
		'not_found_in_trash' => __('No Partner found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Partners'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'partners'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => true,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
	);



	register_post_type('partner',$args);
	
	
	/*********Press*************/

	$labels = array(
		'name' => _x('Press Items', 'post type general name'),
		'singular_name' => _x('Press Items', 'post type singular name'),
		'add_new' => _x('Add New', 'press'),
		'add_new_item' => __('Add New Press Items'),
		'edit_item' => __('Edit Press Items'),
		'new_item' => __('New Press Items'),
		'all_items' => __('All Press Items'),
		'view_item' => __('View Press Items'),
		'search_items' => __('Search Press Items'),
		'not_found' =>  __('No Press Items found'),
		'not_found_in_trash' => __('No Press Items found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Press Items'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'press'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'excerpt', 'author',  'thumbnail', 'page-attributes')
	);

	register_post_type('press-item', $args);

	/*****Campaigns*****/
	
	$labels = array(
		'name' => _x('Campaigns', 'post type general name'),
		'singular_name' => _x('Campaign', 'post type singular name'),
		'add_new' => _x('Add New', 'campaign'),
		'add_new_item' => __('Add New Campaign'),
		'edit_item' => __('Edit Campaign'),
		'new_item' => __('New Campaign'),
		'all_items' => __('All Campaigns'),
		'view_item' => __('View Campaign'),
		'search_items' => __('Search Campaigns'),
		'not_found' =>  __('No Campaigns found'),
		'not_found_in_trash' => __('No Campaigns found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Campaigns'
	
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array('slug' => 'campaigns'),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
	);


	register_post_type('campaign', $args);
	
	// global $wp_rewrite;
	// $wp_rewrite->flush_rules();
}

add_filter('post_updated_messages', 'custom_post_updated_messages');
function custom_post_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['partners'] = array(
    0 => '',
    1 => sprintf( __('Partner updated. <a href="%s">View partner</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Partner updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Partner restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Partner published. <a href="%s">View work</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Partner saved.'),
    8 => sprintf( __('Partner submitted. <a target="_blank" href="%s">Preview Partner</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Partner scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Work</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Partner draft updated. <a target="_blank" href="%s">Preview Partner</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  $messages['campaigns'] = array(
    0 => '',
    1 => sprintf( __('Campaign updated. <a href="%s">View campaign</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Campaign updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Campaign restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Campaign published. <a href="%s">View campaign</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Campaign saved.'),
    8 => sprintf( __('Campaign submitted. <a target="_blank" href="%s">Preview Campaign</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Campaign scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Campaign</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Campaign draft updated. <a target="_blank" href="%s">Preview Campaign</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  $messages['team-members'] = array(
    0 => '',
    1 => sprintf( __('Team member updated. <a href="%s">View Team member</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Team member updated.'),    5 => isset($_GET['revision']) ? sprintf( __('Team member restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Team member published. <a href="%s">View Team member</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Team member saved.'),
    8 => sprintf( __('Team member submitted. <a target="_blank" href="%s">Preview Team member</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Team member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Team member</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Team member draft updated. <a target="_blank" href="%s">Preview Team member</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// add_filter('manage_edit-work_columns', 'work_columns');
// function work_columns($columns) {
//     $columns['case_study'] = 'Case Study';
//     $columns['featured'] = 'Featured';
//     return $columns;
// }

// add_action('manage_posts_custom_column',  'work_show_columns');
// function work_show_columns($name) {
//     global $post;
//     switch ($name) {
//         case 'case_study':
//             echo (get_post_meta($post->ID, 'case_study', true) == '1' ) ? 'Yes':'No';
//             break;
//         case 'featured':
//             echo (get_post_meta($post->ID, 'featured', true) == '1' ) ? 'Yes':'No';
//             break;
//     }
// }


?>