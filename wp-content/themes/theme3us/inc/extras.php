<?php
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function threeus_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'threeus' ),
		'id'            => 'primary-sidebar',
		'description'   => __( 'This is the right sidebar if you are using a two or three column site layout option.', 'threeus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Bottom Sidebar', 'threeus' ),
		'id'            => 'secondary-sidebar',
		'description'   => __( 'This is the bottom sidebar if you are using a two or three column site layout option.', 'threeus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Footer', 'threeus' ),
		'id'            => 'top_footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( __( 'Bottom %s', 'threeus' ), $i ),
			'id'            => 'bottom-' . $i,
			'description'   => sprintf( __( 'Bottom sidebar number %s, used in the header area.', 'threeus' ), $i ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'threeus_theme_widgets_init' );


/**
 * Add class boostrap in main content
 *
 */
if ( ! function_exists( 'main_bootstrap_class' ) ) :
	function main_bootstrap_class() {
		$sidebar_width = get_field( 'acf_sidebar_width', 'option' );
		$page_layout = get_field( 'acf_page_layout', 'option' );

		if( !$sidebar_width ) {
			$sidebar_width = 4;
		}

		if( $page_layout == 'left-main-right' ) {
			$classes = 12 - ($sidebar_width*2);

		} elseif( $page_layout == 'main' ) {
			$classes = 12;

		} else {
			$classes = 12 - $sidebar_width;
		}

		$classes = 'col-md-' . $classes;

		return $classes;
	}
endif;


/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since  1.0
 * @return array
 */
if ( ! function_exists( 'threeus_pagination' ) ) :
	function threeus_pagination( $nav_query = false ) {

		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		// Prepare variables
		$query        = $nav_query ? $nav_query : $wp_query;
		$max          = $query->max_num_pages;
		$current_page = max( 1, get_query_var( 'paged' ) );
		$big          = 999999;

		?>
		<div class="page-navigation clearfix" role="navigation">
			<nav class="page-nav">
				<?php
				echo '' . paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $max,
						'type'      => 'plain',
						'prev_text' => '<i class="fa fa-angle-left"></i>',
						'next_text' => '<i class="fa fa-angle-right"></i>'
					)
				) . ' ';
				?>
			</nav><!-- .page-nav -->
		</div><!-- .page-navigation -->
		<?php
	}
endif;

/**
 * Prints HTML with meta information for the current post-date/time, author, categories and comments.
 *
 * @since  1.0
 * @return array
 */
if ( ! function_exists( 'threeus_post_meta' ) ) :
	function threeus_post_meta() {
	?>
	<ul class="post-meta meta-top">
			<li class="post-author">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo threeus_get_avatar( get_the_author_meta( 'ID' ), 30 ); ?></a>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
			</li>
		<li class="post-date" itemprop="datePublished"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></li>
		<?php 
			global $post;
			$post_view = get_post_meta( $post->ID, 'wpb_post_views_count', true );
		?>
		<li class="post-view"><i class="fa fa-eye"></i> <?php echo $post_view; ?></li>
	</ul>
	<?php

	}
endif;

/**
 * Print URL image with params by BFI thumb
 *
 * @since  1.0
 * @return string (url)
 */
function get_BFI_thumbnail( $att, $width, $height, $surl = false, $classes = NULL ) {
	global $post;

	$classes = $classes ? $classes : '';

	$params = array( 'width' => $width, 'height' => $height );

	$att_id = $att;

	$url = wp_get_attachment_image_src($att_id, 'full');

	$image = aq_resize( $url[0], $width, $height, true );

	$image_alt = get_post_meta( $att_id, '_wp_attachment_image_alt', true);

	if( $surl == true ) {
		return $image;
	} else {
		return '<img class="bfi_thumb' . $classes . '" src="' . $image . '" alt="' . esc_attr( $image_alt ) . '" />';
	}
}

