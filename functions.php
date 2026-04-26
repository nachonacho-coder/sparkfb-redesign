<?php
defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------
   Enqueue styles & fonts
-------------------------------------------------- */
function sparkfb_enqueue_assets() {
	wp_enqueue_style(
		'sparkfb-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;700;800&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'sparkfb-style',
		get_stylesheet_uri(),
		[ 'sparkfb-fonts' ],
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'sparkfb-main',
		get_template_directory_uri() . '/assets/js/main.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'sparkfb_enqueue_assets' );

/* --------------------------------------------------
   Theme setup
-------------------------------------------------- */
function sparkfb_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 48,
		'width'       => 120,
		'flex-width'  => true,
		'flex-height' => true,
	] );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'sparkfb' ),
		'footer'  => __( 'Footer Menu', 'sparkfb' ),
	] );
}
add_action( 'after_setup_theme', 'sparkfb_setup' );

/* --------------------------------------------------
   WooCommerce: remove default wrappers
-------------------------------------------------- */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', function() {
	echo '<div class="woo-wrap container">';
} );
add_action( 'woocommerce_after_main_content', function() {
	echo '</div>';
} );

/* --------------------------------------------------
   WooCommerce: products per page
-------------------------------------------------- */
add_filter( 'loop_shop_per_page', fn() => 16 );

/* --------------------------------------------------
   WooCommerce: remove breadcrumb on shop
-------------------------------------------------- */
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
	$defaults['delimiter'] = ' / ';
	return $defaults;
} );
