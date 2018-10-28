<?php 
function layout_output() {
	$container_width = get_field( 'acf_container_width', 'option' );
	$site_layout = get_field( 'acf_site_layout', 'option' );
	?>

	<style type="text/css">

	<?php if( $container_width ) { ?>
		@media (min-width: 1200px) {
			.container {
			    width: <?php echo $container_width; ?>;
			}
		}
	<?php } ?>

	<?php if( $site_layout == 'boxed' && $container_width ) { ?>
		#wrapper {
			max-width: <?php echo $container_width; ?>;
		}
	<?php } elseif( $site_layout == 'boxed' ) { ?>
		#wrapper {
			max-width: 1170px;
		}
	<?php } ?>
	</style>

	<?php
}

add_action( 'wp_head', 'layout_output', 100000 );


/**
 * Adds page layout classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function page_layout_body_classes( $classes ) {

	$page_layout = get_field( 'acf_page_layout', 'option' );

	switch ( $page_layout ) {
		case 'main':
			$classes[] = 'full-width';
			break;

		case 'left-main':
			$classes[] = 'left-content';
			break;

		case 'main-right':
			$classes[] = 'content-right';
			break;

		case 'left-main-right':
			$classes[] = 'left-content-right';
			break;

		default:
			$classes[] = 'content-right';
			break;
	}

	return $classes;
}
add_filter( 'body_class', 'page_layout_body_classes' );


/**
 * Adds blog layout classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blog_layout_body_classes( $classes ) {

	$blog_layout = get_field( 'acf_blog_layout', 'option' );

	switch ( $blog_layout ) {
		case 'thumb-fullwidth':
			$classes[] = 'post-fullwidth';
			break;

		case 'thumb-left':
			$classes[] = 'post-fullwidth left-thumb';
			break;

		case 'boxed':
			$classes[] = 'post-boxed';
			break;

		default:
			$classes[] = 'post-fullwidth left-thumb';
			break;
	}

	return $classes;
}
add_filter( 'body_class', 'blog_layout_body_classes' );


/**
 * Output the primary sidebar if layout allows for it.
 *
 * @since 1.0
 */
function get_sidebar_primary() {
	$sidebar_width = get_field( 'acf_sidebar_width', 'option' );
	if( !$sidebar_width ) {
		$sidebar_width = 4;
	}
	$sidebar_width = 'col-md-' . $sidebar_width;
	?>
	<div id="primary-sidebar" class="primary-sidebar sidebar <?php echo $sidebar_width; ?>" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<?php
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
				dynamic_sidebar( 'primary-sidebar' );
			} else {
			?>
				<aside class="widget widget_text">
					<h3 class="widget-title"><?php _e( 'Primary Sidebar', 'threeus' ); ?></h3>
					<div class="textwidget">
						<?php
							printf(
								__( 'This is the Right Sidebar Area. You can add content to this area by visiting your %1$s and adding new widgets to this area.', 'threeus' ),
								'<a href="' . esc_url( admin_url( 'widgets.php', 'http' ) ) . '"><b>' . __( 'Widgets Panel', 'threeus' ) . '</b></a>'
							);
						?>
					</div>
				</aside>
			<?php } ?>
		</div>
	</div>
<?php
}

/**
 * Output the secondary sidebar if layout allows for it.
 *
 * @since 1.0
 */
function get_sidebar_secondary() {
	$sidebar_width = get_field( 'acf_sidebar_width', 'option' );
	if( !$sidebar_width ) {
		$sidebar_width = 4;
	}
	$sidebar_width = 'col-md-' . $sidebar_width;
	?>
	<div id="secondary-sidebar" class="secondary-sidebar" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
		<div class="row">
			<?php
			if ( is_active_sidebar( 'secondary-sidebar' ) ) {
				dynamic_sidebar( 'secondary-sidebar' );
			} else {
			?>
				<aside class="widget widget_text">
					<h3 class="widget-title"><?php _e( 'Secondary Sidebar', 'threeus' ); ?></h3>
					<div class="textwidget">
						<?php
							printf(
								__( 'This is the Left Sidebar Area. You can add content to this area by visiting your %1$s and adding new widgets to this area.', 'threeus' ),
								'<a href="' . esc_url( admin_url( 'widgets.php', 'http' ) ) . '"><b>' . __( 'Widgets Panel', 'threeus' ) . '</b></a>'
							);
						?>
					</div>
				</aside>
			<?php } ?>
		</div>
	</div>
<?php
}
?>