<?php

$title = $cat = $limit = $class = '';

extract( $atts );

$classes = $class ? $class : '';
if( $cat ) {
    $tax_query = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => (int)$cat,
        )
    );
} else {
    $tax_query = '';
}

?>

<div class="blogs-category">

    <h2 class="title"> <?php echo $title; ?> </h2>

        <?php

            $args = array(

                'posts_per_page'    => $limit,

                'post_type'         => 'post',

                'tax_query' => $tax_query,

            );

            $the_query = new WP_Query( $args );

        ?>

        <?php if ( $the_query->have_posts() ) : ?>

        <?php

            $i=0;

            while ( $the_query->have_posts() ) : $the_query->the_post();

                $i++;

                if ( $i == 1 ) {

                    get_template_part( 'content', 'cat-first' );

                } else {

                    get_template_part( 'content', 'cat-item' );

                };

            endwhile;

            wp_reset_postdata(); 

        ?>

<?php else : ?>

<p> <?php _e( 'Sorry, no posts matched your criteria.' ); ?> </p>

<?php endif; ?>

</div>