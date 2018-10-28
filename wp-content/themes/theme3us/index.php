<?php
get_header(); 
?>	
	<div class="container">

		<?php include_once get_template_directory() . '/inc/structure/breadcrumbs.php'; ?>

		<div class="row">

			<div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">
			
				<?php if ( have_posts() ) :

					// Start the loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					// End the loop.
					endwhile;

					// Previous/next page navigation.
					threeus_pagination();

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'content', 'none' );

				endif;
				?>
			</div><!-- #content -->

			<?php get_sidebar(); ?>

		</div>
		
	</div><!-- .container -->

<?php get_footer(); ?>
