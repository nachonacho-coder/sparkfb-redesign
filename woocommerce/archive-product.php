<?php defined( 'ABSPATH' ) || exit; ?>

<?php get_header(); ?>

<div class="archive-layout container">

	<!-- SIDEBAR FILTERS -->
	<aside class="archive-sidebar">

		<div class="filter-block">
			<h3 class="filter-title">Categorías</h3>
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
						Todo
					</a>
				</li>
				<?php foreach ( $cats as $cat ) :
					$url     = get_term_link( $cat );
					$active  = ( is_product_category() && get_queried_object_id() === $cat->term_id );
				?>
				<li>
					<a href="<?php echo esc_url( $url ); ?>"
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
			<h3 class="filter-title">Precio</h3>
			<?php the_widget( 'WC_Widget_Price_Filter' ); ?>
		</div>

		<?php if ( is_product_category() ) :
			$term = get_queried_object();
			if ( $term->description ) :
		?>
		<div class="filter-block">
			<p class="filter-desc"><?php echo wp_kses_post( $term->description ); ?></p>
		</div>
		<?php endif; endif; ?>

	</aside>

	<!-- MAIN CONTENT -->
	<div class="archive-main">

		<!-- topbar -->
		<div class="archive-topbar">
			<h1 class="archive-title">
				<?php woocommerce_page_title(); ?>
			</h1>
			<div class="archive-topbar-right">
				<span class="archive-count">
					<?php woocommerce_result_count(); ?>
				</span>
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<!-- products -->
		<?php if ( woocommerce_product_loop() ) : ?>
			<div class="product-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; ?>
			</div>
			<div class="archive-pagination">
				<?php woocommerce_pagination(); ?>
			</div>
		<?php else : ?>
			<?php wc_get_template( 'loop/no-products-found.php' ); ?>
		<?php endif; ?>

	</div>

</div>

<?php get_footer(); ?>
