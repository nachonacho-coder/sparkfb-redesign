<?php defined( 'ABSPATH' ) || exit; ?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
	$product     = wc_get_product( get_the_ID() );
	$images      = $product->get_gallery_image_ids();
	$main_img_id = $product->get_image_id();
	$all_imgs    = array_merge( [ $main_img_id ], $images );
?>

<main class="sp-layout">

	<!-- LEFT: gallery -->
	<div class="sp-gallery">
		<div class="sp-gallery__main" id="sp-gallery-main"
			<?php if ( count( $all_imgs ) > 1 ) : ?>
			data-imgs="<?php echo esc_attr( wp_json_encode( array_map( fn( $id ) => wp_get_attachment_image_url( $id, 'large' ), $all_imgs ) ) ); ?>"
			<?php endif; ?>>
			<img
				src="<?php echo esc_url( wp_get_attachment_image_url( $main_img_id, 'large' ) ); ?>"
				alt="<?php the_title_attribute(); ?>"
				class="sp-main-img"
				id="sp-main-img"
			>
			<?php if ( count( $all_imgs ) > 1 ) : ?>
			<button class="sp-gallery-btn sp-gallery-btn--prev" aria-label="<?php echo esc_attr( sparkfb_t( 'Anterior', 'Previous' ) ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12 4L6 10L12 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
			<button class="sp-gallery-btn sp-gallery-btn--next" aria-label="<?php echo esc_attr( sparkfb_t( 'Siguiente', 'Next' ) ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M8 4L14 10L8 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
			<?php endif; ?>
		</div>
	</div>

	<!-- RIGHT: info -->
	<div class="sp-info">

		<!-- breadcrumb -->
		<nav class="sp-breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>"><?php echo sparkfb_t( 'Inicio', 'Home' ); ?></a>
			<span>/</span>
			<?php foreach ( wc_get_product_category_list( get_the_ID(), '|||' ) ? explode( '|||', wc_get_product_category_list( get_the_ID(), '|||', '', '' ) ) : [] as $cat ) : ?>
				<span><?php echo wp_kses_post( trim( $cat ) ); ?></span>
				<span>/</span>
			<?php endforeach; ?>
			<span><?php the_title(); ?></span>
		</nav>

		<h1 class="sp-title"><?php the_title(); ?></h1>

		<div class="sp-price">
			<?php echo $product->get_price_html(); ?>
		</div>

		<?php if ( $product->get_short_description() ) : ?>
		<p class="sp-desc"><?php echo wp_kses_post( $product->get_short_description() ); ?></p>
		<?php endif; ?>

		<!-- variations / add to cart -->
		<div class="sp-form">
			<?php
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			woocommerce_template_single_add_to_cart();
			?>
		</div>

		<!-- meta -->
		<div class="sp-meta">
			<?php woocommerce_template_single_meta(); ?>
		</div>

		<!-- shipping note -->
		<div class="sp-shipping-note">
			<span>🇵🇪 <?php echo sparkfb_t( 'Lima 2–3 días', 'Lima 2–3 days' ); ?></span>
			<span>🌍 <?php echo sparkfb_t( 'Internacional 15–20 días', 'International 15–20 days' ); ?></span>
		</div>

	</div>
</main>

<!-- RELATED -->
<?php
$related = wc_get_related_products( get_the_ID(), 4 );
if ( $related ) :
?>
<section class="section sp-related">
	<div class="container">
		<div class="section-header">
			<span class="section-label"><?php echo sparkfb_t( 'También te puede gustar', 'You might also like' ); ?></span>
		</div>
		<ul class="product-grid">
			<?php
			foreach ( $related as $rel_id ) :
				$post_object = get_post( $rel_id );
				setup_postdata( $GLOBALS['post'] = $post_object );
				wc_setup_product_data( $post_object );
				wc_get_template_part( 'content', 'product' );
			endforeach;
			wp_reset_postdata();
			?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
