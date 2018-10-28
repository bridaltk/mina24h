<?php
	$title = $number = $class = '';
	extract( $atts );
	$classes = $class ? $class : '';
?>

<section class="featured-blogs">
	<h2 class="title"><?php echo $title; ?></h2>
		<?php
			$args = array(
		       'posts_per_page' => $number,
		       'post_type' => 'post',
		       'meta_key' => 'wpb_post_views_count',
		       'orderby'=> 'meta_value_num', 
		       'order' => 'DESC',
		    );

		    $the_query = new WP_Query( $args );
		    while ($the_query->have_posts() ) : $the_query->the_post();
		    	get_template_part( 'content', 'featured' );
			endwhile; 
		?>
</section><!-- .featured-blogs -->