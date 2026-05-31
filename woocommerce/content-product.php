<?php
defined( 'ABSPATH' ) || exit;
global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<a href="<?php the_permalink(); ?>" class="product-card__link">

		<div class="product-img-wrap">
			<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'product-img' ] ); ?>
			<?php if ( $product->is_on_sale() ) : ?>
				<span class="product-badge">Sale</span>
			<?php endif; ?>
		</div>

		<div class="product-card__meta">
			<h3 class="product-name"><?php the_title(); ?></h3>
			<div class="product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		</div>

	</a>

	<?php if ( $product->is_purchasable() && $product->is_in_stock() && ! $product->is_type( 'variable' ) ) : ?>
		<?php woocommerce_template_loop_add_to_cart( [ 'class' => 'btn btn-primary product-card__atc' ] ); ?>
	<?php else : ?>
		<a href="<?php the_permalink(); ?>" class="btn btn-outline product-card__atc"><?php echo esc_html( sparkfb_t( 'Ver producto', 'View product' ) ); ?></a>
	<?php endif; ?>

</li>
