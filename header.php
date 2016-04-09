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

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'frenchpress' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="content-width">
		
			<?php if ( is_active_sidebar( 'top' ) ) : ?>
				<div id="top-widget" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'top' ); ?>
				</div><!-- #top-widget -->
			<?php endif;
		
			if ( is_active_sidebar( 'header-1' ) ) : ?>
				<div id="header-1" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'header-1' ); ?>
				</div><!-- #header-1 -->
			<?php endif;
		
			if ( is_active_sidebar( 'header-2' ) ) : ?>
				<div id="header-2" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'header-2' ); ?>
				</div><!-- #header-2 -->
			<?php else : ?>
		
			<div class="site-branding">
				<?php if ( get_header_image() ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
				</a>
				<?php else:
			
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif;
		
			endif; // End header image check. ?>
			</div><!-- .site-branding -->
		
			<?php endif;//is_active_sidebar( 'header-2' )
		
			if ( is_active_sidebar( 'header-3' ) ) : ?>
				<div id="header-3" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'header-3' ); ?>
				</div><!-- #header-3 -->
			<?php endif; ?>

			<?php $menu = wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'fallback_cb' => false, 'echo' => false ) );
			if ( $menu ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<span class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 1 24 24" xml:space="preserve">
						<path id="menu-toggle-open" d="M23,21H1c-0.553,0-1,0.447-1,1s0.447,1,1,1h22c0.552,0,1-0.447,1-1S23.552,21,23,21z M23,12H1c-0.553,0-1,0.448-1,1c0,0.553,0.447,1,1,1h22c0.552,0,1-0.447,1-1C24,12.448,23.552,12,23,12z M1,5h22c0.552,0,1-0.447,1-1c0-0.552-0.448-1-1-1H1C0.447,3,0,3.448,0,4C0,4.553,0.447,5,1,5z"/>
						<path id="menu-toggle-close" d="M13.414,13l9.191-9.191c0.392-0.392,0.392-1.023,0-1.414c-0.394-0.392-1.022-0.392-1.414,0L12,11.586L2.808,2.395c-0.391-0.392-1.024-0.392-1.414,0c-0.391,0.39-0.391,1.022,0,1.414L10.586,13l-9.192,9.191c-0.391,0.392-0.391,1.021,0,1.414c0.391,0.392,1.023,0.392,1.414,0L12,14.414l9.191,9.191c0.392,0.392,1.021,0.392,1.414,0c0.392-0.394,0.392-1.022,0-1.414L13.414,13z"/>
					</svg>
				</span>
				<?php echo $menu; ?>
			</nav><!-- #site-navigation -->
			<?php endif; // End Nav check ?>
		</div><!-- .content-width -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="content-width">
