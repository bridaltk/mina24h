<?php
    $title = $class = '';
    extract( $atts );
    $classes = $class ? $class : '';
?>

<div class="blog-top-box <?php echo $classes; ?>">
    <div class="row">
        <?php
            $args = array(
               'post_type' => 'post',
               'posts_per_page' => 5,
                'meta_key'       => 'blogs_top', 
                'meta_value'    => 'Yes'   
            );
            $the_query = new WP_Query( $args );
        ?>
        <?php if ( $the_query->have_posts() ) : ?>

            <?php
                $i=0;
                while ( $the_query->have_posts() ) : $the_query->the_post();
                    $blogs_top = get_field('blogs_top');
                    $i++;
                    if ( $i == 1 ) {
                        get_template_part( 'content', 'blog-top' );

                    } else { 
                        get_template_part( 'content', 'top-list' );
                    }
                endwhile;
                wp_reset_postdata(); 
            ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>
    </div>
</div><!-- .blog-top-box -->