<?php

add_shortcode( 'base_url', 'base_url_handler' );
function base_url_handler( $atts ) {
	return get_bloginfo('url');
}

add_shortcode( 'uploads_url', 'uploads_url_handler' );
function uploads_url_handler( $atts ) {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['baseurl'];
}

add_shortcode( 'images_url', 'images_url_handler' );
function images_url_handler( $atts ) {
	return get_stylesheet_directory_uri() . "/images";
}

remove_shortcode('gallery');
add_shortcode( 'gallery', 'gallery_handler' );
function gallery_handler( $atts ) {
	global $post;
	$post_format = get_post_format($post->ID);
	$output = '';

    extract(shortcode_atts(array(
        'id'      => '0',
        'type'	  => ''
    ), $atts));

    $gallery = get_post($atts['id']);
	if($gallery) {
		$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $gallery->ID, 'orderby' => 'menu_order', 'order' => 'ASC' ); 
		$attachments = get_posts($args);
		
		switch($atts['type']){

			case 'shop':
				$output .= '<div class="shop" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<ul class="shop-list clearfix" >';
					$columns = array('one', 'two', 'three', 'four');
					$total_columns = count($columns);
					$i = 0;
					foreach ( $attachments as $attachment ) {
						$output .= '<li class="product '.$columns[$i % $total_columns].'">';
						$output .= '<div class="thumbnail">';
						$output .= '<a class="'.get_post_meta($attachment->ID, 'external_url', true).'" target="_blank">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'custom_thumbnail' );
						$output .= '<img src="'.$image[0].'" />';
						$output .= '</a>';
						$output .= '</div>';
						$output .= '<div class="product-meta">';
						$output .= '<h5 class="title">'.$attachment->post_title.'</h5>';
						$output .= '<div class="description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '<p class="no-margin">';
						$output .= '<a href="'.get_post_meta($attachment->ID, 'external_url', true).'" target="_blank" class="red-btn">'.__('Shop Now', 'editer').'</a>';
						$output .= '</p>';
						$output .= '</div>';
						$output .= '</div>';
						$output .= '</li>';
						$i++;
					}
					$output .= '</ul>';
				}
				$output .= '</div>';
				break;

			case 'how_to':
				$output .= '<div class="how-to" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<ul class="how-to-list clearfix" >';
					$columns = array('one', 'two');
					$total_columns = count($columns);
					$i = 0;
					foreach ( $attachments as $attachment ) {
						$output .= '<li class="step '.$columns[$i % $total_columns].'">';
						$output .= '<div class="thumbnail">';
						$image = wp_get_attachment_image_src( $attachment->ID, 'custom_medium' );
						$output .= '<img src="'.$image[0].'" />';
						$output .= '</div>';
						$output .= '<div class="product-meta clearfix">';
						$output .= '<span class="number didot-italic">';
						$output .= $i + 1;
						$output .= '</span>';
						$output .= '<div class="description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '</div>';
						$output .= '</div>';
						$output .= '</li>';
						$i++;
					}
					$output .= '</ul>';
				}
				$output .= '</div>';
				break;
			default;
				$output .= '<div class="gallery-scroller scroller pull-two" data-id="'.$gallery->ID.'">';
				$output .= apply_filters('the_content', $gallery->post_content);
				if (!empty($attachments)) {
					$output .= '<div class="scroller-mask">';
					$output .= '<div class="scroll-items-container clearfix">';
					foreach ( $attachments as $attachment ) {
						$output .= '<div class="scroll-item" data-id="'.$attachment->ID.'">';
						$output .= '<div class="image">';
						if($post_format == 'gallery'){
							$image = wp_get_attachment_image_src( $attachment->ID, 'large');
						} else {
							$image = wp_get_attachment_image_src( $attachment->ID, 'gallery' );
						}
						$output .= '<img src="'.$image[0].'" width="'.$image[1].'" />';
						$output .= '</div>';
						$output .= '<div class="description">';
						$output .=  apply_filters('the_content', $attachment->post_content);
						$output .= '</div>';
						$output .= '</div>';
					}		
					$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="scroller-navigation">';
					$output .= '<a class="prev-btn"></a>';
					$output .= '<a class="next-btn"></a>';
					$output .= '</div>';
				}
				$output .= '</div>';
		}
	}
	return $output;
}

add_shortcode( 'embed_page', 'embed_page_handler' );
function embed_page_handler( $atts ) {
	global $post;
	$post_format = get_post_format($post->ID);
	$output = '';
    extract(shortcode_atts(array(
        'id'      => '0'
    ), $atts));

    $page = get_post($atts['id']);
	if($page) {
		$output .= '<article class="clearfix '. sanitize_title(get_the_title($page->ID)) . '">';
		$output .= '<h2>' . get_the_title($page->ID) . '</h2>';
		$output .=  apply_filters('the_content', $page->post_content);
		$output .= '</article>';
	}
	return $output;
}

