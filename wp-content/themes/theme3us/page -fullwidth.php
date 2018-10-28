<?php 
// Template Name: Page Full Width
get_header(); ?>

<div class="container">
	<div id="content" class="site-content">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; ?>
	</div><!-- .site-content -->

</div><!-- .container -->

<?php get_footer(); ?>
