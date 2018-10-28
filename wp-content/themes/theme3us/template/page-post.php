<?php 
// Template Name: Page Post
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
            <h2><?php echo esc_html_e( 'Bài viết của tôi', 'threeus' ); ?></h2>
            <table class="member-posts table table-bordered table-customize table-responsive">
                <thead>
                    <tr>
                        <th role="columnheader"><?php echo esc_html_e( 'Tiêu đề', 'threeus' ); ?></th>
                        <th role="columnheader"><?php echo esc_html_e( 'Tác giả', 'threeus' ); ?></th>
                        <th role="columnheader"><?php echo esc_html_e( 'Chuyên mục', 'threeus' ); ?></th>
                        <th role="columnheader"><?php echo esc_html_e( 'Thẻ', 'threeus' ); ?></th>
                        <th role="columnheader"><?php echo esc_html_e( 'Thời gian', 'threeus' ); ?></th>
                        <th role="columnheader"><?php echo esc_html_e( 'Số point', 'threeus' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $current_user = wp_get_current_user();
                        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                        $args = array(
                            'author'        =>  $current_user->ID,
                            'post_type' => 'post',
                            'posts_per_page' => 10,
                            'paged'          => $paged,
                            'post_status'    => array( 'publish', 'pending' ),
                        );
                        $the_query = new WP_Query( $args );
                        while ($the_query->have_posts() ) : $the_query->the_post();
                    ?>
                    <tr>
                        <td role="cell" class="td-post-name" data-title="<?php echo esc_html__( 'Tiêu đề', 'threeus' ); ?>">
                            <?php if( get_post_status() == 'pending' ) : ?>
                                <a href="#">
                                    <?php the_title(); ?>
                                    <?php echo '<em> - ' . esc_html__( 'Chưa duyệt', 'threeus' ) . '</em>'; ?>        
                                </a>
                            <?php else : ?>
                                <a target="_blank" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>     
                                </a>
                            <?php endif; ?>
                        </td>
                        <td role="cell" data-title="<?php echo esc_html__( 'Tác giả', 'threeus' ); ?>"><?php echo $current_user->display_name; ?></td>
                        <td role="cell" data-title="<?php echo esc_html__( 'Chuyên mục', 'threeus' ); ?>"><?php echo get_the_category_list(); ?></td>
                        <td role="cell" data-title="<?php echo esc_html__( 'Thẻ', 'threeus' ); ?>"><?php echo get_the_tag_list('',', ',''); ?></td>
                        <td role="cell" data-title="<?php echo esc_html__( 'Thời gian', 'threeus' ); ?>"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' trước'; ?></td>
                        <td role="cell" data-title="<?php echo esc_html__( 'Số point', 'threeus' ); ?>"><?php echo get_field('post_point'); ?></td>
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
        </div>
    </div>
</div>
<?php include_once get_template_directory() . '/inc/structure/footer-account.php'; ?>