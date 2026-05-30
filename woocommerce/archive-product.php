<?php defined( 'ABSPATH' ) || exit; ?>
<?php get_header(); ?>

<div class="archive-layout container">

	<!-- SIDEBAR -->
	<aside class="archive-sidebar">

		<div class="filter-block">
			<h3 class="filter-title"><?php echo esc_html( sparkfb_t( 'Categorías', 'Categories' ) ); ?></h3>
			<?php
			$cats = get_terms( [
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'parent'     => 0,
				'exclude'    => get_option( 'default_product_cat' ),
			] );
			if ( $cats && ! is_wp_error( $cats ) ) :
			?>
			<ul class="filter-list">
				<li>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					   class="filter-link <?php echo ( ! is_product_category() ) ? 'is-active' : ''; ?>">
						<?php echo esc_html( sparkfb_t( 'Todo', 'All' ) ); ?>
					</a>
				</li>
				<?php foreach ( $cats as $cat ) :
					$active = ( is_product_category() && get_queried_object_id() === $cat->term_id );
				?>
				<li>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
					   class="filter-link <?php echo $active ? 'is-active' : ''; ?>">
						<?php echo esc_html( $cat->name ); ?>
						<span class="filter-count"><?php echo esc_html( $cat->count ); ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>

		<div class="filter-block">
			<h3 class="filter-title"><?php echo esc_html( sparkfb_t( 'Precio', 'Price' ) ); ?></h3>
			<?php the_widget( 'WC_Widget_Price_Filter', [ 'title' => '' ] ); ?>
		</div>

	</aside>

	<!-- MAIN -->
	<div class="archive-main">

		<div class="archive-topbar">
			<h1 class="archive-title"><?php woocommerce_page_title(); ?></h1>
			<div class="archive-topbar-right">
				<span class="archive-count"><?php woocommerce_result_count(); ?></span>
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<?php if ( woocommerce_product_loop() ) : ?>

		<div class="shop-grid">
			<?php while ( have_posts() ) : the_post();
				global $product;
				if ( empty( $product ) || ! $product->is_visible() ) continue;
				$purchasable = $product->is_purchasable() && $product->is_in_stock() && ! $product->is_type( 'variable' );
			?>
			<div class="shop-card">
				<a href="<?php the_permalink(); ?>" class="shop-card__img-wrap">
					<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'shop-card__img' ] ); ?>
					<?php if ( $product->is_on_sale() ) : ?>
						<span class="shop-card__badge">Sale</span>
					<?php endif; ?>
				</a>
				<div class="shop-card__info">
					<a href="<?php the_permalink(); ?>" class="shop-card__name"><?php the_title(); ?></a>
					<div class="shop-card__price"><?php echo $product->get_price_html(); ?></div>
				</div>
				<?php if ( $purchasable ) :
					woocommerce_template_loop_add_to_cart( [ 'class' => 'shop-card__atc' ] );
				else : ?>
					<a href="<?php the_permalink(); ?>" class="shop-card__atc"><?php echo esc_html( sparkfb_t( 'Ver producto', 'View product' ) ); ?></a>
				<?php endif; ?>
			</div>
			<?php endwhile; ?>
		</div>

		<div class="archive-pagination"><?php woocommerce_pagination(); ?></div>

		<?php else : ?>
			<?php wc_get_template( 'loop/no-products-found.php' ); ?>
		<?php endif; ?>

	</div>

</div>

<?php get_footer(); ?>
