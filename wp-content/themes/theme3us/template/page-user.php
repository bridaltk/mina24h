<?php 
// Template Name: Page User
if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['user_update'] ) && current_user_can('level_0') && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
    $pu_name        = $_POST[ 'pu_name' ];
    $pu_name_show   = $_POST[ 'pu_name_show' ];
    $pu_birthday    = $_POST[ 'pu_birthday' ];
    $pu_address     = $_POST[ 'pu_address' ];
    $pu_phone       = $_POST[ 'pu_phone' ];
    $pu_job         = $_POST[ 'pu_job' ];
    $pu_email       = $_POST[ 'pu_email' ];
    $pu_facebook    = $_POST[ 'pu_facebook' ];
    $pu_instagram   = $_POST[ 'pu_instagram' ];
    $pu_youtube     = $_POST[ 'pu_youtube' ];
    $pu_twitter     = $_POST[ 'pu_twitter' ];
    $pu_content     = $_POST[ 'pu_content' ];
    $pu_avatar      = $_FILES['mp_thumb'];

    $ex_name = explode(' ', $pu_name);
    $first_name = end($ex_name);
    if ($ex_name[0]) {
        $last_name = $ex_name[0];
        if ($ex_name[1] && ($ex_name[1] != end($ex_name))) {
            $last_name = $ex_name[0] . ' ' . $ex_name[1];
            if ($ex_name[2] && ($ex_name[2] != end($ex_name))) {
                $last_name = $ex_name[0] . ' ' . $ex_name[1] . ' ' . $ex_name[2];
                if ($ex_name[3] && ($ex_name[3] != end($ex_name))) {
                    $last_name = $ex_name[0] . ' ' . $ex_name[1] . ' ' . $ex_name[2] . ' ' . $ex_name[3];
                    if ($ex_name[4] && ($ex_name[4] != end($ex_name))) {
                        $last_name = $ex_name[0] . ' ' . $ex_name[1] . ' ' . $ex_name[2] . ' ' . $ex_name[3] . ' ' . $ex_name[4];
                        if ($ex_name[5] && ($ex_name[5] != end($ex_name))) {
                            $last_name = $ex_name[0] . ' ' . $ex_name[1] . ' ' . $ex_name[2] . ' ' . $ex_name[3] . ' ' . $ex_name[4] . ' ' . $ex_name[5];
                        }
                    }
                }
            }
        }
    }
    $current_user = wp_get_current_user();
    if( isset( $_FILES['mp_thumb'] ) && $_FILES['mp_thumb']['name'] != '' ) {
        // These files need to be included as dependencies when on the front end.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        $attachment_id = media_handle_upload( 'mp_thumb', 0 );
        update_user_meta( $current_user->ID, 'avatar', $attachment_id );
    }
    update_user_meta( $current_user->ID, 'first_name', $first_name );
    update_user_meta( $current_user->ID, 'last_name', $last_name );
    // update_user_meta( $current_user->ID, 'display_name', $pu_name_show );
    wp_update_user(array ('ID' => $current_user->ID, 'display_name' => esc_attr( $pu_name_show ) ));
    update_user_meta( $current_user->ID, 'user_birthday', $pu_birthday );
    update_user_meta( $current_user->ID, 'user_address', $pu_address );
    update_user_meta( $current_user->ID, 'user_phone', $pu_phone );
    update_user_meta( $current_user->ID, 'user_job', $pu_job );
    wp_update_user(array ('ID' => $current_user->ID, 'user_email' => esc_attr( $pu_email ) ));
    update_user_meta( $current_user->ID, 'user_facebook', $pu_facebook );
    update_user_meta( $current_user->ID, 'user_instagram', $pu_instagram );
    update_user_meta( $current_user->ID, 'user_youtube', $pu_youtube );
    update_user_meta( $current_user->ID, 'user_twitter', $pu_twitter );
    update_user_meta( $current_user->ID, 'user_about', $pu_content );

    $redirect_url = add_query_arg( 'update', 'true', get_the_permalink() );
    wp_redirect( $redirect_url );
};

include_once get_template_directory() . '/inc/structure/header-account.php'; ?>

