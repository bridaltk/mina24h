<article id="post-<?php the_ID(); ?>" <?php post_class( 'top-list-item clearfix animation3 inbottom' ); ?> data-delay="100" itemscope itemtype="http://schema.org/Article">
    <div class="post-thumb">
        <a class="overlay" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'thumbnail' ); ?>
        </a> 
    </div><!-- post-thumb -->

    <div class="post-info">
        <h3 class="post-title entry-title" itemprop="name headline"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title() ), 20, '') ?></a></h3>

    </div><!-- .post-info -->
</article><!-- .top-list-item -->