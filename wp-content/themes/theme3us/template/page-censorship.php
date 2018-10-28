<?php 
    // Template Name: Page Censorship
    include_once get_template_directory() . '/inc/structure/header-account.php'; 
?>
<?php 
    $tax_query = '';
    $cat_filter = $author_filter = $date_begin = $date_end = 0;

    if( isset( $_GET['date_begin'] ) ) {
        $date_begin = $_GET['date_begin'];

    };
    if( isset( $_GET['date_end'] ) ) {
        $date_end = $_GET['date_end'];
    };

    if( isset( $_GET['filter_cat'] ) && $_GET['filter_cat'] > 0 ) {
        $tax_query = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $_GET['filter_cat'],
            ),
        );
        $cat_filter = $_GET['filter_cat'];
    };

    if( isset( $_GET['filter_author'] ) && $_GET['filter_author'] > 0 ) {
        $author_filter = $_GET['filter_author'];
    };
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
    </div>
    <div class="member-right">
        <div class="member-content">
            <?php
                $current_user = wp_get_current_user();
                if (user_can( $current_user, 'administrator' ) || user_can( $current_user, 'editor' )) { ?>
                <h2><?php echo esc_html_e( 'Xét duyệt bài viết', 'threeus' ); ?></h2>
                <form class="member-filter" action="" method="GET">
                    <div class="member-filter">
                        <div class="mf-date mf-item">
                            <span class="since"><?php echo esc_html_e( 'Từ ngày', 'threeus' ); ?></span>
                            <input type="date" name="date_begin" value="<?php echo $date_begin; ?>" data-placeholder="Tất cả các ngày" >
                            <span>-</span>
                            <input type="date" name="date_end" value="<?php echo $date_end; ?>">
                        </div>
                        <div class="mf-category mf-item">
                            <?php 
                                $args = array(
                                    'show_option_all'    => '',
                                    'show_option_none'   => __( 'Tất cả chuyên mục', 'threeus' ),
                                    'option_none_value'  => 0,
                                    'hierarchical'       => true,
                                    'show_count'         => 0,
                                    'hide_empty'         => 0,
                                    'child_of'           => 0,
                                    'exclude'            => '',
                                    'include'            => '',
                                    'selected'           => $cat_filter,
                                    'echo'               => 1,
                                    'name'               => 'filter_cat',
                                    'depth'              => 0,
                                    'tab_index'          => 1,
                                    'taxonomy'           => 'category',
                                    'value_field'        => 'term_id',
                                );
                            ?>
                            <?php wp_dropdown_categories( $args ); ?>
                        </div>
                        <div class="mf-author mf-item">
                            <select name="filter_author">
                                <option value="0"><?php echo esc_html_e( 'Tất cả tác giả', 'threeus' ); ?></option>
                                <?php
                                    $users = get_users();
                                    foreach ($users as $user) {
                                        if( $user->ID == $author_filter ) {
                                            echo '<option selected value="'. $user->ID .'"> ' . $user->display_name . '</option>'; 
                                        } else {
                                            echo '<option value="'. $user->ID .'"> ' . $user->display_name . '</option>'; 
                                        };
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="filter" value="<?php echo esc_html_e( 'Lọc', 'threeus' ); ?>">
                    </div>
                </form>
                <table class="member-posts table table-bordered table-customize table-responsive">
                    <thead>
                        <tr>
                            <th><?php echo esc_html_e( 'Tiêu đề', 'threeus' ); ?></th>
                            <th><?php echo esc_html_e( 'Tác giả', 'threeus' ); ?></th>
                            <th><?php echo esc_html_e( 'Chuyên mục', 'threeus' ); ?></th>
                            <th><?php echo esc_html_e( 'Thẻ', 'threeus' ); ?></th>
                            <th><?php echo esc_html_e( 'Thời gian', 'threeus' ); ?></th>
                            <th><?php echo esc_html_e( 'Số point', 'threeus' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $current_user = wp_get_current_user();
                            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                            $args = array(
                                'post_type'      => 'post',
                                'post_status'    => 'any',
                                'posts_per_page' => 10,
                                'paged'          => $paged,
                                'tax_query'      => $tax_query,
                                'author'         => $author_filter,
                                'date_query' => array(
                                    array(
                                        'after'     => $date_begin,
                                        'before'    => $date_end,
                                        'inclusive' => true,
                                    ),
                                ),
                            );

                            $the_query = new WP_Query( $args );
                            while ($the_query->have_posts() ) : $the_query->the_post();
                                $new_post_link = get_field( 'acf_new_post', 'option' );
                                $edit_link = add_query_arg( array(
                                    'edit' => get_the_ID()
                                ), $new_post_link );
                        ?>
                        <tr>
                            <td class="td-post-name" data-title="<?php echo esc_html__( 'Tiêu đề', 'threeus' ); ?>">
                                <?php if( get_post_status() == 'pending' ) : ?>
                                    <a href="<?php echo esc_url( $edit_link ); ?>">
                                        <?php the_title(); ?>
                                        <?php echo '<em> - ' . esc_html__( 'Chưa duyệt', 'threeus' ) . '</em>'; ?>        
                                    </a>
                                <?php else : ?>
                                    <a target="_blank" href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>     
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td data-title="<?php echo esc_html__( 'Tác giả', 'threeus' ); ?>"><?php echo get_the_author(); ?></td>
                            <td data-title="<?php echo esc_html__( 'Chuyên mục', 'threeus' ); ?>"><?php echo get_the_category_list(); ?></td>
                            <td data-title="<?php echo esc_html__( 'Thẻ', 'threeus' ); ?>"><?php echo get_the_tag_list('',', ',''); ?></td>
                            <td data-title="<?php echo esc_html__( 'Thời gian', 'threeus' ); ?>"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' trước'; ?></td>
                            <td data-title="<?php echo esc_html__( 'Số point', 'threeus' ); ?>"><?php echo get_field('post_point'); ?></td>
                        </tr>
                        <?php
                            endwhile;
                            wp_reset_query();
                        ?>
                    </tbody>
                </table>
                <div class="page-navigation clearfix" role="navigation">
                    <nav class="page-nav">
                        <?php
                            $big = 999999999; // need an unlikely integer

                            echo paginate_links( array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, get_query_var('paged') ),
                                'total' => $the_query->max_num_pages,
                                'type'      => 'plain',
                                'prev_text' => '<i class="fa fa-angle-left"></i>',
                                'next_text' => '<i class="fa fa-angle-right"></i>'
                            ) );
                        ?>
                    </nav>
                </div>
            <?php } else { ?>
                <h2><?php echo esc_html_e( 'Xin lỗi! Bạn không thể truy cập trang này!', 'threeus' ); ?></h2>
            <?php } ?>
        </div>
    </div>
</div>
<?php include_once get_template_directory() . '/inc/structure/footer-account.php'; ?>