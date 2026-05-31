<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="spark-loader" aria-hidden="true">
  <div class="loader-logo">
    <?php echo file_get_contents( get_template_directory() . '/assets/spark.svg' ); ?>
  </div>
</div>

<header class="site-header">
	<div class="container header-inner">

		<!-- Hamburger (mobile) -->
		<button class="nav-toggle" aria-label="<?php echo esc_attr( sparkfb_t( 'Abrir menú', 'Open menu' ) ); ?>" aria-expanded="false" aria-controls="nav-drawer">
			<span></span><span></span><span></span>
		</button>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="Spark Fingerboards">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/spark.svg' ); ?>" alt="Spark Fingerboards" height="28">
		</a>

		<nav class="site-nav" aria-label="Primary">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'main-nav',
				'container'      => false,
				'fallback_cb'    => function() {
					$shop = get_permalink( wc_get_page_id( 'shop' ) );
					$nav_cats = [
						[ 'slug' => 'decks',      'es' => 'Decks',      'en' => 'Decks' ],
						[ 'slug' => 'obstaculos', 'es' => 'Obstáculos', 'en' => 'Obstacles' ],
						[ 'slug' => 'trucks',     'es' => 'Trucks',     'en' => 'Trucks' ],
						[ 'slug' => 'wheels',     'es' => 'Wheels',     'en' => 'Wheels' ],
					];
					echo '<ul class="main-nav">';
					echo '<li><a href="' . esc_url( $shop ) . '">' . esc_html( sparkfb_t( 'Tienda', 'Shop' ) ) . '</a></li>';
					foreach ( $nav_cats as $c ) {
						$term = get_term_by( 'slug', $c['slug'], 'product_cat' );
						$url  = ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : '#';
						echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( sparkfb_t( $c['es'], $c['en'] ) ) . '</a></li>';
					}
					echo '</ul>';
				},
			] );
			?>
		</nav>

		<div class="header-actions">

			<?php
			$_loc      = sparkfb_get_location();
			$_peru_url = esc_url( add_query_arg( 'set_location', 'peru' ) );
			$_int_url  = esc_url( add_query_arg( 'set_location', 'internacional' ) );
			?>

			<!-- Location dropdown -->
			<div class="loc-switcher" id="loc-switcher">
				<button class="loc-toggle" id="loc-toggle" aria-expanded="false" aria-haspopup="true">
					<span><?php echo $_loc === 'peru' ? 'PE' : 'WORLD'; ?></span>
					<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
						<path d="m6 9 6 6 6-6"/>
					</svg>
				</button>
				<div class="loc-menu" id="loc-menu" hidden>
					<a href="<?php echo $_peru_url; ?>" class="loc-option<?php echo $_loc === 'peru' ? ' is-active' : ''; ?>">Perú <span>S/</span></a>
					<a href="<?php echo $_int_url; ?>" class="loc-option<?php echo $_loc === 'internacional' ? ' is-active' : ''; ?>">Internacional <span>USD</span></a>
				</div>
			</div>

			<button class="header-icon" id="search-trigger" aria-label="<?php echo esc_attr( sparkfb_t( 'Buscar', 'Search' ) ); ?>" aria-expanded="false">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<circle cx="11" cy="11" r="8"/>
					<path d="m21 21-4.35-4.35"/>
				</svg>
			</button>

			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php echo esc_attr( sparkfb_t( 'Mi cuenta', 'My account' ) ); ?>" class="header-icon">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
					<circle cx="12" cy="7" r="4"/>
				</svg>
			</a>
			<!-- Cart triggers mini-cart, not page redirect -->
			<button class="header-icon cart-btn" aria-label="<?php echo esc_attr( sparkfb_t( 'Carrito', 'Cart' ) ); ?>" id="mini-cart-trigger">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
					<line x1="3" y1="6" x2="21" y2="6"/>
					<path d="M16 10a4 4 0 0 1-8 0"/>
				</svg>
				<span class="cart-count" id="cart-count-badge" <?php echo ( ! WC()->cart || WC()->cart->get_cart_contents_count() === 0 ) ? 'hidden' : ''; ?>>
					<?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
				</span>
			</button>
		</div>

	</div>
