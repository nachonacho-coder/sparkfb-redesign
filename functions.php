<?php
defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------
   Dynamic locale: es_ES for Peru, en_US for Internacional
   Runs early so WC/WP translations load correctly
-------------------------------------------------- */
add_filter( 'locale', function( $locale ) {
	if ( isset( $_COOKIE['sparkfb_location'] ) && $_COOKIE['sparkfb_location'] === 'peru' ) {
		return 'es_ES';
	}
	return 'en_US';
}, 1 );

/* Helper: return es or en string based on location */
function sparkfb_t( string $es, string $en ) : string {
	return sparkfb_get_location() === 'peru' ? $es : $en;
}

/* Product tags shown as nav submenu per product category (main-nav + mobile drawer) */
function sparkfb_nav_cat_tags() : array {
	return [
		'decks'      => [
			[ 'slug' => 'rwear',      'es' => 'Real Wear',  'en' => 'Real Wear' ],
			[ 'slug' => 'split-ply',  'es' => 'Split Ply',  'en' => 'Split Ply' ],
			[ 'slug' => 'cmp',        'es' => 'Completos',  'en' => 'Completes' ],
			[ 'slug' => 'serigrafia', 'es' => 'Serigrafía', 'en' => 'Silkscreen' ],
		],
		'obstaculos' => [
			[ 'slug' => 'rpls',     'es' => 'Plástico Reciclado', 'en' => 'Recycled Plastic' ],
			[ 'slug' => 'concrete', 'es' => 'Concreto',           'en' => 'Concrete' ],
		],
		'trucks'     => [
			[ 'slug' => 'sttrucks', 'es' => 'Standard', 'en' => 'Standard' ],
			[ 'slug' => 'caramel',  'es' => 'Caramel',  'en' => 'Caramel' ],
		],
		'wheels'     => [
			[ 'slug' => 'standardpu', 'es' => 'Standard', 'en' => 'Standard' ],
			[ 'slug' => 'caramel',    'es' => 'Caramel',  'en' => 'Caramel' ],
		],
	];
}

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

	wp_localize_script( 'sparkfb-main', 'sparkfbData', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	] );
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

/* Remove default single product sections — our template handles these */
add_action( 'wp', function() {
	if ( ! is_product() ) return;
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	remove_action( 'woocommerce_after_single_product',         'woocommerce_output_related_products', 20 );
} );

add_action( 'woocommerce_before_main_content', function() {
	echo '<div class="woo-wrap container">';
} );
add_action( 'woocommerce_after_main_content', function() {
	echo '</div>';
} );

/* --------------------------------------------------
   WooCommerce: products per page
-------------------------------------------------- */
add_filter( 'loop_shop_per_page', fn() => 15 );

/* --------------------------------------------------
   WooCommerce: remove breadcrumb on shop
-------------------------------------------------- */
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
	$defaults['delimiter'] = ' / ';
	return $defaults;
} );

/* --------------------------------------------------
   WooCommerce: AJAX mini-cart fragments
   Keeps the mini-cart HTML in sync after add/remove
-------------------------------------------------- */
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
	ob_start();
	woocommerce_mini_cart();
	$fragments['#mini-cart-body'] = '<div class="mini-cart__body" id="mini-cart-body">' . ob_get_clean() . '</div>';
	return $fragments;
} );

/* --------------------------------------------------
   WooCommerce: custom product card template path
-------------------------------------------------- */
add_filter( 'woocommerce_locate_template', function( $template, $template_name, $template_path ) {
	$custom = get_template_directory() . '/woocommerce/' . $template_name;
	return file_exists( $custom ) ? $custom : $template;
}, 10, 3 );

/* --------------------------------------------------
   Customizer: Hero image
-------------------------------------------------- */
add_action( 'customize_register', function( $wp_customize ) {
	$wp_customize->add_section( 'sparkfb_hero', [
		'title'    => 'Hero — Imagen de portada',
		'priority' => 30,
	] );
	$wp_customize->add_setting( 'sparkfb_hero_image', [
		'default'           => 'https://sparkfb.com/wp-content/uploads/2024/08/20240807_164520.jpg',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sparkfb_hero_image', [
		'label'   => 'Imagen del hero',
		'section' => 'sparkfb_hero',
	] ) );

	$wp_customize->add_setting( 'sparkfb_hero_title', [
		'default'           => 'I<3SPARK',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'sparkfb_hero_title', [
		'label'   => 'Título del hero',
		'section' => 'sparkfb_hero',
		'type'    => 'text',
	] );

	/* Ticker */
	$wp_customize->add_section( 'sparkfb_ticker', [
		'title'    => 'Ticker — Franja animada',
		'priority' => 35,
	] );
	$wp_customize->add_setting( 'sparkfb_ticker_items', [
		'default'           => "Decks\nObstacles\nTrucks\nWheels\nCustom Orders\nEnvío internacional\nLima, Perú\nSince 2018\nFingerboards\nHandmade",
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'sparkfb_ticker_items', [
		'label'       => 'Ítems del ticker (uno por línea)',
		'section'     => 'sparkfb_ticker',
		'type'        => 'textarea',
	] );
} );

/* --------------------------------------------------
   Search results page — solo productos
-------------------------------------------------- */
add_action( 'pre_get_posts', function( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', 'product' );
	}
} );

/* --------------------------------------------------
   Live search AJAX
-------------------------------------------------- */
add_action( 'wp_ajax_sparkfb_search',        'sparkfb_live_search' );
add_action( 'wp_ajax_nopriv_sparkfb_search', 'sparkfb_live_search' );

