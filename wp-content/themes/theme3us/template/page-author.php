<?php
// Template Name: Page Author
get_header(); ?>
    <div class="container">
        <div class="row">
            <div id="content" class="site-content site-author col-md-9">
                <div class="author-order">
                    <form method="GET">
                        <div class="orderby">
                            <span><?php echo esc_html__('Sắp xếp theo: '); ?></span>
                            <?php
                            $filter = array(
                                array(
                                    'label' => __('Bài viết nhiều nhất', 'threeus'),
                                    'value' => 'post_count'
                                ),
                                array(
                                    'label' => __('Mới gia nhập', 'threeus'),
                                    'value' => 'order_new'
                                ),
                                array(
                                    'label' => __('Đánh giá cao nhất', 'threeus'),
                                    'value' => 'order_rating'
                                )
                            );
                            ?>
                            <div class="field-select">
                                <select name="orderby">
                                    <?php
                                    foreach ($filter as $key => $option) {
                                        if ($option['value'] == $_GET['orderby']) {
                                            echo '<option selected value="' . $option['value'] . '">' . $option['label'] . '</option>';
                                        } else {
                                            echo '<option value="' . $option['value'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="order">
                            <button type="submit" name="view" value="grid"><i class="fa fa-th" aria-hidden="true"></i>
                            </button>
                            <button type="submit" name="view" value="list"><i class="fa fa-list" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $('select[name="orderby"]').on('change', function (event) {
                            event.preventDefault();
                            var newUrl = '<?php echo get_the_permalink(); ?>';
                            var orderby = $(this).val();
                            if (orderby) {
                                newUrl = newUrl + '?orderby=' + orderby;
                            }
                            window.location.href = newUrl;
                        });
                    });
                </script>
                <div class="site-author-content">
                    <?php
                    $number = 12;
                    $orderby = $_GET['orderby'];
                    if (!isset($orderby)) {
                        $orderby = 'post_count';
                    }
                    $view = $_GET['view'];
                    if (!isset($view)) {
                        $view = 'grid';
                    }
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $offset = ($paged - 1) * $number;


                    switch ($orderby) {
                        case 'order_rating':
                            $sql = "SELECT u.*, m.meta_value
                            FROM wp_users u, wp_usermeta m
                            where u.id in (SELECT distinct post_author FROM `wp_posts` WHERE post_type='post' and post_status='publish')
                            and m.user_id=u.id 
                            and m.meta_key='rating_average' 
                            order by m.meta_value desc";
                            break;
                        case 'order_new':
                            $sql = "SELECT u.*, COUNT(p.id) as post_count  
                            FROM wp_posts p, wp_users u 
                            where p.post_type='post' 
                            and p.post_status='publish' 
                            and u.id = p.post_author 
                            GROUP by p.post_author
                            order by u.user_registered DESC";
                            break;
                        default:
                            $sql = "SELECT u.*, COUNT(p.id) as post_count 
                            FROM wp_posts p, wp_users u 
                            where p.post_type='post' 
                            and p.post_status='publish' 
                            and u.id = p.post_author 
                            GROUP by p.post_author
                            order by post_count DESC";
                            break;

                    };
                    global $wpdb;
                    $sql = $sql . " LIMIT " . $number . " OFFSET " . $offset;
                    $users = $wpdb->get_results($sql);
                    $total_users = $wpdb->get_var("SELECT count(distinct post_author) FROM `wp_posts` WHERE post_type='post' and post_status='publish'");
                    $total_pages = intval(($total_users - 1) / $number) + 1;
                    //                error_log("number: " . $number . " offet: " . $offset . " total qeury: " . $total_query . " totaol user: " . $total_users . " total page: " . $total_pages);
                    ?>

                    <?php if ($view == 'list') : ?>
                        <table class="member-list table table-bordered table-customize table-responsive">
                            <thead>
                            <tr>
                                <th><?php echo esc_html__('Tác giả', 'threeus'); ?></th>
                                <th><?php echo esc_html__('Nghề nghiệp', 'threeus'); ?></th>
                                <th><?php echo esc_html__('Số bài viết', 'threeus'); ?></th>
                                <th><?php echo esc_html__('Đánh giá', 'threeus'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $author) { ?>
                                <tr>
                                    <td data-title="<?php echo esc_html__('Tác giả', 'threeus'); ?>">
                                        <a href="<?php echo get_author_posts_url($author->ID); ?>">
                                            <?php echo threeus_get_avatar($author->ID, 40); ?>
                                            <span><?php the_author_meta('display_name', $author->ID); ?></span>
                                        </a>
                                    </td>
                                    <td data-title="<?php echo esc_html__('Nghề nghiệp', 'threeus'); ?>">
                                        <?php echo get_field('user_job', 'user_' . $author->ID); ?>
                                    </td>
                                    <td data-title="<?php echo esc_html__('Số bài viết', 'threeus'); ?>">
                                        <?php echo count_user_posts($author->ID) . ' bài'; ?>
                                    </td>
                                    <td data-title="<?php echo esc_html__('Đánh giá', 'threeus'); ?>">
                                        <?php
                                        $args = array(
                                            'author' => $author->ID,
                                            'posts_per_page' => -1
                                        );
                                        $loop = new WP_Query($args);
                                        $posts_id = [];
                                        while ($loop->have_posts()) : $loop->the_post();
                                            array_push($posts_id, get_the_ID());
                                        endwhile;
                                        wp_reset_query();
                                        $count_posts = wp_count_posts();
                                        $published_posts = $count_posts->publish;
                                        $sum = 0;
                                        $i = 0;
                                        $kk = kk_star_ratings_get(intval($published_posts));
                                        foreach ($kk as $post) {
                                            if (in_array($post->ID, $posts_id)) {
                                                $sum = $sum + $post->ratings;
                                                $i++;
                                            }
                                        }
                                        if ($i == 0) {
                                            echo '<span class="rating">Chưa có đánh giá</span>';
                                            update_field('rating_average', 0, 'user_' . $author->ID);
                                        } else {
                                            $rating = number_format((floatval($sum) / (int)$i), 1);
                                            update_field('rating_average', $rating, 'user_' . $author->ID);
                                            $rating_per = ($rating / 5) * 100;
                                            ?>
                                            <span class="rating">
																<span class="rating_star"><span
                                                                            style="width: <?php echo $rating_per; ?>%"></span></span>
															</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="row">
                            <?php foreach ($users as $author) { ?>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                    <div class="member-item">
                                        <div class="member-avatar">
                                            <a class="hover" href="<?php echo get_author_posts_url($author->ID); ?>">
                                                <?php echo threeus_get_avatar($author->ID, 195); ?>
                                            </a>
                                        </div><!-- member-thumb -->
                                        <div class="member-info">
                                            <h3 class="member-name"><a
                                                        href="<?php echo get_author_posts_url($author->ID); ?>"><?php the_author_meta('display_name', $author->ID); ?></a>
                                            </h3>
                                            <span class="member-job"><?php echo get_field('user_job', 'user_' . $author->ID); ?></span>
                                            <div class="member-bot">
                                                <div class="member-rating">
                                                    <?php
                                                    $args = array(
                                                        'author' => $author->ID,
                                                        'posts_per_page' => -1
                                                    );
                                                    $loop = new WP_Query($args);
                                                    $posts_id = [];
                                                    while ($loop->have_posts()) : $loop->the_post();
                                                        array_push($posts_id, get_the_ID());
                                                    endwhile;
                                                    wp_reset_query();
                                                    $count_posts = wp_count_posts();
                                                    $published_posts = $count_posts->publish;
                                                    $sum = 0;
                                                    $i = 0;
                                                    $kk = kk_star_ratings_get(intval($published_posts));
                                                    foreach ($kk as $post) {
                                                        if (in_array($post->ID, $posts_id)) {
                                                            $sum = $sum + $post->ratings;
                                                            $i++;
                                                        }
                                                    }
                                                    if ($i == 0) {
                                                        echo '<span class="rating">Chưa có đánh giá</span>';
                                                        update_field('rating_average', 0, 'user_' . $author->ID);
                                                    } else {
                                                        $rating = number_format((floatval($sum) / (int)$i), 1);
                                                        update_field('rating_average', $rating, 'user_' . $author->ID);
                                                        $rating_per = ($rating / 5) * 100;
                                                        ?>
                                                        <span class="rating">
																		<?php esc_html_e('Đánh giá', 'threeus'); ?>
                                                            <span class="rating_star"><span
                                                                        style="width: <?php echo $rating_per; ?>%"></span></span>
																	</span>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                                <div class="member-count">
                                                    <span><?php echo esc_html__('Số bài viết: ') ?></span><?php echo count_user_posts($author->ID); ?>
                                                </div>
                                            </div>


                                        </div><!-- .member-info -->
                                    </div><!-- .member-item -->
                                </div>
                            <?php } ?>
                        </div>

                    <?php endif; ?>
                    <?php
                    if ($total_users > $number) {
                        echo '<div class="page-navigation clearfix" role="navigation">';
                        echo '<nav class="page-nav">';
                        echo paginate_links(array(
                            'current' => $paged,
                            'total' => $total_pages,
                            'type' => 'plain',
                            'prev_text' => '<i class="fa fa-angle-left"></i>',
                            'next_text' => '<i class="fa fa-angle-right"></i>'
                        ));
                        echo '</nav>';
                        echo '</div>';
                    }
                    ?>
                    <?php // }; ?>
                </div>
            </div><!-- .site-content -->

            <?php get_sidebar_primary(); ?>
        </div>

    </div><!-- .container -->

<?php get_footer(); ?>