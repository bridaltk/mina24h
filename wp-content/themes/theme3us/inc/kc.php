<?php

add_action('init', 'kc_blogs_item', 99 );
function kc_blogs_item() {
    if (function_exists('kc_add_map')) :
       $categories = get_terms( 'category' );

        $cat = array();
        $cat[0] = __( 'All Category', 'threeus' );
        foreach ($categories as $key => $value) {
            $cat[$value->term_id] = $value->name;
        }
        kc_add_map(
            array(
                'blogs_item' => array(
                    'name' => __( 'Blog by Category', 'threeus' ),
                    'description' => __( 'Show Purchase History table', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'is_container' => true,
                    'params' => array(
                        array(
                            'name' => 'title',
                            'label' => __( 'Title', 'threeus' ),
                            'type' => 'text',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'limit',
                            'label' => __( 'Number of posts to show', 'threeus' ),
                            'type' => 'number_post',
                            'options' => array(
                                'min' => 0,
                                'max' => 50,
                                'show_input' => true
                            ),
                            'value' => 5,
                        ),
                        array(
                            'name' => 'cat',
                            'label' => __( 'Category', 'threeus' ),
                            'type' => 'dropdown',
                            'options' => $cat
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Extra Class', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}


// Blogs New

add_action('init', 'kc_threeus_blogs_top', 99 );

function kc_threeus_blogs_top() {

    if (function_exists('kc_add_map')) :

        kc_add_map(
            array(
                'blogs_top' => array(
                    'name' => __( 'Post Top', 'threeus' ),
                    'description' => __( 'Show post top', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'params' => array(
                        array(
                            'name' => 'title',
                            'label' => __( 'Title', 'threeus' ),
                            'type' => 'text',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Class thêm', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}


// Blog Slider

add_action('init', 'kc_threeus_blogs_slider', 99 );

function kc_threeus_blogs_slider() {
    
    $args = array(
       'posts_per_page' => -1,
       'post_type' => 'post',
    );
    $the_query = new WP_Query( $args );
    $post = array();
    while ($the_query->have_posts() ) : $the_query->the_post();
        $id = get_the_ID();
        $post[$id] = get_the_title();
    endwhile;

    if (function_exists('kc_add_map')) :

        kc_add_map(
            array(
                'blogs_slider' => array(
                    'name' => __( 'Post Slider', 'threeus' ),
                    'description' => __( 'Post Slider, ...', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'params' => array(
                        array(
                            'name' => 'nav',
                            'label' => __( 'Navigation', 'threeus' ),
                            'type' => 'toggle',
                            'description' => 'Select this if you want to show Navigation',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'dots',
                            'label' => __( 'Dots', 'threeus' ),
                            'type' => 'toggle',
                            'description' => 'Select this if you want to show Dots',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'play',
                            'label' => __( 'Auto Play', 'threeus' ),
                            'type' => 'toggle',
                            'description' => 'Select this if you want to enable auto play',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'items',
                            'label' => __( 'Items Show', 'threeus' ),
                            'type' => 'number_slider',  // USAGE RADIO TYPE
                            'options' => array(    // REQUIRED
                                'min' => 1,
                                'max' => 10,
                                'show_input' => true
                            ),
                            'description' => 'Select number post show on slider',
                            'admin_label' => true,
                        ),
                        array(
                            'type'          => 'group',
                            'label'         => __('Select Post', 'threeus'),
                            'name'          => 'select_post',
                            'description'   => __( 'Repeat this fields with each item created, Each item corresponding processbar element.', 'threeus' ),
                            'options'       => array('add_text' => __('Add new progress bar', 'threeus')),
                            'params' => array(
                                array(
                                    'name' => 'post',
                                    'label' => __( 'Post', 'threeus' ),
                                    'type' => 'dropdown',
                                    'options' => $post
                                ),
                            ),
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Class thêm', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}


// Blogs New

add_action('init', 'kc_threeus_blogs_new', 99 );

function kc_threeus_blogs_new() {

    if (function_exists('kc_add_map')) :

        kc_add_map(
            array(
                'blogs_new' => array(
                    'name' => __( 'Post New', 'threeus' ),
                    'description' => __( 'Show post new, ...', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'params' => array(
                        array(
                            'name' => 'title',
                            'label' => __( 'Title', 'threeus' ),
                            'type' => 'text',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'number',
                            'label' => __( 'Number of posts to show', 'threeus' ),
                            'type' => 'number',
                            'options' => array(
                                'min' => 0,
                                'max' => 50,
                                'show_input' => true
                            ),
                            'value' => 5,
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Class thêm', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}


// Blogs New

add_action('init', 'kc_threeus_blogs_featured', 99 );

function kc_threeus_blogs_featured() {

    if (function_exists('kc_add_map')) :

        kc_add_map(
            array(
                'blogs_featured' => array(
                    'name' => __( 'Post featured', 'threeus' ),
                    'description' => __( 'Show post new, ...', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'params' => array(
                        array(
                            'name' => 'title',
                            'label' => __( 'Title', 'threeus' ),
                            'type' => 'text',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'number',
                            'label' => __( 'Number of posts to show', 'threeus' ),
                            'type' => 'number',
                            'options' => array(
                                'min' => 0,
                                'max' => 50,
                                'show_input' => true
                            ),
                            'value' => 5,
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Class thêm', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}


add_action('init', 'kc_threeus_change_password', 99 );

function kc_threeus_change_password() {
    if (function_exists('kc_add_map')) :

        kc_add_map(
            array(
                'threeus_change_password' => array(
                    'name' => __( 'Password Form', 'threeus' ),
                    'description' => __( 'Show change password form, ...', 'threeus' ),
                    'icon' => 'sl-clock',
                    'category' => 'Content',
                    'params' => array(
                        array(
                            'name' => 'title',
                            'label' => __( 'Title', 'threeus' ),
                            'type' => 'text',
                            'admin_label' => true,
                        ),
                        array(
                            'name' => 'class',
                            'label' => __('Class thêm', 'threeus'),
                            'type' => 'text',
                            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'threeus')
                        ),
                    )
                ),  // End of elemnt kc_icon
            )
        ); // End add map

    endif;
}

?>