function sparkfb_live_search() {
	$q = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );
	if ( strlen( $q ) < 2 ) {
		wp_send_json( [] );
	}

	$products = wc_get_products( [
		's'      => $q,
		'limit'  => 6,
		'status' => 'publish',
	] );

	$results = [];
	foreach ( $products as $product ) {
		$img_id  = $product->get_image_id();
		$img_url = $img_id
			? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' )
			: wc_placeholder_img_src( 'woocommerce_thumbnail' );

		$results[] = [
			'name'  => $product->get_name(),
			'url'   => $product->get_permalink(),
			'price' => wp_strip_all_tags( $product->get_price_html() ),
			'img'   => $img_url ?: '',
		];
	}

	wp_send_json( $results );
}

function sparkfb_hero_image() {
	return get_theme_mod( 'sparkfb_hero_image', 'https://sparkfb.com/wp-content/uploads/2024/08/20240807_164520.jpg' );
}

/* --------------------------------------------------
   Location / currency switcher
   Cookie: sparkfb_location = 'peru' | 'internacional'
-------------------------------------------------- */
function sparkfb_get_location() {
	return ( isset( $_COOKIE['sparkfb_location'] ) && $_COOKIE['sparkfb_location'] === 'peru' )
		? 'peru'
		: 'internacional';
}

add_action( 'template_redirect', function() {
	// Manual override via URL param (el switcher Perú / Internacional)
	if ( isset( $_GET['set_location'] ) ) {
		$loc = in_array( $_GET['set_location'], [ 'peru', 'internacional' ], true )
			? $_GET['set_location']
			: 'internacional';
		setcookie( 'sparkfb_location', $loc, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		$_COOKIE['sparkfb_location'] = $loc;
		wp_safe_redirect( remove_query_arg( 'set_location' ) );
		exit;
	}

	// Auto-detect solo en la primera visita (cookie no seteada)
	if ( ! isset( $_COOKIE['sparkfb_location'] ) && class_exists( 'WC_Geolocation' ) ) {
		$geo     = WC_Geolocation::geolocate_ip();
		$country = $geo['country'] ?? '';
		$loc     = ( $country === 'PE' ) ? 'peru' : 'internacional';
		setcookie( 'sparkfb_location', $loc, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		$_COOKIE['sparkfb_location'] = $loc;
	}
} );

/* --------------------------------------------------
   PEN price field per product
   WP Admin → Product → General → "Precio en Soles"
-------------------------------------------------- */
add_action( 'woocommerce_product_options_pricing', function() {
	woocommerce_wp_text_input( [
		'id'                => '_price_pen',
		'label'             => 'Precio en Soles (S/)',
		'placeholder'       => 'Ej: 42.00',
		'desc_tip'          => true,
		'description'       => 'Precio en soles peruanos. Solo para display.',
		'type'              => 'number',
		'custom_attributes' => [ 'step' => '0.01', 'min' => '0' ],
	] );
} );

add_action( 'woocommerce_process_product_meta', function( $post_id ) {
	if ( isset( $_POST['_price_pen'] ) ) {
		update_post_meta( $post_id, '_price_pen', wc_clean( wp_unslash( $_POST['_price_pen'] ) ) );
	}
} );

/* Helper: format S/ price HTML */
function sparkfb_pen_html( float $amount ) : string {
	return '<span class="woocommerce-Price-amount amount"><bdi>'
		. '<span class="woocommerce-Price-currencySymbol">S/</span>&nbsp;'
		. number_format( $amount, 2 )
		. '</bdi></span>';
}

/* Helper: get PEN total for the cart */
function sparkfb_cart_total_pen() : float {
	$total = 0.0;
	foreach ( WC()->cart->get_cart() as $item ) {
		$pen = (float) get_post_meta( $item['product_id'], '_price_pen', true );
		$total += ( $pen > 0 ? $pen : (float) $item['data']->get_price() * 3.80 ) * $item['quantity'];
	}
	return $total;
}

/* Product pages & loops */
add_filter( 'woocommerce_get_price_html', function( $price_html, $product ) {
	if ( sparkfb_get_location() !== 'peru' ) return $price_html;
	$pen = (float) get_post_meta( $product->get_id(), '_price_pen', true );
	return $pen > 0 ? sparkfb_pen_html( $pen ) : $price_html;
}, 10, 2 );

/* Cart row: per-item price */
add_filter( 'woocommerce_cart_item_price', function( $price_html, $cart_item ) {
	if ( sparkfb_get_location() !== 'peru' ) return $price_html;
	$pen = (float) get_post_meta( $cart_item['product_id'], '_price_pen', true );
	return $pen > 0 ? sparkfb_pen_html( $pen ) : $price_html;
}, 10, 2 );

/* Cart row: per-item subtotal (price × qty) */
add_filter( 'woocommerce_cart_item_subtotal', function( $subtotal, $cart_item ) {
	if ( sparkfb_get_location() !== 'peru' ) return $subtotal;
	$pen = (float) get_post_meta( $cart_item['product_id'], '_price_pen', true );
	if ( $pen <= 0 ) return $subtotal;
	return sparkfb_pen_html( $pen * $cart_item['quantity'] );
}, 10, 2 );

/* Cart subtotal line */
add_filter( 'woocommerce_cart_subtotal', function( $subtotal, $compound, $cart ) {
	if ( sparkfb_get_location() !== 'peru' ) return $subtotal;
	return sparkfb_pen_html( sparkfb_cart_total_pen() );
}, 10, 3 );

/* Checkout order-review total */
add_filter( 'woocommerce_cart_totals_order_total_html', function( $value ) {
	if ( sparkfb_get_location() !== 'peru' ) return $value;
	return '<strong>' . sparkfb_pen_html( sparkfb_cart_total_pen() ) . '</strong>';
} );
