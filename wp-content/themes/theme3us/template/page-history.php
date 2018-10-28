<?php 
// Template Name: Page History
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
            <h2><?php echo esc_html_e( 'Lịch sử giao dịch' , 'threeus' ) ?></h2>
            <table class="member-history table table-bordered table-customize table-responsive">
                <thead>
                    <tr>
                        <th><?php echo esc_html_e( 'Nội dung', 'threeus' ); ?></th>
                        <th><?php echo esc_html_e( 'Thời gian', 'threeus' ); ?></th>
                        <th><?php echo esc_html_e( 'Số Points', 'threeus' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $current_user = wp_get_current_user(); ?>
                    <?php 
                        $points_option = get_option( 'points_option' );
                        if( $points_option ) :
                        foreach ($points_option as $key => $item) { 
                            if ($current_user->ID == $item['author']) {
                            $user_info = get_userdata($item['author']);
                            $display_name = $user_info->display_name;
                            $user_login = $user_info->user_login;
                    ?>
                    <tr class="even thread-even depth-1">
                        <td data-title="<?php echo esc_html__( 'Nội dung', 'threeus' ); ?>"><?php echo esc_html_e('Thanh toán bài viết: "') . get_the_title( $item['post_id'] ) . '"'; ?></td>
                        <td data-title="<?php echo esc_html__( 'Thời gian', 'threeus' ); ?>"><?php echo $item['date']; ?></td>
                        <td data-title="<?php echo esc_html__( 'Số Points', 'threeus' ); ?>"><?php echo '+' . $item['point']; ?></td>
                    </tr>
                    <?php } } endif; ?>
                    <?php 
                        $withdrawal = get_option( 'withdrawal' );
                        if( $withdrawal ) :
                        foreach ($withdrawal as $key => $item) { 
                            if ($current_user->ID == $item['user_id']) {
                            if( $item['status'] ) :
                            $user_info = get_userdata($item['user_id']);
                            $display_name = $user_info->display_name;
                            $user_login = $user_info->user_login;
                    ?>
                    <tr class="even thread-even depth-1">
                        <td><?php echo esc_html_e('Thanh toán cho yêu cầu rút tiền: "') . $item['message'] . '"'; ?></td>
                        <td><?php echo $item['date']; ?></td>
                        <td><?php echo '-' . $item['number']; ?></td>
                    </tr>
                    <?php endif; } } endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once get_template_directory() . '/inc/structure/footer-account.php'; ?>