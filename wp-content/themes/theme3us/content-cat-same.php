<article id="post-<?php the_ID(); ?>" data-delay="100" <?php post_class( 'blogs-item big-item clearfix' ); ?> itemscope itemtype="http://schema.org/Article">
    <div class="post-thumb">
        <a class="overlay" href="<?php the_permalink(); ?>"><?php echo get_BFI_thumbnail( get_post_thumbnail_id( $post->ID ), 270, 180 ); ?></a>
    </div><!-- post-thumb -->

    <div class="post-info">
        <h3 class="post-title entry-content" itemprop="name headline">
            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title() ), 20, '') ?></a>
        </h3>
    </div>
</article>