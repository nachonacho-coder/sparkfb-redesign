<?php defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>

	<ul class="sparkfb-mini-cart-list">
		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) continue;

			$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( [ 72, 72 ] ), $cart_item, $cart_item_key );
			$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			$remove_url        = esc_url( wc_get_cart_remove_url( $cart_item_key ) );
		?>
		<li class="sparkfb-mci">

			<a class="sparkfb-mci__remove remove_from_cart_button"
				role="button"
				href="<?php echo $remove_url; ?>"
				aria-label="<?php echo esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ); ?>"
				data-product_id="<?php echo esc_attr( $product_id ); ?>"
				data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>"
				data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
				<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
			</a>

			<a class="sparkfb-mci__img-link" href="<?php echo esc_url( $product_permalink ); ?>">
				<?php echo $thumbnail; ?>
			</a>

			<div class="sparkfb-mci__info">
				<a href="<?php echo esc_url( $product_permalink ); ?>" class="sparkfb-mci__name"><?php echo wp_kses_post( $product_name ); ?></a>

				<?php $item_data = wc_get_formatted_cart_item_data( $cart_item ); if ( $item_data ) : ?>
					<div class="sparkfb-mci__meta"><?php echo wp_kses_post( $item_data ); ?></div>
				<?php endif; ?>

				<span class="sparkfb-mci__qty">
					<?php echo esc_html( $cart_item['quantity'] ); ?> &times; <?php echo wp_kses_post( $product_price ); ?>
				</span>
			</div>

		</li>
		<?php endforeach; ?>
	</ul>

	<div class="sparkfb-mc-footer">
		<div class="sparkfb-mc-subtotal">
			<span><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>:</span>
			<span><?php
			if ( function_exists( 'sparkfb_get_location' ) && sparkfb_get_location() === 'peru' && function_exists( 'sparkfb_cart_total_pen' ) ) {
				echo sparkfb_pen_html( sparkfb_cart_total_pen() );
			} else {
				echo WC()->cart->get_cart_subtotal();
			}
		?></span>
		</div>
		<div class="sparkfb-mc-actions">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="sparkfb-mc-btn sparkfb-mc-btn--outline"><?php esc_html_e( 'View cart', 'woocommerce' ); ?></a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="sparkfb-mc-btn sparkfb-mc-btn--solid checkout"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
		</div>
	</div>

<?php else : ?>
	<p class="sparkfb-mc-empty"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
