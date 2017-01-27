<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FrenchPress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
wp_head();
?>
</head>
<body <?php body_class('fff fff-column fff-none mobile'); ?>>
<?php do_action( 'frenchpress_body_after_begin' ); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'frenchpress' ); ?></a>
<header id="header" class="site-header fffi">
	<?php
	if ( is_active_sidebar( 'top' ) ) : ?>
		<div id="top-widget" class="widget-area" role="complementary">
			<div class="tray">
				<?php dynamic_sidebar( 'top' ); ?>
			</div>
		</div>
	<?php
	endif;
	if ( is_active_sidebar( 'header-1' ) ) : ?>
		<div id="header-1" class="widget-area" role="complementary">
			<div class="tray">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
	<?php
	endif;
	if ( is_active_sidebar( 'header-2' ) ) : ?>
		<div id="header-2" class="widget-area" role="complementary">
			<div class="tray">
				<?php dynamic_sidebar( 'header-2' ); ?>
			</div>
		</div>
	<?php
	else : ?>
<div id="site-header-main">
	<div class="<?php echo apply_filters( 'frenchpress_class_header_main', "tray fff fff-middle fff-nowrap" ); ?>">
		<div class="site-branding fffi fffi-none">
		<?php
		/**
		* Filter to insert whatever (SVG logos) and optionally skip the rest of this PHP block
		* e.g.:
		*	add_filter( 'frenchpress_site_branding', function( $skip_the_rest ) {
		*		print "<a href=". esc_url( home_url( '/' ) ) ." rel='home'>" . file_get_contents( __DIR__ .'/logo.svg' ) . "</a>";
		*		return true;// skips the rest of the site branging section
		*	} );
		*/
		$skip_the_rest = apply_filters( 'frenchpress_site_branding', false );
		
		if ( ! $skip_the_rest ) :
		
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			}
			if ( get_header_image() ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
				</a>
				<?php
			endif;
			
			// check if the site header & description were hidden in the customizer, add screen-reader-text class for CSS hiding
			$hide = display_header_text() ? '' : ' screen-reader-text';
			
			if ( is_front_page() || is_home() ) : ?>
				<h1 class="site-title<?php echo $hide; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<span class="site-title<?php echo $hide; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			<?php
			endif;
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description<?php echo $hide; ?>"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif;// End header image check.
		endif; // $skip_the_rest
		?>
		</div>
		<?php
		/**
		* Filter 'pre_wp_nav_menu' can be used to conditionally hide menu.
		*
		* e.g. hide if not logged in:
		* add_filter( 'pre_wp_nav_menu', function(){ if( !is_user_logged_in() ) return false; } );
		*
		* e.g. hide specific menu if not logged in:
		* function hide_specific_menu_location_if_logged_out( $output, $args ){
		* 	if ( !is_user_logged_in() && $args->theme_location === 'primary' )
		* 	return false;
		* }
		* add_filter( 'pre_wp_nav_menu', 'hide_specific_menu_location_if_logged_out', 10, 2 );
		**/
		if ( false !== ( $menu = wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu fff fff-right fff-middle', 'menu_id' => 'primary-menu', 'fallback_cb' => false, 'echo' => false ) ) ) ) :
		?>
		<nav id="main-nav" class="main-nav fffi">
			<button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<svg id="menu-toggle-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
					<path id="menu-toggle-close" d="M13.4 12l9.3-9.3c0.4-0.4 0.4-1 0-1.4 -0.4-0.4-1-0.4-1.4 0L12 10.6 2.7 1.3c-0.4-0.4-1-0.4-1.4 0 -0.4 0.4-0.4 1 0 1.4L10.6 12l-9.3 9.3c-0.4 0.4-0.4 1 0 1.4 0.4 0.4 1 0.4 1.4 0L12 13.4l9.3 9.3c0.4 0.4 1 0.4 1.4 0 0.4-0.4 0.4-1 0-1.4L13.4 12z"/>
					<path id="menu-toggle-open"  d="M23 20H1c-0.6 0-1 0.4-1 1s0.4 1 1 1h22c0.6 0 1-0.4 1-1S23.6 20 23 20zM23 11H1c-0.6 0-1 0.4-1 1 0 0.6 0.4 1 1 1h22c0.6 0 1-0.4 1-1C24 11.4 23.6 11 23 11zM1 4h22c0.6 0 1-0.4 1-1 0-0.6-0.4-1-1-1H1C0.4 2 0 2.4 0 3 0 3.6 0.4 4 1 4z"/>
				</svg>
				<span id="menu-toggle-label">Menu</span>
			</button>
			<?php echo $menu; ?>
		</nav>
		<div id='obfuscator'></div>
		<?php endif; // End Nav check ?>
	</div><!-- .tray -->
</div><!-- .site-header-main -->
<?php
endif;//is_active_sidebar( 'header-2' )

if ( is_active_sidebar( 'header-3' ) ) : ?>
	<div id="header-3" class="widget-area" role="complementary">
		<div class="tray">
			<?php dynamic_sidebar( 'header-3' ); ?>
		</div>
	</div>
<?php
endif; ?>
</header>
<div id="content" class="<?php echo apply_filters( 'frenchpress_class_content', "site-content fffi fffi-noshrink" ); ?>">
	<div id="content-tray" class="<?php echo ( apply_filters( 'frenchpress_full_width', false ) ) ? "tray--full-width " : "tray "; echo apply_filters( 'frenchpress_class_content_tray', "fff fff-spacearound fff-magic" ); ?>">
