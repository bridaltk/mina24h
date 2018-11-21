<article id="post-<?php the_ID(); ?>" data-delay="100" <?php post_class( 'top-blogs-item big-item ' ); ?> itemscope itemtype="http://schema.org/Article">
    <div class="post-thumb">
        <a class="overlay" href="<?php the_permalink(); ?>">
            <?php echo get_BFI_thumbnail( get_post_thumbnail_id( $post->ID ), 470, 270 ); ?>
        </a>
        <?php 
            $term = get_the_category();
            if( $term ) {
                echo '<a style="background-color: ' . get_field( 'background_color', 'category_' . $term[0]->term_id ) . '" class="post-cat" href="' . get_term_link( $term[0] ) . '">' . $term[0]->cat_name . '</a>';
            }
        ?>
    </div><!-- post-thumb -->

    <?php threeus_post_meta(); ?>

    <div class="post-info">
        <h3 class="post-title entry-title" itemprop="name headline"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_title() ), 30, '') ?></a></h3>
        <div class="post-desc">
            <?php echo wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_excerpt() ), 44, '...' ) ?>
        </div>
    </div><!-- .post-info -->
</article><!-- top-blogs-item -->