/**
 * Add wordpres ajax url to head tag
 *
 * @since  1.0
 * @return html
 */
function threeus_ajaxurl() {
	global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );
?>
	<script type="text/javascript">
		var ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
		jQuery(document).ready(function($) {
			jQuery( '#cmt-login' ).attr( 'href', '<?php echo wp_login_url( $current_url ); ?>' );
		});
	</script>
<?php
}
add_action('wp_head','threeus_ajaxurl');

function threeus_custom_loginlogo() {
	$logo = get_field( 'acf_form_logo', 'option' );
	if( $logo ) {
		echo '<style type="text/css">
			h1 a {background-image: url(' . $logo['url'] . ') !important; }
		</style>';
	};
}
add_action('login_head', 'threeus_custom_loginlogo');

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return site_url();
}

// Your own login logo title text
function isacustom_wp_login_title() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'isacustom_wp_login_title');


function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' lượt xem';
}
function add_fb_like_to_posts() {   
    $pageName = get_the_permalink();
    $fb_like = '<div class="fb-like" data-href="' . $pageName . '" data-width="70" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>';
    return $fb_like;
}


add_action( 'admin_menu', 'benefit_admin_menu' );
function benefit_admin_menu() {
	add_menu_page(
        __( 'Danh sách tác giả', 'threeus' ),
        __( 'Danh sách tác giả', 'threeus' ),
        'manage_options',
        'tac_gia',
        'threeus_statistical_author',
        'dashicons-chart-area',
		40
    );
	// Create Submenu page
	add_submenu_page(
        'tac_gia',
        __( 'Lịch sử cộng points', 'threeus' ),
        __( 'Lịch sử cộng points', 'threeus' ),
        'manage_options',
        'point_payment',
        'threeus_point_payment_callback'
    );

    add_submenu_page(
        'tac_gia',
        __( 'Yêu cầu rút tiền', 'threeus' ),
        __( 'Yêu cầu rút tiền', 'threeus' ),
        'manage_options',
        'rut_tien',
        'threeus_benefit_callback'
    );


}

/*
* 	Register Withdrawal
*/

function withdrawal() {
	$withdraw_number 		= isset( $_POST[ 'wn' ] ) ? $_POST[ 'wn' ] : '' ;
	$withdraw_content 	= isset( $_POST[ 'wc' ] ) ? $_POST[ 'wc' ] : '' ;
	$current_user = wp_get_current_user();
	$withdrawal = get_option( 'withdrawal' );
	$args = $withdrawal ? $withdrawal : array();
	$args[] = array(
		'user_id' => $current_user->ID,
		'number'  => $withdraw_number,
		'message' => $withdraw_content,
		'date' 	  => current_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ),
		'status'  => 0
	);
	update_option( 'withdrawal', $args );

	exit();
}
add_action('wp_ajax_nopriv_withdrawal', 'withdrawal');
add_action( 'wp_ajax_withdrawal', 'withdrawal' );

function handling() {
	$number_handling 		= isset( $_POST[ 'nh' ] ) ? $_POST[ 'nh' ] : '' ;
	$login_name 		= isset( $_POST[ 'ln' ] ) ? $_POST[ 'ln' ] : '' ;
	$number_array 		= isset( $_POST[ 'na' ] ) ? $_POST[ 'na' ] : '' ;

	$user = get_user_by('login',$login_name);
	$oldPoint = get_user_meta( $user->ID, 'user_point' , true );
	$newPoint = (int)$oldPoint - (int)$number_handling;
	update_field( 'user_point' , $newPoint, 'user_' . $user->ID );
	$withdrawal = get_option( 'withdrawal' );
	$withdrawal[$number_array]['status'] = 1;
	update_option( 'withdrawal', $withdrawal );
	header("Refresh:0");

	exit();
}
add_action('wp_ajax_nopriv_handling', 'handling');
add_action( 'wp_ajax_handling', 'handling' );

