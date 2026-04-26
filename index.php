<?php get_header(); ?>

<main id="main" class="site-main">

	<!-- HERO -->
	<section class="hero">
		<div class="container">
			<span class="hero-eyebrow">Since 2018 · Lima, Perú</span>
			<h1 class="hero-title">
				Craft your<br><em>next move.</em>
			</h1>
			<p class="hero-subtitle">
				Decks, trucks, wheels y obstacles diseñados para los que se toman el fingerboard en serio.
			</p>
			<div class="hero-actions">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">
					Shop now
				</a>
				<a href="#featured" class="btn btn-outline">
					Ver novedades
				</a>
			</div>
		</div>
	</section>

	<!-- TICKER -->
	<div class="ticker" aria-hidden="true">
		<div class="ticker-inner">
			<?php
			$items = [ 'Decks', 'Obstacles', 'Trucks', 'Wheels', 'Custom Orders', 'Envío internacional', 'Lima, Perú', 'Since 2018' ];
			$all   = array_merge( $items, $items ); // duplicate for seamless loop
			foreach ( $all as $item ) :
			?>
				<span class="ticker-item"><?php echo esc_html( $item ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- CATEGORIES -->
	<section class="categories">
		<div class="container">
			<ul class="category-list">
				<?php
				$cats = [
					[ 'name' => 'Decks',     'count' => 62, 'slug' => 'decks' ],
					[ 'name' => 'Obstacles', 'count' => 13, 'slug' => 'obstacles' ],
					[ 'name' => 'Trucks',    'count' => 10, 'slug' => 'trucks' ],
					[ 'name' => 'Wheels',    'count' => 5,  'slug' => 'wheels' ],
				];
				foreach ( $cats as $cat ) :
					$url = get_term_link( $cat['slug'], 'product_cat' );
				?>
				<li class="category-item">
					<a href="<?php echo esc_url( is_wp_error( $url ) ? '#' : $url ); ?>">
						<span class="category-count"><?php echo esc_html( $cat['count'] ); ?></span>
						<span class="category-name"><?php echo esc_html( $cat['name'] ); ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- FEATURED PRODUCTS -->
	<section class="section" id="featured">
		<div class="container">
			<div class="section-header">
				<span class="section-label">Novedades</span>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-outline">
					Ver todo
				</a>
			</div>
			<?php echo do_shortcode( '[recent_products limit="8" columns="4"]' ); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
