<article id="post-<?php the_ID(); ?>" data-delay="100" <?php post_class( 'blogs-item clearfix' ); ?> itemscope itemtype="http://schema.org/Article">
    <div class="post-thumb">
        <a class="overlay" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
    </div><!-- post-thumb -->

    <div class="post-info">
        <h3 class="post-title entry-title" itemprop="name headline"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title() ), 18, '') ?></a></h3>
        <div class="post-meta date-ago"><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'trước' ); ?></div>
    </div><!-- .post-info -->
</article><!-- .blogs-item -->