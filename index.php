<?php get_header(); ?>

<main id="main" class="site-main">

	<!-- HERO -------------------------------------------------- -->
	<section class="hero">
		<div class="hero-inner">
			<span class="hero-eyebrow">Since 2018 &middot; Lima, Per&uacute;</span>
			<h1 class="hero-title">
				Craft your <em>next move.</em>
			</h1>
			<p class="hero-subtitle">
				Decks, trucks, wheels y obstacles dise&ntilde;ados para los que se toman el fingerboard en serio.
			</p>
			<div class="hero-actions">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary">
					Shop now
				</a>
				<a href="#featured" class="btn btn-outline">
					Ver novedades
				</a>
			</div>
		</div>
	</section>

	<!-- TICKER ------------------------------------------------- -->
	<div class="ticker" aria-hidden="true">
		<div class="ticker-inner">
			<?php
			$items = [ 'Decks', 'Obstacles', 'Trucks', 'Wheels', 'Custom Orders', 'Envío internacional', 'Lima, Perú', 'Since 2018', 'Fingerboards', 'Handmade' ];
			$all   = array_merge( $items, $items );
			foreach ( $all as $item ) :
			?>
				<span class="ticker-item"><?php echo esc_html( $item ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- CATEGORY CARDS ----------------------------------------- -->
	<section class="categories">
		<div class="container">
			<?php
			$cats = [
				[ 'slug' => 'decks',     'name' => 'Decks',      'count' => '62 productos' ],
				[ 'slug' => 'obstacles', 'name' => 'Obstáculos', 'count' => '13 productos' ],
				[ 'slug' => 'trucks',    'name' => 'Trucks',     'count' => '10 productos' ],
				[ 'slug' => 'wheels',    'name' => 'Wheels',     'count' => '5 productos'  ],
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
		</div>
	</section>

	<!-- FEATURED PRODUCTS -------------------------------------- -->
	<section class="section" id="featured">
		<div class="container">
			<div class="section-header">
				<span class="section-label">Novedades</span>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-outline">
					Ver todo
				</a>
			</div>
			<?php echo do_shortcode( '[recent_products limit="8" columns="4"]' ); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
