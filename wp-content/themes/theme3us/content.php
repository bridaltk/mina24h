<article id="post-<?php the_ID(); ?>" data-delay="100" <?php post_class( 'featured-item clearfix animation3 inbottom' ); ?> itemscope itemtype="http://schema.org/Article">
	<div class="post-thumb">
		<a class="overlay" href="<?php the_permalink(); ?>">
            <?php echo get_BFI_thumbnail( get_post_thumbnail_id( $post->ID ), 270, 180 ); ?>
        </a>
	</div><!-- post-thumb -->

	<div class="post-info">
		<h3 class="post-title entry-title" itemprop="name headline"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>

		<?php threeus_post_meta(); ?>

		<div class="post-desc"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_excerpt() ), 45, '...' ) ?></div>
	</div><!-- .post-info -->
</article>