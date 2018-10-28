<?php
get_header(); ?>

	<section class="container">

		<div class="row">
			
			<div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">
			
			<?php 
				global $wp_query;
				 echo '<h1>' . esc_html__( 'Tìm thấy ', 'threeus' ) . $wp_query->found_posts . esc_html__( ' kết quả', 'threeus' ) . ' với từ khóa: ' . '"' . '<strong>' . get_search_query() . '"' . '</strong>' . '</h1>';
				get_search_form();
			?>
			<?php if ( have_posts() ) :
				/**
				 * Start the Loop
				 */
				while ( have_posts() ) : the_post();
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				
				endwhile;

					threeus_pagination();

				else :

					get_template_part( 'content', 'none' );

				endif; 
			?>

			</div><!-- #content -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->

	</section><!-- .container -->

<?php get_footer(); ?>
