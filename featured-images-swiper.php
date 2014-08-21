<?php
/*
 Plugin Name: Featured Images Swiper
 Plugin URI: http://wordpress.org/plugins/featured-images-swiper/
 Description: Mobile touch slider with recent posts featured-image.
 Author: sysbird
 Author URI: http://www.sysbird.jp/wptips
 Version: 1.0
 License: GPLv2 or later
*/

//////////////////////////////////////////////////////
// Wordpress 3.6+
global $wp_version;
if ( version_compare( $wp_version, "3.6", "<" ) ){
	return false;
}

//////////////////////////////////////////////////////
// Start the plugin
class FeaturedImagesSwiper {

	//////////////////////////////////////////
	// construct
	function __construct() {
		add_shortcode('featured-images-swiper', array( &$this, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_script' ) );
		add_action( 'wp_print_styles', array( &$this, 'add_style' ) );
	}

	//////////////////////////////////////////
	// add JavaScript
	function add_script() {
		$filename = plugins_url( dirname( '/' .plugin_basename( __FILE__ ) ) ).'/js/featured-images-swiper.js';
		wp_enqueue_script( 'featured-images-swiper', $filename, array( 'jquery' ), '1.0' );

		$filename = plugins_url( dirname( '/' .plugin_basename( __FILE__ ) ) ).'/js/swiper/idangerous.swiper.js';
		wp_enqueue_script( 'featured-images-swiper-idangerous.swiper', $filename, array( 'jquery' ), '20140817' );
	}

	//////////////////////////////////////////
	// add css
	function add_style() {
		$filename = plugins_url( dirname( '/' .plugin_basename( __FILE__ ) ) ).'/css/featured-images-swiper.css';
		wp_enqueue_style( 'featured-images-swiper', $filename, false, '1.0' );

		$filename = plugins_url( dirname( '/' .plugin_basename( __FILE__ ) ) ).'/js/swiper/idangerous.swiper.css';
		wp_enqueue_style( 'featured-images-swiper-magnific-idangerous.swiper', $filename, false, '20140817' );
	}

	//////////////////////////////////////////
	// ShoetCode
	function shortcode( $atts ) {

		$atts = shortcode_atts( array( 'number' => 10 ), $atts );

		$output = '';
		$args = array( 'post_type'		=> 'post',
					   'posts_per_page'	=> $atts['number'],
					   'meta_key'		=> '_thumbnail_id' );
		$thumbnails = get_posts( $args );
		foreach ( $thumbnails as $thumbnail ) {
			if ( has_post_thumbnail($thumbnail->ID) ) {
				$output .= '<div class="swiper-slide">';
				$output .= '<a href="' . get_permalink( $thumbnail->ID ) . '" title="' . esc_attr( $thumbnail->post_title ) . '">';
				$output .= '<div class="thumbnail">' .get_the_post_thumbnail( $thumbnail->ID, 'thumbnail' ) .'</div>';
				$output .= '<div class="caption"><p>' .get_the_title( $thumbnail->ID ) .'</p></div>';
				$output .= '</a>';
				$output .= '</div>';
			}
		}

		if( !empty( $output ) ){
			$output = '<div class="featured-images-swiper"><div class="swiper-container"><div class="swiper-wrapper">' .$output .'</div></div></div>';
		}

		return $output;
	}
}
$FeaturedImagesSwiper = new FeaturedImagesSwiper();
?>