function orderDate() {
	$date_start 		= isset( $_POST[ 'ds' ] ) ? $_POST[ 'ds' ] : '' ;
	$date_end 		= isset( $_POST[ 'de' ] ) ? $_POST[ 'de' ] : '' ;

	update_option( 'date_start', $date_start );
	update_option( 'date_end', $date_end );

	exit();
}
add_action('wp_ajax_nopriv_orderDate', 'orderDate');
add_action( 'wp_ajax_orderDate', 'orderDate' );

function addPoint() {
	$mp_point 		= isset( $_POST[ 'mpp' ] ) ? $_POST[ 'mpp' ] : '' ;
	$mp_title 	= isset( $_POST[ 'mpt' ] ) ? $_POST[ 'mpt' ] : '' ;
	$mp_author 	= isset( $_POST[ 'mpa' ] ) ? $_POST[ 'mpa' ] : '' ;
	$addpoint = get_option( 'addpoint' );
	$args = $addpoint ? $addpoint : array();
	$args[] = array(
		'user_id' => $mp_author,
		'number'  => $mp_point,
		'message' => $mp_title,
		'date' 	  => current_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ),
		'status'  => 1
	);
	update_option( 'addpoint', $args );

	exit();
}
add_action('wp_ajax_nopriv_addPoint', 'addPoint');
add_action( 'wp_ajax_addPoint', 'addPoint' );

function current_user() {
	$current_user 		= isset( $_POST[ 'cu' ] ) ? $_POST[ 'cu' ] : '' ;
	delete_user_meta( (int)$current_user, 'notic', '' );
	exit();
}
add_action('wp_ajax_nopriv_current_user', 'current_user');
add_action( 'wp_ajax_current_user', 'current_user' );

/**
 * Search SQL filter for matching against post title only.
 *
 * @link    http://wordpress.stackexchange.com/a/11826/1685
 *
 * @param   string      $search
 * @param   WP_Query    $wp_query
 */
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}

add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );

function my_pre_get_posts($query) {

    if( is_admin() ) 
        return;

    if( is_search() && $query->is_main_query() ) {
        $query->set('post_type', 'post');
    } 

}

add_action( 'pre_get_posts', 'my_pre_get_posts' );


