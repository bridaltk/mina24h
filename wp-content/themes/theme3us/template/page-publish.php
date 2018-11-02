<?php 
// Template Name: Page Publish
include_once get_template_directory() . '/inc/structure/header-account.php'; ?>
<?php 
    $edit_id = 0;
    if( isset( $_GET['edit'] ) ) $edit_id = $_GET['edit'];
?>
<div class="member-main clearfix">
    <div class="member-menu" id="member_menu">
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'account_menu',
                )
            );
        ?>
    </div><!-- .member-menu -->
    <div class="member-right">
        <div class="member-content">
            <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['add_new_post'] ) && current_user_can('level_0') && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
                if (isset($_POST['mp_title'])) {
                    $mp_title = $_POST['mp_title'];
                }
                if (isset($_POST['mp_content'])) {
                    $mp_content = $_POST['mp_content'];
                }
                $mp_cat = $mp_tag = $post_related = $posts_top = "";
                if (isset($_POST['s'])) {
                    $mp_cat = $_POST['s'];
                }
                if (isset($_POST['tag'])) {
                    $mp_tag = $_POST['tag'];
                }
                if (isset($_POST['post_related'])) {
                    $post_related = $_POST['post_related'];
                }
                if (isset($_POST['posts_top'])) {
                    $posts_top = $_POST['posts_top'];
                }
                if (isset($_POST['excerpt'])) {
                    $excerpt = $_POST['excerpt'];
                }

                if( $edit_id ) {
                    $post_status = get_post_status( $edit_id );
                    $post = array(
                        'ID'            => $edit_id,
                        'post_title'    => wp_strip_all_tags($mp_title),
                        'post_content'  => $mp_content,
                        'tags_input'    => $mp_tag,
                        'post_status'   => 'publish',
                        'post_type'     => 'post',
                        'post_excerpt'  => $excerpt,
                        'post_category' => $mp_cat,
                    );
                    $post_id = wp_update_post($post);

                    if ( isset( $_FILES['mp_thumb'] ) && $_FILES['mp_thumb']['name'] != '' ) {
                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );
                        require_once( ABSPATH . 'wp-admin/includes/media.php' );
                        $attachment_id = media_handle_upload( 'mp_thumb', $post_id );
                        update_post_meta($post_id,'_thumbnail_id',$attachment_id);
                    };

                    if( $post_status == 'pending' ) :
                        $mp_point = $_POST['mp_point'];
                        update_post_meta( $post_id, 'post_point', $mp_point );
                        // Update Point in current post and add point to points option
                        $post_author_id = get_post_field( 'post_author', $edit_id );
                        $points_option = get_option( 'points_option' );
                        $mp_point = get_field( 'post_point', $post_id );
                        $args = array(
                            'author'    => $post_author_id,
                            'post_id'   => $post_id,
                            'point'     => $mp_point,
                            'date'      => current_time( 'd/m/Y' ),
                        );

                        // Change role user from subscribe to author
                        $u = new WP_User( $post_author_id );
                        if( $u->roles[0] == 'subscriber' ) {
                            $u->remove_role( 'subscriber' );
                            $u->add_role( 'author' );
                        }
                        
                        $notics = get_user_meta( $post_author_id, 'notic', true );
                        if( $notics ) {
                            $notic = $notics . ',' . $post_id;
                        } else {
                            $notic = $post_id;
                        }
                        update_user_meta( $post_author_id, 'notic', $notic );

                        if( $points_option ) {
                            foreach ($points_option as $key => $value) {
                                if( $value['post_id'] != $post_id ) {
                                    $points_option[] = $args;
                                    $old_point = get_field('user_point','user_' . $post_author_id);
                                    $new_point = intval($old_point) + intval($mp_point);
                                    update_user_meta( $post_author_id, 'user_point', $new_point );
                                    break;
                                }
                                
                            }
                        } else {
                            $points_option[] = $args;
                            $old_point = get_field('user_point','user_' . $post_author_id);
                            $new_point = intval($old_point) + intval($mp_point);
                            update_user_meta( $post_author_id, 'user_point', $new_point );
                        }
                        update_option( 'points_option', $points_option );
                    endif;

                    update_field( 'blogs_top', $posts_top, $post_id );

                    $user_info = get_userdata($post_author_id);
                    $admin_to = $user_info->user_email;
                    $admin_subject = "Thông báo duyệt bài";
                    $admin_txt = "Xin chào " . $user_info->display_name . "!" . "\r\n" . "Bài viết của bạn đã được ban quản trị của chúng tôi duyệt. Cảm ơn bạn đã gửi bài viết cho chúng tôi. Hy vọng chúng tôi sẽ nhận được nhiều bài viết của bạn hơn nữa để cộng đồng Mina24h ngày càng phát triển!" . "\r\n" . "Xem bài viết tại đây: " . get_the_permalink($post_id);
                    $admin_headers = "From: admin@mina24h.com";

                    mail($admin_to,$admin_subject,$admin_txt,$admin_headers);

                } else {
                    $post = array(
                        'post_title'    => wp_strip_all_tags($mp_title),
                        'post_content'  => $mp_content,
                        'tags_input'    => $mp_tag,
                        'post_status'   => 'pending',
                        'post_type'     => 'post',
                        'post_excerpt'  => $excerpt,
                        'post_category' => $mp_cat,
                    );
                    $post_id = wp_insert_post($post);

                    if (isset( $_FILES['mp_thumb'] ) && $_FILES['mp_thumb']['name'] != '') {
                        foreach ($_FILES as $file => $array) {
                            insert_attachment($file,$post_id);
                        }
                    }
                    global $current_user;

                    $attachment_id = '';
                    $post_content = '';
                    $videoFilePath = '';
                    if( ! empty( $_FILES['mp_video'] ) ) {
                        $fileName = str_shuffle('nityanandamaity').'-'.basename($_FILES["mp_video"]["name"]);
                        $targetDir = TEMPLATEPATH . '/video-upload/videos/';
                        $targetUrl = get_template_directory_uri() . '/video-upload/videos/';
                        $targetFile = $targetDir . $fileName;
                        move_uploaded_file($_FILES['mp_video']['tmp_name'], $targetFile);
                        $videoFilePath = 'videos/' . $fileName;
                    }
                    $user_id        = $current_user->ID;

                    add_post_meta($post_id, 'link_upload', $videoFilePath, true);

                    $mp_point = $_POST['mp_point'];
                    update_post_meta( $post_id, 'post_point', $mp_point );
                    update_field( 'blogs_top', $posts_top, $post_id );
                };

                update_field( 'post_related', $post_related, $post_id );
                

                if( $edit_id ) {
                    echo '<div class="alert alert-success"><strong>' . esc_html__( 'Bài viết này đã được đăng thành công. Bạn có thể xem bài viết tại đây:', 'threeus' ) . '</strong> ' . '<a href="' . get_the_permalink( $post_id ) . '" target="_blank">' . get_the_title( $post_id ) . '</a></div>';
                } else {
                    echo '<div class="alert alert-success"><strong>' . esc_html__( 'Bạn đã gửi đăng bài thành công! Bài đăng của bạn sẽ được duyệt trong thời gian sớm nhất!', 'threeus' ) . '</strong></div>';
                };
            }?>
            <?php if( $edit_id ) : ?>
                <h2><?php echo esc_html_e( 'Duyệt bài viết' , 'threeus' ) ?></h2>
            <?php else : ?>
                <h2><?php echo esc_html_e( 'Thêm bài viết' , 'threeus' ) ?></h2>
            <?php endif; ?>

            <form class="publish-form" method="POST" enctype="multipart/form-data">
                <div class="member-main-content">
                    <input type="text" value="<?php if( $edit_id ) echo get_the_title( $edit_id ); ?>" name="mp_title" required="" placeholder="<?php echo esc_html__('Thêm tiêu để bài viết tại đây'); ?>">
                    <?php 
                        $settings = array(
                            'textarea_name' => 'mp_content',
                            'media_buttons' => true,
                            'tinymce' => array(
                                'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                    'bullist,blockquote,|,justifyleft,justifycenter' .
                                    ',justifyright,justifyfull,|,link,unlink,|' .
                                    ',spellchecker,wp_fullscreen,wp_adv'
                            )
                        );
                    ?>
                    <?php 
                        if( $edit_id ) {
                        $post_content = get_post($edit_id); 
                        $content = $post_content->post_content;
                    ?>
                        <?php echo wp_editor( $content , 'content', $settings ); ?>
                    <?php } else { ?>
                        <?php echo wp_editor('' , 'content', $settings); ?>
                    <?php } ?>
                    <div class="mp-post-video">
                        <h3><?php echo esc_html_e( 'Mô tả ngắn' , 'threeus' ); ?></h3>
                        <div class="mp-content ">
                            <label><?php echo esc_html__('Mô tả'); ?>
                                <textarea name="excerpt"><?php if( $edit_id ) echo get_the_excerpt( $edit_id ); ?></textarea>
                            </label>
                        </div>
                   </div>

                    <div class="mp-post-related">
                        <h3><?php echo esc_html_e( 'Bài viết liên quan' , 'threeus' ) ?></h3>
                        <ul>
                        <?php
                        if( $edit_id ) {
                            $post_array = [];
                            $post_objects = get_field('post_related',$edit_id);
                            $post_author_id = get_post_field( 'post_author', $edit_id );
                                if ($post_objects):
                            foreach( $post_objects as $post):
                            array_push($post_array,$post);
                            endforeach;
                            wp_reset_postdata(); endif;
                        ?>
                        <?php
                            $related_array = [];
                            $args = array(
                                'author'        =>  $post_author_id,
                                'posts_per_page' => -1
                            );
                            $loop = new WP_Query( $args );
                            while ( $loop->have_posts() ) : $loop->the_post(); 
                            array_push($related_array,get_the_ID());
                        ?>
                        <?php endwhile; wp_reset_query(); ?>
                        <?php 
                            foreach ($post_array as $value) {
                        ?>
                            <li data-id="<?php $value; ?>"><label for="pr<?php echo $value; ?>"><input type="checkbox" id="pr<?php echo $value; ?>" name="post_related[]" checked="" value="<?php $value; ?>"><?php echo get_the_title($value); ?></label></li>
                        <?php } ?>
                        <?php 
                            $result=array_diff($related_array,$post_array);
                            foreach ($result as $value) {
                        ?>
                            <li data-id="<?php $value; ?>"><label for="pr<?php echo $value; ?>"><input type="checkbox" id="pr<?php echo $value; ?>" name="post_related[]" value="<?php $value; ?>"><?php echo get_the_title($value); ?></label></li>
                        <?php } ?>
                        <?php } else { ?>
                        <?php
                            $args = array(
                                'author'        =>  $current_user->ID,
                                'posts_per_page' => -1
                            );
                            $loop = new WP_Query( $args );
                            while ( $loop->have_posts() ) : $loop->the_post(); 
                        ?>
                            <li data-id="<?php the_ID(); ?>"><label for="pr<?php the_ID(); ?>"><input type="checkbox" id="pr<?php the_ID(); ?>" name="post_related[]" value="<?php the_ID(); ?>"><?php the_title(); ?></label></li>
                        <?php endwhile; wp_reset_query(); ?>
                        <?php } ?>
                        </ul>
                    </div>
                    
                    <div class="mp-post-top">
                        <h3><?php echo esc_html_e( 'Bài viết Top' , 'threeus' ) ?></h3>
                        <ul>
                            <?php if( $edit_id ) { 
                                $field = get_field_object('blogs_top',$edit_id);
                                $value = $field['value'];
                                $label = $field['choices'][ $value ];
                                if ($label == 'yes') { ?>
                                    <li>
                                        <label><input type="radio" checked name="posts_top" value="yes"><?php echo esc_html__('Yes'); ?></label>
                                    </li>
                                    <li>
                                        <label><input type="radio" name="posts_top" value="no"><?php echo esc_html__('No'); ?></label>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <label><input type="radio" name="posts_top" value="yes"><?php echo esc_html__('Yes'); ?></label>
                                    </li>
                                    <li>
                                        <label><input type="radio" checked name="posts_top" value="no"><?php echo esc_html__('No'); ?></label>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                            <li>
                                <label><input type="radio" name="posts_top" value="yes"><?php echo esc_html__('Yes'); ?></label>
                            </li>
                            <li>
                                <label><input type="radio" checked name="posts_top" value="no"><?php echo esc_html__('No'); ?></label>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                   <div class="mp-post-video">
                        <h3><?php echo esc_html_e( 'Upload video' , 'threeus' ); ?></h3>
                        <div class="mp-content ">
                            <a href="<?php echo get_field( 'acf_upvideo','option' ); ?>" target="_Blank"><?php echo esc_html__('Chọn video upload'); ?></a>
                        </div>
                   </div>
                </div><!-- .member-publish-content -->
                <div class="member-main-sidebar">
                    <div class="mp-thumb mp-item">
                        <h3><?php echo esc_html_e( 'Ảnh đại diện' , 'threeus' ); ?></h3>
                        <div class="mp-content ">
                            <label for="mp_thumb" class="custom-file-upload"><?php echo esc_html__('Chọn ảnh đại diện'); ?>
                                <input type="file" size="60" id="mp-thumb" accept="image/*" name="mp_thumb" onchange="loadFile(event)"></label>
                            <img id="blah" src="<?php if( $edit_id ) echo get_the_post_thumbnail_url($edit_id); ?>" alt="" />
                        </div>
                    </div><!-- .mp-item -->
                    <div class="mp-thumb mp-item">
                        <h3><?php echo esc_html_e( 'Chuyên mục' , 'threeus' ); ?></h3>
                        <div class="mp-content mp-cat">
                            <ul class="cat-menu">
                            <?php
                                $parent_cat_arg = array('hide_empty' => false, 'parent' => 0 );
                                $parent_cat = get_terms('category',$parent_cat_arg);
                                if( $edit_id ) {
                                    $count_cat = count($parent_cat);
                                    $p_cat = [];
                                    for ($i=0; $i <= ($count_cat - 1); ) { 
                                        array_push($p_cat,$parent_cat[$i]->term_id);
                                        $i++;
                                    }
                                    $category_detail=get_the_category( $edit_id );
                                    $count = count($category_detail);
                                    $cat = [];
                                    for ($i=0; $i <= ($count - 1); ) { 
                                        array_push($cat,$category_detail[$i]->term_id);
                                        $i++;
                                    }
                                    foreach ($cat as $value) {
                                        echo '<li data-id="'. $value .'"><label for="cat'.$value.'"><input id="cat'.$value.'" type="checkbox" name="s[]" checked="" value="'. $value .'">'.get_cat_name($value).'</label>';
                                        $child_arg = array( 'hide_empty' => false, 'parent' => $value );
                                        $child_cat = get_terms( 'category', $child_arg );
                                        if ($child_cat) {
                                            echo '<ul class="sub-menu">';
                                                foreach( $child_cat as $child_term ) {
                                                    echo '<li data-id="'. $child_term->term_id .'"><label for="'.$child_term->slug.'"><input type="checkbox" id="'.$child_term->slug.'" name="s[]" checked="" value="'. $child_term->term_id .'">'.$child_term->name . '</label></li>'; 
                                                }
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                
                                $result=array_diff($p_cat,$cat);
                                foreach ($result as $catVal) {
                                    echo '<li data-id="'. $catVal .'"><label for="cat'.$catVal.'"><input id="cat'.$catVal.'" type="checkbox" name="s[]" value="'. $catVal .'">'.get_cat_name($catVal).'</label>';
                                    $child_arg = array( 'hide_empty' => false, 'parent' => $catVal );
                                    $child_cat = get_terms( 'category', $child_arg );
                                    if ($child_cat) {
                                        echo '<ul class="sub-menu">';
                                            foreach( $child_cat as $child_term ) {
                                                echo '<li data-id="'. $child_term->term_id .'"><label for="'.$child_term->slug.'"><input type="checkbox" id="'.$child_term->slug.'" name="s[]" value="'. $child_term->term_id .'">'.$child_term->name . '</label></li>'; 
                                            }
                                        echo '</ul>';
                                    }
                                    echo '</li>';
                                } } else {
                                    foreach ($parent_cat as $catVal) {
                                        echo '<li data-id="'. $catVal->term_id .'"><label for="'.$catVal->slug.'"><input id="'.$catVal->slug.'" type="checkbox" name="s[]" value="'. $catVal->term_id .'">'.$catVal->name.'</label>';
                                        $child_arg = array( 'hide_empty' => false, 'parent' => $catVal->term_id );
                                        $child_cat = get_terms( 'category', $child_arg );
                                        if ($child_cat) {
                                            echo '<ul class="sub-menu">';
                                                foreach( $child_cat as $child_term ) {
                                                    echo '<li data-id="'. $child_term->term_id .'"><label for="'.$child_term->slug.'"><input type="checkbox" id="'.$child_term->slug.'" name="s[]" value="'. $child_term->term_id .'">'.$child_term->name . '</label></li>'; 
                                                }
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                }
                            ?> 
                            </ul>
                        </div>
                    </div><!-- .mp-item -->
                    <div class="mp-thumb mp-item">
                        <h3><?php echo esc_html_e( 'Thẻ' , 'threeus' ); ?></h3>
                        <div class="mp-content">
                            <div class="input-tag clearfix">
                                <input type="text" name="mp_tag">
                                <a href="#" class="add_tags"><?php echo esc_html_e( 'Thêm' , 'threeus' ); ?></a>
                            </div>
                            <i class="tag-desc"><?php echo esc_html_e( 'Phân cách các thẻ bằng dấu phẩy (,).' , 'threeus' ); ?></i>
                            <div class="tag-selected">
                                <?php
                                    if( $edit_id ) :
                                    $post_tags = get_the_tags($edit_id);
                                    if ( $post_tags ) {
                                    foreach( $post_tags as $tag ) {
                                ?>
                                    <span><i class="fa fa-times-circle" aria-hidden="true"></i><input type="text" name="tag[]" readonly value="<?php echo $tag->name; ?>" /></span> 
                                <?php } } endif; ?>
                            </div>
                            <div class="tag-options">
                                <p><?php echo esc_html_e( 'Hoặc chọn từ những thẻ có sẵn' , 'threeus' ); ?></p>
                                <div class="tag-list">
                                    <?php
                                        $tags = get_tags(array(
                                          'hide_empty' => false
                                        ));
                                        foreach ($tags as $tag) {
                                    ?>    
                                    <span><?php echo $tag->name; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- .mp-item -->
                    <div class="mp-thumb mp-item">
                        <h3><?php echo esc_html_e( 'Point' , 'threeus' ); ?></h3>
                        <div class="mp-content ">
                            <input type="number" name="mp_point" value="<?php if( $edit_id ) echo get_field('post_point',$edit_id); ?>">
                            <i><?php echo esc_html_e( 'Nhập số point bạn mong muốn nhận được' , 'threeus' ); ?></i>
                        </div>
                    </div><!-- .mp-item -->
                    <div class="mp-item mp_tou">
                        <label>
                            <?php if( $edit_id ) { ?>
                                <input type="checkbox" name="mp_tou" checked="" required="">
                            <?php } else { ?>
                                <input type="checkbox" name="mp_tou" required="">
                            <?php } ?>
                            <span><?php echo esc_html__( 'Đồng ý với', 'threeus' ); ?> <a target="_Blank" href="<?php echo get_field( 'acf_tou', 'option' ); ?>"><?php echo esc_html__( 'điều khoản sử dụng', 'threeus' ); ?></a></span>
                        </label>
                    </div>
                    <div class="mp-thumb mp-item">
                        <input type="hidden" name="add_new_post" value="post" />
                        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
                        <?php if( $edit_id ) { ?>
                            <input type="submit" name="mp_success" value="<?php echo esc_html__('Đăng bài này'); ?>">
                        <?php } else { ?>
                            <input type="submit" name="mp_submit" value="<?php echo esc_html__('Đăng bài'); ?>">
                        <?php } ?>
                    </div>
                </div><!-- .member-publish-sidebar -->
                <input type="text" style="display: none;" name="mp_author" value="<?php echo get_post_field( 'post_author', $edit_id ); ?>">
            </form>
        </div><!-- .member-content -->
    </div>
</div>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('blah');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
<?php include_once get_template_directory() . '/inc/structure/footer-account.php'; ?>