<div class="member-main clearfix">
    <div class="member-menu" id="member_menu">
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'account_menu',
                )
            );
        ?>  
    </div>
    <div class="member-right">
        <div class="member-content">
            <?php 
                if( isset( $_GET['update'] ) ) {
                    echo '<div class="alert alert-success"><strong>' . esc_html__( 'Bạn đã cập nhật thành công', 'threeus' ) . '</strong></div>';
                }
            ?>
            <form class="user-update" method="POST" enctype='multipart/form-data'>
                <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
                <h2><?php echo esc_html_e( 'Thông tin cá nhân' , 'threeus' ) ?> <a href="#" class="member-edit"><?php echo esc_html_e('Sửa thông tin'); ?></a><input type="submit" class="input-update" name="user_update" value="Cập nhật"></h2>
                <div class="member-info">
                    <div class="member-main-sidebar push-lg-0 push-0">
                        <div class="mp-thumb mp-item">
                            <h3><?php echo esc_html_e( 'Ảnh đại diện' , 'threeus' ); ?></h3>
                            <div class="mp-content ">
                                <label for="mp-thumb" class="custom-file-upload"><?php echo esc_html_e( 'Chọn ảnh đại diện' , 'threeus' ); ?><input type="file" size="60" id="mp-thumb" name="mp_thumb" onchange="loadFile(event)"></label>
                                <?php echo threeus_get_avatar( $current_user->ID, 200, 'blah' ); ?>
                            </div>
                        </div><!-- .mp-item -->
                    </div>
                    <div class="member-main-content clearfix push-lg-2 push-0">
                        <?php
                            $current_user = wp_get_current_user();
                        ?>
                        <div class="info-box">
                            <h3><?php echo esc_html_e( 'Thông tin cơ bản' , 'threeus' ); ?></h3>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Họ tên:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_name" value="<?php echo $current_user->last_name . ' ' . $current_user->first_name; ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Tên hiển thị:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_name_show" value="<?php echo $current_user->display_name; ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Ngày sinh:' , 'threeus' ); ?></label>
                                <input type="date" name="pu_birthday" value="<?php echo get_field('user_birthday','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Địa chỉ:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_address" value="<?php echo get_field('user_address','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Số điện thoại:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_phone" value="<?php echo get_field('user_phone','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Nghề nghiệp:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_job" value="<?php echo get_field('user_job','user_' . $current_user->ID); ?>" >
                            </div>
                        </div>
                        <div class="info-box">
                            <h3><?php echo esc_html_e( 'Mạng xã hội' , 'threeus' ); ?></h3>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Email:' , 'threeus' ); ?></label>
                                <input type="email" name="pu_email" value="<?php echo $current_user->user_email; ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Facebook:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_facebook" value="<?php echo get_field('user_facebook','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Instagram:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_instagram" value="<?php echo get_field('user_instagram','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Youtube:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_youtube" value="<?php echo get_field('user_youtube','user_' . $current_user->ID); ?>" >
                            </div>
                            <div class="field-input clearfix">
                                <label><?php echo esc_html_e( 'Twitter:' , 'threeus' ); ?></label>
                                <input type="text" name="pu_twitter" value="<?php echo get_field('user_twitter','user_' . $current_user->ID); ?>" >
                            </div>
                        </div>
                        <div class="info-bio">
                            <h3><?php echo esc_html_e( 'Giới thiệu bản thân' , 'threeus' ); ?></h3>
                            <div class="about-me">
                                <?php echo get_field('user_about','user_' . $current_user->ID); ?>
                            </div>
                            <?php 
                                $settings = array(
                                    'textarea_name' => 'pu_content',
                                    'media_buttons' => true,
                                    'tinymce' => array(
                                        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
                                            'bullist,blockquote,|,justifyleft,justifycenter' .
                                            ',justifyright,justifyfull,|,link,unlink,|' .
                                            ',spellchecker,wp_fullscreen,wp_adv'
                                    )
                                );
                            ?>
                            <?php echo wp_editor( get_field('user_about','user_' . $current_user->ID) , 'content', $settings ); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('blah');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
<?php include_once get_template_directory() . '/inc/structure/footer-account.php'; ?>