if ( ! function_exists( 'threeus_statistical_author' ) ) {
	function threeus_statistical_author() { 
		$url = get_admin_url() . 'admin.php';
		$urls = add_query_arg( array(
		    'page'   => 'tac_gia',
		), $url );

		?>
			<div class="wrap">
				<h1><?php esc_html_e( 'Danh sách tác giả', 'threeus' ); ?></h1>
					<div class="inner">
						<form class="search-author" method="GET" action="">
							<div class="author-filter tablenav">
								<div class="alignleft actions">
									<select name="posts_count">
										<option value=""><?php esc_html_e( 'Số lượng bài viết', 'threeus' ); ?></option>
										<option <?php if( isset( $_GET['posts_count'] ) && $_GET['posts_count'] == 'DESC' ) echo 'selected'; ?> value="DESC"><?php esc_html_e( 'Giảm dần', 'threeus' ); ?></option>
										<option <?php if( isset( $_GET['posts_count'] ) && $_GET['posts_count'] == 'ASC' ) echo 'selected'; ?> value="ASC"><?php esc_html_e( 'Tăng dần', 'threeus' ); ?></option>
									</select>

									<input value="<?php if( isset( $_GET['sdt'] ) ) echo $_GET['sdt']; ?>" placeholder="<?php esc_html_e( 'Số điện thoại', 'threeus' ); ?>" name="sdt" type="text">
								</div>

								<div class="alignleft actions">
									<span><?php esc_html_e( 'Khoảng points', 'threeus' ); ?></span>
									<input value="<?php if( isset( $_GET['point_min'] ) ) echo $_GET['point_min']; ?>" placeholder="<?php esc_html_e( 'Point min', 'threeus' ); ?>" name="point_min" type="text">
									<span>-</span>
									<input value="<?php if( isset( $_GET['point_max'] ) ) echo $_GET['point_max']; ?>" placeholder="<?php esc_html_e( 'Point max', 'threeus' ); ?>" name="point_max" type="text">
								</div>

								<div class="alignleft actions">
									<input name="filter_action" id="post-query-submit" class="button" value="Lọc" type="submit">
								</div>

								<div class="alignright">								
									<p class="search-box">
										<input value="<?php if( isset( $_GET['author'] ) ) echo $_GET['author']; ?>" id="post-search-input" placeholder="Họ tên" name="author" type="search">
										<input id="search-submit" class="button" value="Tìm kiếm tác giả" type="submit">
									</p>								
								</div>
							</div>
						</form>

						<script type="text/javascript">
							jQuery(document).ready(function($) {
								$( '.search-author' ).on( 'submit', function(event) {
									event.preventDefault();
									var newUrl = '<?php echo $urls; ?>';
									var author = $( this ).find( 'input[name="author"]' ).val();
									if( author ) {
										newUrl = newUrl + '&author=' + author;
									}

									var posts_count = $( this ).find( 'select[name="posts_count"]' ).val();
									if( posts_count ) {
										newUrl = newUrl + '&posts_count=' + posts_count;
									}

									var sdt = $( this ).find( 'input[name="sdt"]' ).val();
									if( sdt ) {
										newUrl = newUrl + '&sdt=' + sdt;
									}

									var point_min = $( this ).find( 'input[name="point_min"]' ).val();
									if( point_min ) {
										newUrl = newUrl + '&point_min=' + point_min;
									}

									var point_max = $( this ).find( 'input[name="point_max"]' ).val();
									if( point_max ) {
										newUrl = newUrl + '&point_max=' + point_max;
									}
									window.location.href = newUrl;
								});
							});
						</script>

						<table class="wp-list-table widefat fixed striped">
							<thead>
								<tr>
									<th class="manage-column column-thumbnail"><?php esc_html_e( 'Ảnh', 'threeus' ); ?></th>
									<th class="manage-column column-user"><?php esc_html_e( 'Họ tên', 'threeus' ); ?></th>
									<th class="manage-column column-birthday"><?php esc_html_e( 'Ngày sinh', 'threeus' ); ?></th>
									<th class="manage-column column-job"><?php esc_html_e( 'Công việc', 'threeus' ); ?></th>
									<th class="manage-column column-phone"><?php esc_html_e( 'Số điện thoại', 'threeus' ); ?></th>
									<th class="manage-column column-post"><?php esc_html_e( 'Số bài viết', 'threeus' ); ?></th>
									<th class="manage-column column-point"><?php esc_html_e( 'Số point', 'threeus' ); ?></th>
								</tr>
							</thead>
							<?php
								if( isset( $_GET['posts_count'] ) ) {
									$posts_count = $_GET['posts_count'];
								} else {
									$posts_count = '';
								}

								if( isset( $_GET['sdt'] ) ) {
									$sdt = $_GET['sdt'];
									$meta_query[] = array(
										'key'     => 'user_phone',
										'value'   => $sdt,
										'compare' => 'LIKE'
									);
								};

								if( isset( $_GET['point_min'] ) ) {
									$point_min = $_GET['point_min'];
									$meta_query[] = array(
										'key'     => 'user_point',
										'value'   => (int)$point_min,
										'compare' => '>='
									);
								};

								if( isset( $_GET['point_max'] ) ) {
									$point_max = $_GET['point_max'];
									$meta_query[] = array(
										'key'     => 'user_point',
										'value'   => (int)$point_max,
										'compare' => '<'
									);
								};

								if( isset( $_GET['author'] ) ) {
									$args = array(
									    'search'         => '*'.esc_attr( $_GET['author'] ).'*',
									    'search_columns' => array(
									        'display_name',
									    ),
									    'orderby' 	  => 'post_count',
									    'order'   	  => $posts_count,
									    'role__in'	  => array( 'author', 'administrator' ),
									    'meta_query'  => array(
									    	'relation' => 'OR',
									    	$meta_query
									    )
									);
								} else {
									$args = array(
									    'orderby' 	  => 'post_count',
									    'order'   	  => $posts_count,
									    'role__in'	  => array( 'author', 'administrator' ),
									    'meta_query'  => array(
									    	'relation' => 'OR',
									    	$meta_query
									    )
									);
								};

								$users = new WP_User_Query( $args );
								$users_found = $users->get_results();
									foreach ($users_found as $user) {
								?>
							<tr class="even thread-even depth-1">
								<td><?php echo threeus_get_avatar( $user->ID , 40 ); ?></td>
								<td>
								<?php 
									$user_info = get_userdata($user->ID);
									$user_name = $user_info->last_name . " " . $user_info->first_name;
									if ($user_name != " ") {
										echo $user_name;
									} elseif ($user_name == " ") {
										echo $user->display_name;
									} 
								?>
								</td>
								<td><?php echo get_field('user_birthday','user_'.$user->ID); ?></td>
								<td><?php echo get_field('user_job','user_'.$user->ID); ?></td>
								<td><?php echo get_field('user_phone','user_'.$user->ID); ?></td>
								<td><?php echo count_user_posts($user->ID); ?></td>
								<td>
									<?php 
										$user_point = get_field('user_point', 'user_'.$user->ID); 
										if ($user_point) {
											echo $user_point;
										} else {
											echo '0';
										}
									?>	
								</td>
							</tr>
							<?php } ?>
						</table>
					</div><!-- .inner -->
			</div><!-- .wrap -->
		<?php 
	}
}

