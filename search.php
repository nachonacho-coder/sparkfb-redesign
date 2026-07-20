<?php defined( 'ABSPATH' ) || exit; ?>
<?php get_header(); ?>

<div class="archive-layout archive-layout--search container">

	<div class="archive-main archive-main--full">

		<div class="archive-topbar">
			<h1 class="archive-title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html( sparkfb_t( 'Resultados para: "%s"', 'Results for: "%s"' ) ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
			<div class="archive-topbar-right">
				<span class="archive-count"><?php echo esc_html( sprintf( sparkfb_t( '%d productos', '%d products' ), $wp_query->found_posts ) ); ?></span>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>

		<div class="shop-grid">
			<?php while ( have_posts() ) : the_post();
				global $product;
				$product = wc_get_product( get_the_ID() );
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

		<div class="archive-pagination">
			<?php
			echo paginate_links( [
				'total'   => $wp_query->max_num_pages,
				'current' => max( 1, get_query_var( 'paged' ) ),
				'prev_text' => '‹',
				'next_text' => '›',
			] );
			?>
		</div>

		<?php else : ?>
			<p class="search-no-results"><?php echo esc_html( sparkfb_t( 'No se encontraron productos.', 'No products found.' ) ); ?></p>
		<?php endif; ?>

	</div>

</div>

<?php get_footer(); ?>
