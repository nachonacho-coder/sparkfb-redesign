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

<header class="site-header">
	<div class="container header-inner">

		<!-- Hamburger (mobile) -->
		<button class="nav-toggle" aria-label="Abrir menú" aria-expanded="false" aria-controls="nav-drawer">
			<span></span><span></span><span></span>
		</button>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				SPARK<span>FB</span>
			<?php endif; ?>
		</a>

		<nav class="site-nav" aria-label="Primary">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'main-nav',
				'container'      => false,
				'fallback_cb'    => function() {
					echo '<ul class="main-nav">
						<li><a href="/tienda">Tienda</a></li>
						<li><a href="/tienda/decks">Decks</a></li>
						<li><a href="/tienda/obstacles">Obstacles</a></li>
						<li><a href="/tienda/trucks">Trucks</a></li>
						<li><a href="/tienda/wheels">Wheels</a></li>
					</ul>';
				},
			] );
			?>
		</nav>

		<div class="header-actions">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="Mi cuenta" class="header-icon">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
					<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
					<circle cx="12" cy="7" r="4"/>
				</svg>
			</a>
			<!-- Cart triggers mini-cart, not page redirect -->
			<button class="header-icon cart-btn" aria-label="Carrito" id="mini-cart-trigger">
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
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
				SPARK<span>FB</span>
			</a>
			<button class="nav-drawer__close" aria-label="Cerrar menú" id="nav-drawer-close">
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
						echo '<li><a href="/tienda">Tienda</a></li>
						      <li><a href="/tienda/decks">Decks</a></li>
						      <li><a href="/tienda/obstacles">Obstacles</a></li>
						      <li><a href="/tienda/trucks">Trucks</a></li>
						      <li><a href="/tienda/wheels">Wheels</a></li>';
					},
				] );
				?>
			</ul>
		</nav>

		<div class="nav-drawer__footer">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mi cuenta</a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Carrito</a>
		</div>

	</div>
</div>
<div class="nav-drawer__backdrop" id="nav-drawer-backdrop" aria-hidden="true"></div>

<!-- =========================================
     MINI-CART DRAWER
     ========================================= -->
<div id="mini-cart" class="mini-cart" aria-hidden="true" role="dialog" aria-label="Carrito">
	<div class="mini-cart__inner">

		<div class="mini-cart__head">
			<h2 class="mini-cart__title">Tu carrito</h2>
			<button class="mini-cart__close" id="mini-cart-close" aria-label="Cerrar carrito">
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