if ( ! function_exists( 'threeus_benefit_callback' ) ) {
	function threeus_benefit_callback() {
		?>
		<script>
			  var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script>
			<div class="wrap">
				<h1><?php esc_html_e( 'Danh sách thành viên yêu cầu rút tiền', 'threeus' ); ?></h1>
					<div class="inner">
						<table class="wp-list-table widefat fixed striped">
							<thead>
								<tr>
									<th class="manage-column column-user"><?php esc_html_e( 'Thành viên', 'threeus' ); ?></th>
									<th class="manage-column column-point"><?php esc_html_e( 'Số tiền cần rút', 'threeus' ); ?></th>
									<th class="manage-column column-message"><?php esc_html_e( 'Nội dung rút tiền', 'threeus' ); ?></th>
									<th class="manage-column column-date"><?php esc_html_e( 'Ngày giờ', 'threeus' ); ?></th>
									<th class="manage-column column-action"><?php esc_html_e( 'Trạng thái', 'threeus' ); ?></th>
								</tr>
							</thead>
							<?php 
								$withdrawal = get_option( 'withdrawal' );
								if( $withdrawal ) :
								$i = 0;
								foreach ($withdrawal as $key => $item) { 
									$user_info = get_userdata($item['user_id']);
									$display_name = $user_info->display_name;
									$user_login = $user_info->user_login;
							?>
							<tr class="even thread-even depth-1">
								<td><?php echo $display_name; ?></td>
								<td><?php echo '-' . number_format($item['number']); ?></td>
								<td><?php echo esc_html_e('Thanh toán cho yêu cầu rút tiền: "') . $item['message'] . '"'; ?></td>
								<td><?php echo $item['date']; ?></td>
								<td>
									<?php if( $item['status'] ) : ?>
										<?php esc_html_e( 'Đã thanh toán', 'threeus' ); ?>
									<?php else : ?>
										<a href="#" class="button button-primary button-large btn-handling"><?php esc_html_e( 'Xử lý', 'threeus' ); ?></a>
									<?php endif; ?>
									<div class="popup-bg" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999;background-color: rgba(0,0,0,0.7); display: none;"></div>
									<div class="popup-handling" style="position: fixed; top: 50%; left: 0; right: 0; transform: translateY(-50%); max-width: 400px; margin: 0 auto; background-color: #fff; text-align: center; z-index: 10000; padding: 30px 20px; display: none;">
										<form method="post" class="handlingForm">
										<h2 style="margin: 0 0 20px 0; line-height: 1.6;"><?php echo esc_html_e('Bạn có chắc chắn đã thanh toán cho thành viên ') . $display_name; ?></h2>
										<input type="text" value="<?php echo $i; ?>" name="number_array" style="display: none;">  
										<input type="text" value="<?php echo $user_login; ?>" name="login_name" style="display: none;"> 
										<input type="number" value="<?php echo $item['number']; ?>" name="number_handling" style="display: none;"> 
										<div class="ph-button">
											<input type="submit" name="submit_handling" class="ph-sure button button-primary button-large" value="<?php echo esc_html_e('Chắc chắn'); ?>">
											<a href="#" class="ph-cancel" style="line-height: 30px; margin-left: 10px;"><?php echo esc_html_e('Đóng'); ?></a>
										</div>
										</form>
									</div>
								</td>
							</tr>
							<?php $i++; }; ?>
							<?php endif; ?>
						</table>
					</div><!-- .inner -->
			</div><!-- .wrap -->
		<?php
	}
}

