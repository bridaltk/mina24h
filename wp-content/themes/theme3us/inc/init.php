<?php

if ( ! function_exists( 'threeus_theme_setup' ) ) :
	function threeus_theme_setup() {
		/**
		 * Support woocommerce plugin for theme
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );


		/**
		 * This theme uses wp_nav_menu() in one location.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'main_menu'  => __( 'Main Menu', 'threeus' ),
			'mobile_menu'  => __( 'Mobile Menu', 'threeus' ),
			'menu_mob_top'  => __( 'Menu Mobile Top', 'threeus' ),
			'menu_mob_bottom'  => __( 'Menu Mobile Bottom', 'threeus' ),
			'account_menu'  => __( 'Account Menu', 'threeus' ),
			'top_menu'  => __( 'Top Menu', 'threeus' ),
			'footer_menu'  => __( 'Footer Menu', 'threeus' ),
		) );

	}

	add_action( 'after_setup_theme', 'threeus_theme_setup' );

endif;

/**
 * Enqueue scripts and styles for the front end.
 * 
 */
function threeus_enqueue_scripts() {
	//Load our main stylesheet.
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/style.css', array( 'dashicons' ) );

	// Load responsive stylesheet.
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '', 'screen' );

    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/libs/jquery-1.12.4.min.js', array(), '', true );

    wp_enqueue_script( 'tether', get_template_directory_uri() . '/libs/tether.min.js', array(), '', true );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/libs/bootstrap/js/bootstrap.min.js', array(), '', true );
	wp_enqueue_script( 'owl-carousel-script', get_template_directory_uri() . '/libs/owl-carousel/owl.carousel.min.js', array(), '', true );
	wp_enqueue_script( 'venobox-script', get_template_directory_uri() . '/libs/venobox/venobox.min.js', array(), '', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/libs/isotope.pkgd.min.js', array(), '', true );
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/libs/popper.js', array(), '', true );
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/main.js', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'threeus_enqueue_scripts', 10000 );

function add_stylesheet_to_admin() {

    // Load FontAwesome stylesheet.
	wp_enqueue_style( 'FontAwesome', get_template_directory_uri() . '/libs/font-awesome/css/font-awesome.css' );
	wp_enqueue_script('custom_admin_script', get_bloginfo('template_url').'/js/admin_script.js', array('jquery'));
}
add_action( 'admin_enqueue_scripts', 'add_stylesheet_to_admin' );
add_action( 'login_enqueue_scripts', 'add_stylesheet_to_admin', 1 );

/**
 * Load TGM Plugin Activation library
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * The required plugins installed in theme
 */
require get_template_directory() . '/inc/installed-plugins.php';

/**
 * Additions field for advanced custom fields.
 */
if( class_exists('acf') ) {
	require(get_template_directory() . '/inc/acf.php');
	// require(get_template_directory() . '/inc/colors.php');
	require(get_template_directory() . '/inc/layouts.php');
}

/**
 * Add Plugin PHP resize images
 */
require get_template_directory() . '/inc/aq_resizer.php';

/**
 * Additions custom widgets wordpress
 */
require get_template_directory() . '/inc/widgets/blog.php';
require get_template_directory() . '/inc/widgets/top-footer.php';
require get_template_directory() . '/inc/widgets/blogs-featured.php';
require get_template_directory() . '/inc/widgets/recent-blog.php';
require get_template_directory() . '/inc/widgets/socials.php';

/**
 * Additions custom post type wordpress
 */
// require get_template_directory() . '/inc/post-types/question.php';

/**
 * Additions function for visual composer.
 */
if( class_exists( 'KingComposer' ) ) :
	require get_template_directory() . '/inc/kc.php';
endif;

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

require get_template_directory() . '/inc/add-metabox.php';

/**
 * Additions css for admin.
 */
add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css' );
}
?>