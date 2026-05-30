<?php defined( 'ABSPATH' ) || exit; ?>

<?php get_header(); ?>

<main class="page-content">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
