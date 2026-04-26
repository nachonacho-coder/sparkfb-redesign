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
		<div class="sp-gallery__main">
			<img
				src="<?php echo esc_url( wp_get_attachment_image_url( $main_img_id, 'large' ) ); ?>"
				alt="<?php the_title_attribute(); ?>"
				class="sp-main-img"
				id="sp-main-img"
			>
		</div>

		<?php if ( count( $all_imgs ) > 1 ) : ?>
		<div class="sp-gallery__thumbs">
			<?php foreach ( $all_imgs as $img_id ) : ?>
				<button
					class="sp-thumb"
					data-full="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'large' ) ); ?>"
					aria-label="Ver imagen"
				>
					<?php echo wp_get_attachment_image( $img_id, [ 80, 80 ], false, [ 'loading' => 'lazy' ] ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>

	<!-- RIGHT: info -->
	<div class="sp-info">

		<!-- breadcrumb -->
		<nav class="sp-breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a>
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
			<span>🇵🇪 Lima 2–3 días</span>
			<span>🌍 Internacional 15–20 días</span>
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
			<span class="section-label">También te puede gustar</span>
		</div>
		<div class="product-grid">
			<?php
			foreach ( $related as $rel_id ) :
				$setup = wc_setup_product_data( $rel_id );
				wc_get_template_part( 'content', 'product' );
				wp_reset_postdata();
			endforeach;
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