if ( ! function_exists( 'threeus_point_payment_callback' ) ) {
	function threeus_point_payment_callback() {
		?>
			<div class="wrap">
				<h1><?php esc_html_e( 'Danh sách thành viên được nhận points', 'threeus' ); ?></h1>
					<div class="inner">
						<table class="wp-list-table widefat fixed striped">
							<thead>
								<tr>
									<th class="manage-column column-user"><?php esc_html_e( 'Thành viên', 'threeus' ); ?></th>
									<th class="manage-column column-point"><?php esc_html_e( 'Số point', 'threeus' ); ?></th>
									<th class="manage-column column-message"><?php esc_html_e( 'Bài viết', 'threeus' ); ?></th>
									<th class="manage-column column-date"><?php esc_html_e( 'Ngày giờ', 'threeus' ); ?></th>
								</tr>
							</thead>

							<?php 
								$points_option = get_option( 'points_option' );
								if( $points_option ) :
								foreach ($points_option as $key => $item) { 
									$user_info = get_userdata($item['author']);
									$display_name = $user_info->display_name;
									$user_login = $user_info->user_login;
							?>
							<tr class="even thread-even depth-1">
								<td><?php echo $display_name; ?></td>
								<td><?php echo '+' . number_format($item['point']); ?></td>
								<td><a target="_blank" href="<?php echo get_the_permalink( $item['post_id'] ); ?>"><?php echo get_the_title( $item['post_id'] ); ?></a></td>
								<td><?php echo $item['date']; ?></td>
							</tr>
							<?php } ?>
							<?php endif; ?>
						</table>
					</div><!-- .inner -->
			</div><!-- .wrap -->
		<?php
	}
}