</header>

<!-- =========================================
     MOBILE NAV DRAWER
     ========================================= -->
<div id="nav-drawer" class="nav-drawer" aria-hidden="true" role="dialog" aria-label="Menú">
	<div class="nav-drawer__inner">

		<div class="nav-drawer__head">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="Spark Fingerboards">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/spark.svg' ); ?>" alt="Spark Fingerboards" height="24">
			</a>
			<button class="nav-drawer__close" aria-label="<?php echo esc_attr( sparkfb_t( 'Cerrar menú', 'Close menu' ) ); ?>" id="nav-drawer-close">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<line x1="18" y1="6" x2="6" y2="18"/>
					<line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
		</div>

		<nav class="nav-drawer__nav">
			<ul>
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'fallback_cb'    => function() {
						$shop = get_permalink( wc_get_page_id( 'shop' ) );
						$nav_cats = [
							[ 'slug' => 'decks',      'es' => 'Decks',      'en' => 'Decks' ],
							[ 'slug' => 'obstaculos', 'es' => 'Obstáculos', 'en' => 'Obstacles' ],
							[ 'slug' => 'trucks',     'es' => 'Trucks',     'en' => 'Trucks' ],
							[ 'slug' => 'wheels',     'es' => 'Wheels',     'en' => 'Wheels' ],
						];
						echo '<li><a href="' . esc_url( $shop ) . '">' . esc_html( sparkfb_t( 'Tienda', 'Shop' ) ) . '</a></li>';
						foreach ( $nav_cats as $c ) {
							$term = get_term_by( 'slug', $c['slug'], 'product_cat' );
							$url  = ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : '#';
							echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( sparkfb_t( $c['es'], $c['en'] ) ) . '</a></li>';
						}
					},
				] );
				?>
			</ul>
		</nav>

		<div class="nav-drawer__footer">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php echo esc_html( sparkfb_t( 'Mi cuenta', 'My account' ) ); ?></a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo esc_html( sparkfb_t( 'Carrito', 'Cart' ) ); ?></a>
		</div>

	</div>
</div>
<div class="nav-drawer__backdrop" id="nav-drawer-backdrop" aria-hidden="true"></div>

<!-- =========================================
     MINI-CART DRAWER
     ========================================= -->
<div id="mini-cart" class="mini-cart" aria-hidden="true" role="dialog" aria-label="<?php echo esc_attr( sparkfb_t( 'Carrito', 'Cart' ) ); ?>">
	<div class="mini-cart__inner">

		<div class="mini-cart__head">
			<h2 class="mini-cart__title"><?php echo esc_html( sparkfb_t( 'Tu carrito', 'Your cart' ) ); ?></h2>
			<button class="mini-cart__close" id="mini-cart-close" aria-label="<?php echo esc_attr( sparkfb_t( 'Cerrar carrito', 'Close cart' ) ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<line x1="18" y1="6" x2="6" y2="18"/>
					<line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
		</div>

		<div class="mini-cart__body" id="mini-cart-body">
			<?php woocommerce_mini_cart(); ?>
		</div>

	</div>
</div>
<div class="mini-cart__backdrop" id="mini-cart-backdrop" aria-hidden="true"></div>

<!-- =========================================
     SEARCH DROPDOWN
     ========================================= -->
<div id="search-dropdown" class="search-dropdown" hidden>
	<div class="search-dropdown__bar">
		<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
			<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
		</svg>
		<input
			type="search"
			id="search-live-input"
			class="search-dropdown__input"
			placeholder="<?php echo esc_attr( sparkfb_t( 'Buscar productos...', 'Search products...' ) ); ?>"
			autocomplete="off"
			spellcheck="false"
		>
	</div>
	<div id="search-results"></div>
</div>
