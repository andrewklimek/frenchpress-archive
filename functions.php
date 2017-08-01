<?php
/**
 * FrenchPress functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FrenchPress
 */

define( 'TEMPLATE_DIR', get_template_directory() );
define( 'TEMPLATE_DIR_U', get_template_directory_uri() );

if(!function_exists('poo')){function poo($v,$l=''){if(true===WP_DEBUG_LOG){error_log("***$l***\n".var_export($v,true));}}}

/**
 * Enqueue scripts and styles.
 */
function frenchpress_scripts() {
	
	if ( SCRIPT_DEBUG ) {

		$suffix = "";

		wp_enqueue_style( 'frenchpress', TEMPLATE_DIR_U.'/style.css', null, filemtime( TEMPLATE_DIR . '/style.css' ) );

	} else {

		$suffix = ".min";

		wp_enqueue_style( 'frenchpress', TEMPLATE_DIR_U . '/style' . $suffix . '.css', null, null );

	}
	
	// wp_enqueue_style( 'frenchpress-print',  TEMPLATE_DIR_U.'/print.css', array(), null, 'print' );// put back in style.css for now

	wp_enqueue_script( 'frenchpress-nav', TEMPLATE_DIR_U.'/js/nav.min.js', array(), null, true );

	// wp_enqueue_script( 'frenchpress-skip-link-focus-fix', TEMPLATE_DIR_U . '/js/skip-link-focus-fix'.$suffix.'.js', array(), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'frenchpress_scripts' );

add_filter('script_loader_tag', function($tag, $handle) {
	return ( 0 !== strpos( $handle, 'frenchpress' ) ) ? $tag : str_replace( ' src', ' defer src', $tag );
}, 10, 2);


function frenchpress_full_width_template( $is_fullwidth ) {
	if ( is_page_template( 'page-templates/page_full-width.php' ) ) {
		$is_fullwidth = true;
	}
	return $is_fullwidth;
}
add_filter( 'frenchpress_full_width', 'frenchpress_full_width_template', 9 );



add_action( 'login_enqueue_scripts', function() {
	// wp_dequeue_style( 'buttons' );
	// wp_dequeue_style( 'open-sans' );
	// wp_dequeue_style( 'dashicons' );
	wp_dequeue_style( 'login' );
	
	if ( function_exists( 'frenchpress_child_enqueue_scripts' ) ) {
		frenchpress_child_enqueue_scripts();
	}
	wp_enqueue_style( 'theme', get_stylesheet_uri(), array(), null );
	wp_enqueue_style( 'frenchpress-login', TEMPLATE_DIR_U . '/login.css', array(), null );
} );



function frenchpress_mobile_test() {
	$breakpoint = apply_filters( 'frenchpress_menu_breakpoint', 860 );
	if ( ! $breakpoint ) return;
	print "
	<script>
	function checkForDesktop(){
		if ( window.innerWidth > {$breakpoint} ) {
			if ( document.body.classList.contains('mnav') ) {
				document.body.classList.remove('mnav');
				document.body.classList.remove('mnav-open');
				document.body.classList.add('dnav');
			}
		} else if ( document.body.classList.contains('dnav') ) {
				document.body.classList.remove('dnav');
				document.body.classList.add('mnav');
			}
	}
	checkForDesktop();
	window.addEventListener( 'resize', checkForDesktop );
	</script>
	";
}
// if ( ! apply_filters( 'frenchpress_disable_mobile', false ) ) {
add_action( 'frenchpress_body_top', 'frenchpress_mobile_test', 0 );
// }

if ( ! function_exists( 'frenchpress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function frenchpress_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on FrenchPress, use a find and replace
	 * to change 'frenchpress' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'frenchpress', TEMPLATE_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'frenchpress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'chat',
		'aside',
		'gallery',
		'image',
		'video',
		'audio',
		'quote',
		'link',
		'status'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'frenchpress_custom_background_args', array(
		'default-color' => 'FFFDF8',
		'default-image' => '',
	) ) );
	
	// Custom Logo
	add_theme_support( 'custom-logo', array(
		'height'		=> 90,
		'width'			=> 400,
		'flex-width'	=> true,
	) );
	
	/*
	 * Styles the visual editor
	 * See https://developer.wordpress.org/reference/functions/add_editor_style/
	 */
	add_editor_style();
}
endif;
add_action( 'after_setup_theme', 'frenchpress_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function frenchpress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'frenchpress_content_width', 640 );
}
add_action( 'after_setup_theme', 'frenchpress_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function frenchpress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar 1', 'frenchpress' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar 2', 'frenchpress' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Top', 'frenchpress' ),
		'id'            => 'top',
		'description'   => 'Best for secondary menus/nav bars',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header 1', 'frenchpress' ),
		'id'            => 'header-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header 2', 'frenchpress' ),
		'id'            => 'header-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header 3', 'frenchpress' ),
		'id'            => 'header-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'frenchpress' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'frenchpress' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'frenchpress' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'frenchpress' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Ending Credits', 'frenchpress' ),
		'id'            => 'ending-credits',
		'description'   => 'Full width, very bottom. Typcial place for copyright, theme info, etc.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => "</h3>\n",
	) );
}
add_action( 'widgets_init', 'frenchpress_widgets_init' );


/**
 * [frenchpress] builder-style shortcode
 */
require TEMPLATE_DIR . '/inc/shortcodes.php';

/**
 * Remove core bull
 */
if ( ! function_exists( 'remove_type_from_archive_title' ) ) {
	require TEMPLATE_DIR . '/inc/disembellish.php';
}

/**
 * Implement the Custom Header feature.
 */
require TEMPLATE_DIR . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require TEMPLATE_DIR . '/inc/template-tags.php';

/**
 * HTML% Cleanup and various other goodies
 */
require TEMPLATE_DIR . '/inc/extras.php';

/**
 * Customizer additions.
 */
require TEMPLATE_DIR . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require TEMPLATE_DIR . '/inc/jetpack.php';
}

/**
 * Custom walker with no <li>.
 */
// require TEMPLATE_DIR . '/inc/walker_no_list.php';


/**
 * WooCommerce Support
 */
if ( class_exists( 'WooCommerce' ) ) {
	require TEMPLATE_DIR . '/woocommerce/woocommerce.php';
}