<?php
    function create_posttype_question() {

        register_post_type( 'question',
        // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Question' ),
                    'singular_name' => __( 'question' )
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'revisions',
                ),
                'public' => true,
                'has_archive' => true,
                'menu_icon'   => 'dashicons-format-status',
                'rewrite' => array('slug' => 'project'),
            )
        );
    }
    // Hooking up our function to theme setup
    add_action( 'init', 'create_posttype_question' );

    // add_action( 'init', 'create_category_question' );

    // function create_category_question() {
    //     register_taxonomy(
    //         'question_category',
    //         'question',
    //         array(
    //             'label' => __( 'Chuyên mục' ),
    //             'rewrite' => array( 'slug' => 'question-category' ),
    //             'hierarchical' => true,
    //             'show_admin_column' => true
    //         )
    //     );
    // }
?>