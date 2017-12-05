<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content-tray">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FrenchPress
 * 
 * If this is ever used for the general public or WPML, 
 * html lang= should use language_attributes() or bloginfo('language') and maybe meta charset= bloginfo('charset')
 */
 
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php
wp_head();
?>
</head>
<body <?php body_class( "fff fff-column fff-none" ); ?>>
<?php do_action( 'frenchpress_body_top' ); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'frenchpress' ); ?></a>
<header id="header" class="site-header fffi">
	<?php do_action( 'frenchpress_header_top' ); ?>
	<?php
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
	endif;
    ?>
<div id="site-header-main">
	<div class="<?php echo apply_filters( 'frenchpress_class_header_main', "tray fff fff-middle fff-spacebetween fff-nowrap fff-pad" ); ?>">
		<div class="site-branding fffi">
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
			
			if ( is_front_page() ) : ?>
				<h1 class="site-title<?php echo $hide; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<span class="site-title h2<?php echo $hide; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			<?php
			endif;
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description<?php echo $hide; ?>"><?php echo $description; ?></p>
				<?php
				endif;// End header image check.
		endif; // $skip_the_rest

		echo '</div>';//.site-branding
		
		if ( is_active_sidebar( 'header-3' ) ) : ?>
    		<div id="header-3" class="fffi">
    			<?php dynamic_sidebar( 'header-3' ); ?>
    		</div>
    	<?php
    	endif;//is_active_sidebar( 'header-3' )
		?>
		<div id="menu-open" role="button" aria-controls="primary-menu" aria-expanded="false" class="fffi">
            <div class="menu-tog"></div><div class="menu-tog"></div><div class="menu-tog"></div>
			<span id="menu-open-label" class="screen-reader-text">Menu</span>
		</div>
		<?php
	echo '</div>';//.tray
echo '</div>';//.site-header-main

// will I want to filter the tray classes same as frenchpress_class_header_main?
if ( is_active_sidebar( 'header-4' ) ) : ?>
	<div id="header-4" class="widget-area" role="complementary">
		<div class="tray fff fff-middle fff-spacebetween fff-pad">
			<?php dynamic_sidebar( 'header-4' ); ?>
		</div>
	</div>
<?php
endif;

/**
 * Structurally lame, but sometimes we need to print the <h1> in the header for stylistic reasons, 
 * to have a full-width background that also spans above the sidebar
 * use add_filter( 'frenchpress_title_in_header', '__return_true' ); to activate
 */
if ( !is_front_page() && apply_filters( 'frenchpress_title_in_header', false ) ) {
	
	// basically an optimized version of using trim(wp_title('', false))
	// $title = false;
	// if ( is_single() || is_home() || is_page() ) $title = single_post_title( '', false );// default
	if ( ! $title = single_post_title( '', false ) ) {// returns nothing if get_queried_object()->post_title is not set
		if ( is_search() ) $title = sprintf( __( 'Search Results for &#8220;%s&#8221;' ), get_search_query() );
		elseif ( is_archive() ) $title = get_the_archive_title();
		elseif ( is_404() ) $title = __( 'Page not found' );
	}
	if ( $title ) {
		echo '<div id="header-title"><div class="tray header-title-tray"><h1 class="title">' . $title . '</h1></div></div>';
	} else {
		add_filter( 'frenchpress_title_in_header', '__return_false', 99 );// weird, couldn't get the title.  Put it back to normal
	}
	
}

do_action( 'frenchpress_header_bottom' );

?>
</header>
<div id="content" class="<?php echo apply_filters( 'frenchpress_class_content', "site-content fffi fffi-noshrink" ); ?>">
	<div class="content-tray <?php echo ( apply_filters( 'frenchpress_full_width', false ) ) ? "tray--full-width " : "tray "; echo apply_filters( 'frenchpress_class_content_tray', "fff fff-spacearound fff-magic" ); ?>">
