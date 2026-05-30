<footer class="site-footer">
	<div class="container">

		<div class="footer-grid">

			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo footer-logo">
					<?php echo file_get_contents( get_template_directory() . '/assets/spark.svg' ); ?>
				</a>
				<p><?php echo esc_html( sparkfb_t(
					'Fingerboards hechos con atención al detalle para riders de todo el mundo. Lima, Perú — desde 2018.',
					'Handmade fingerboards crafted for riders worldwide. Lima, Perú — since 2018.'
				) ); ?></p>
			</div>

			<div class="footer-col">
				<h4><?php echo esc_html( sparkfb_t( 'Tienda', 'Shop' ) ); ?></h4>
				<ul>
					<?php
					$footer_cats = [
						[ 'slug' => 'decks',      'es' => 'Decks',      'en' => 'Decks' ],
						[ 'slug' => 'obstaculos', 'es' => 'Obstáculos', 'en' => 'Obstacles' ],
						[ 'slug' => 'trucks',     'es' => 'Trucks',     'en' => 'Trucks' ],
						[ 'slug' => 'wheels',     'es' => 'Ruedas',     'en' => 'Wheels' ],
					];
					foreach ( $footer_cats as $fc ) :
						$term = get_term_by( 'slug', $fc['slug'], 'product_cat' );
						$url  = ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : '#';
					?>
					<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( sparkfb_t( $fc['es'], $fc['en'] ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php echo sparkfb_t( 'Ayuda', 'Help' ); ?></h4>
				<ul>
					<li><a href="/envios"><?php echo sparkfb_t( 'Envíos', 'Shipping' ); ?></a></li>
					<li><a href="/faq">FAQ</a></li>
					<li><a href="/contacto"><?php echo sparkfb_t( 'Contacto', 'Contact' ); ?></a></li>
					<li><a href="/custom">Custom Orders</a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h4><?php echo sparkfb_t( 'Síguenos', 'Follow us' ); ?></h4>
				<ul>
					<li><a href="https://instagram.com/sparkfb" target="_blank" rel="noopener">Instagram</a></li>
					<li><a href="https://tiktok.com/@sparkfb" target="_blank" rel="noopener">TikTok</a></li>
					<li><a href="https://youtube.com/@sparkfb" target="_blank" rel="noopener">YouTube</a></li>
				</ul>
			</div>

		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo date( 'Y' ); ?> Spark Fingerboards. <?php echo sparkfb_t( 'Todos los derechos reservados.', 'All rights reserved.' ); ?></span>
			<span>Lima, Perú</span>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
