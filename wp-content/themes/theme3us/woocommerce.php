<?php get_header(); ?>

	<div class="container">

		<div class="row">

			<div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">

				<?php woocommerce_content(); ?>

			</div><!-- #content -->

			<?php get_sidebar(); ?>

		</div>
				
	</div><!-- .container -->

<?php get_footer(); ?>
