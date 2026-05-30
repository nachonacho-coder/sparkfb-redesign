<?php get_header(); ?>

<main id="main" class="site-main">

	<!-- HERO -------------------------------------------------- -->
	<section class="hero" style="background-image: url('<?php echo esc_url( sparkfb_hero_image() ); ?>');">

		<div class="hero-inner">
			<h1 class="hero-title"><em><?php echo esc_html( get_theme_mod( 'sparkfb_hero_title', 'I<3SPARK' ) ); ?></em></h1>
			<div class="hero-actions">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary">
					<?php echo sparkfb_t( 'Comprar ahora', 'Shop now' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- TICKER ------------------------------------------------- -->
	<div class="ticker" aria-hidden="true">
		<div class="ticker-inner">
			<?php
			$default = "Decks\nObstacles\nTrucks\nWheels\nCustom Orders\nEnvío internacional\nLima, Perú\nSince 2018\nFingerboards\nHandmade";
			$raw     = get_theme_mod( 'sparkfb_ticker_items', $default );
			$items   = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
			$all     = array_merge( $items, $items );
			foreach ( $all as $item ) :
			?>
				<span class="ticker-item"><?php echo esc_html( $item ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- CATEGORY CARDS ----------------------------------------- -->
	<section class="categories">
			<?php
			$cats = [
				[ 'slug' => 'decks',      'name' => 'Decks',      'count' => '62 productos' ],
				[ 'slug' => 'obstaculos', 'name' => 'Obstáculos', 'count' => '13 productos' ],
				[ 'slug' => 'trucks',     'name' => 'Trucks',     'count' => '10 productos' ],
				[ 'slug' => 'wheels',     'name' => 'Ruedas',     'count' => '5 productos'  ],
			];
			?>
			<div class="category-grid">
				<?php foreach ( $cats as $cat ) :
					$term      = get_term_by( 'slug', $cat['slug'], 'product_cat' );
					$url       = $term ? get_term_link( $term ) : '#';
					$thumb_id  = $term ? get_term_meta( $term->term_id, 'thumbnail_id', true ) : null;
					$img_src   = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
					$has_img   = ! empty( $img_src );
				?>
				<a href="<?php echo esc_url( is_wp_error( $url ) ? '#' : $url ); ?>"
				   class="category-card <?php echo $has_img ? '' : 'category-card--no-img'; ?>">
					<?php if ( $has_img ) : ?>
						<img
							src="<?php echo esc_url( $img_src ); ?>"
							alt="<?php echo esc_attr( $cat['name'] ); ?>"
							class="category-card__img"
							loading="lazy"
						>
					<?php endif; ?>
					<div class="category-card__overlay">
						<p class="category-card__name"><?php echo esc_html( $cat['name'] ); ?></p>
						<p class="category-card__count">
							<?php echo $term ? esc_html( $term->count . ' productos' ) : esc_html( $cat['count'] ); ?>
						</p>
					</div>
				</a>
				<?php endforeach; ?>
			</div>
	</section>

	<!-- FEATURED PRODUCTS -------------------------------------- -->
	<section class="section" id="featured">
		<div class="container">
			<div class="section-header">
				<span class="section-label"><?php echo sparkfb_t( 'Novedades', 'New arrivals' ); ?></span>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-outline">
					<?php echo sparkfb_t( 'Ver todo', 'View all' ); ?>
				</a>
			</div>

			<div class="carousel-wrap">
				<button class="carousel-btn carousel-btn--prev" aria-label="Anterior" onclick="sparkCarousel('novedades-carousel',-1)">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12 4L6 10L12 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
				<div class="products-grid" id="novedades-carousel">
					<?php
					$featured_products = wc_get_products( [
						'limit'   => 8,
						'status'  => 'publish',
						'orderby' => 'date',
						'order'   => 'DESC',
					] );
					foreach ( $featured_products as $fp ) :
					?>
					<div class="pcard">
						<a href="<?php echo esc_url( $fp->get_permalink() ); ?>" class="pcard__link">
							<div class="pcard__img-wrap">
								<?php echo $fp->get_image( 'woocommerce_thumbnail', [ 'class' => 'pcard__img' ] ); ?>
								<?php if ( $fp->is_on_sale() ) : ?>
									<span class="pcard__badge">Sale</span>
								<?php endif; ?>
							</div>
							<div class="pcard__meta">
								<h3 class="pcard__name"><?php echo esc_html( $fp->get_name() ); ?></h3>
								<div class="pcard__price"><?php echo $fp->get_price_html(); ?></div>
							</div>
						</a>
						<a href="<?php echo esc_url( $fp->get_permalink() ); ?>" class="pcard__atc"><?php echo sparkfb_t( 'Ver producto', 'View product' ); ?></a>
					</div>
					<?php endforeach; ?>
				</div>
				<button class="carousel-btn carousel-btn--next" aria-label="Siguiente" onclick="sparkCarousel('novedades-carousel',1)">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M8 4L14 10L8 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</button>
			</div>

		</div>
	</section>

</main>

<?php get_footer(); ?>
