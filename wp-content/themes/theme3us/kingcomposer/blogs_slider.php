<?php
	$nav = $dots = $play = $items = $select_post = $post = $class = '';
	extract( $atts );
	$classes = $class ? $class : '';
?>
<div class="blogs-slider-wrapper">
	<div class="container">
		<div class="blogs-slider owl-carousel" data-nav="<?php echo $nav; ?>" data-dots="<?php echo $dots; ?>" data-play="<?php echo $play; ?>" data-items="<?php echo $items; ?>">
			<?php foreach( $select_post as $key => $item ){ ?>
			<article data-delay="100" class="blogs-slider-item post " itemscope itemtype="http://schema.org/Article">
				
					<div class="post-thumb">
						<a href="<?php echo get_the_permalink($item->post); ?>">
						<div class="overlay">
							
							<?php echo get_BFI_thumbnail(get_post_thumbnail_id($item->post), 300, 176 ); ?>
							
						</div>
						</a>
						<?php 
				            $term = get_the_category( $item->post );
				            if( $term ) {
				                echo '<a style="background-color: ' . get_field( 'background_color', 'category_' . $term[0]->term_id ) . '" class="post-cat" href="' . get_term_link( $term[0] ) . '">' . $term[0]->cat_name . '</a>';
				            }
				        ?>
					</div>
					<h3 class="post-title"><a href="<?php echo get_the_permalink($item->post); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title($item->post) ), 20, '') ?></a></h3>
				
			</article><!-- .blogs-slider-item -->
			<?php } ?>
		</div><!-- .post-slide -->
	</div>
</div><!-- .blogs-slider-wrapper -->
