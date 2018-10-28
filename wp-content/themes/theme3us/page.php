<?php get_header(); ?>

	<div class="container">

		<?php include_once get_template_directory() . '/inc/structure/breadcrumbs.php'; ?>

		<div class="row">

			<div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">
				<article <?php post_class(); ?>>
					<?php while ( have_posts() ) : the_post(); ?>

						<div class="entry-header">
							<h1 class="page-title entry-title"><?php the_title(); ?></h1>
						</div><!-- .entry-header -->

						<div class="entry-content">
							<?php the_content(); ?>
						</div><!-- .entry-content -->

					<?php endwhile; ?>
				</article>
			</div><!-- .site-content -->

			<?php get_sidebar(); ?>
			
		</div><!-- .row -->		

	</div><!-- .container -->

<?php get_footer(); ?>