function userUpdate() {
	$pu_name 		= isset( $_POST[ 'pun' ] ) ? $_POST[ 'pun' ] : '' ;
	$pu_birthday 	= isset( $_POST[ 'pub' ] ) ? $_POST[ 'pub' ] : '' ;
	$pu_address 	= isset( $_POST[ 'pua' ] ) ? $_POST[ 'pua' ] : '' ;
	$pu_phone 		= isset( $_POST[ 'pup' ] ) ? $_POST[ 'pup' ] : '' ;
	$pu_job 		= isset( $_POST[ 'puj' ] ) ? $_POST[ 'puj' ] : '' ;
	$pu_email 		= isset( $_POST[ 'pue' ] ) ? $_POST[ 'pue' ] : '' ;
	$pu_facebook 	= isset( $_POST[ 'puf' ] ) ? $_POST[ 'puf' ] : '' ;
	$pu_instagram 	= isset( $_POST[ 'pui' ] ) ? $_POST[ 'pui' ] : '' ;
	$pu_youtube 	= isset( $_POST[ 'puy' ] ) ? $_POST[ 'puy' ] : '' ;
	$pu_twitter 	= isset( $_POST[ 'put' ] ) ? $_POST[ 'put' ] : '' ;
	$pu_content 	= isset( $_POST[ 'puc' ] ) ? $_POST[ 'puc' ] : '' ;
	$pu_avatar 	= isset( $_POST[ 'puav' ] ) ? $_POST[ 'puav' ] : '' ;
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
	update_user_meta( $current_user->ID, 'first_name', $first_name );
	update_user_meta( $current_user->ID, 'last_name', $last_name );
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
	update_user_meta( $current_user->ID, 'wp_user_avatar', $pu_avatar );
	exit();
}
add_action('wp_ajax_nopriv_userUpdate', 'userUpdate');
add_action( 'wp_ajax_userUpdate', 'userUpdate' );

function insert_attachment($file_handler,$post_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $attach_id = media_handle_upload( $file_handler, $post_id );
  
    if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
}

function threeus_get_avatar( $user_id, $size, $img_id = false ) {
	$avatar_id = get_field( 'avatar', 'user_' . $user_id );
	if( $avatar_id ) {
		$avatar_url = get_BFI_thumbnail( $avatar_id, $size, $size, true );

	} else {
		$avatar_url = get_avatar_url(  $user_id, array('size' => $size) );
	}

	if( $img_id ) {
		return '<img id="' . $img_id . '" src="' . $avatar_url . '" alt="avatar" />';	
	} else {
		return '<img src="' . $avatar_url . '" alt="avatar" />';
	}	
}

// Add scripts to wp_head()
function child_theme_head_script() { 

	$current_user = wp_get_current_user();
	$role = $current_user->roles;
	if ( $role[0] == 'administrator' || $role[0] == 'editor' ) :

	else :
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$( '.member-menu li' ).each(function(index, el) {
				if( $( this ).hasClass('admin-show-menu') ) {
					$( this ).remove();
				}
			});
		});
	</script>
<?php 
	endif;
	if ( is_user_logged_in() ) {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$( '#comments .comment-popup' ).remove();
		});
	</script>
	<?php
	}
}
add_action( 'wp_head', 'child_theme_head_script' );

function uploadVideo() {
	$name 		= isset( $_POST[ 'n' ] ) ? $_POST[ 'n' ] : '' ;
	$tmp_name 		= isset( $_POST[ 'tn' ] ) ? $_POST[ 'tn' ] : '' ;
	global $current_user;
	$attachment_id = '';
    $post_content = '';
    $videoFilePath = '';
    $fileName = str_shuffle('nityanandamaity').'-'.basename($name);
    $targetDir = TEMPLATEPATH . '/video-upload/videos/';
    $targetUrl = get_template_directory_uri() . '/video-upload/videos/';
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($tmp_name, $targetFile);
    $videoFilePath = 'videos/' . $fileName;
	exit();
}
add_action('wp_ajax_nopriv_uploadVideo', 'uploadVideo');
add_action( 'wp_ajax_uploadVideo', 'uploadVideo' );

// Function to change email address
 
function wpb_sender_email( $original_email_address ) {
    return 'admin@mina24h.com';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
	$site_title = get_bloginfo( 'name' );
    return $site_title;
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

/**
 * Check if a contributor have the needed rights to upload images and add this capabilities if needed.
 */
			
add_action( 'pre_get_posts', 'users_own_attachments');
function users_own_attachments( $wp_query_obj )
    {
        global $current_user, $pagenow;

        if ( $pagenow == 'upload.php' || ( $pagenow == 'admin-ajax.php' && !empty( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'query-attachments' ) ) {
            $wp_query_obj->set( 'author', $current_user->ID );
        }
    }
?>