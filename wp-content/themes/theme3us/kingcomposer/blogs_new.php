<?php
	$title = $number = $class = '';
	extract( $atts );
	$classes = $class ? $class : '';
?>
<aside class="latest-news">
	<h3 class="title widget-title"><?php echo $title; ?></h3>
	<ul class="post-item post">
		<?php
			$args = array(
		       'posts_per_page' => $number,
		       'post_type' => 'post',
		    );
		    $the_query = new WP_Query( $args );
		    while ($the_query->have_posts() ) : $the_query->the_post();
		?>
			
				<li class="post">
					<h4 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title() ), 20, '') ?></a></h4>
				</li>
			
		<?php endwhile; ?>
	</ul><!-- .post-item post -->
</aside><!-- .post-section -->