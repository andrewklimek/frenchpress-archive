<?php

// if I dont bother with the hnav/snav in the <html> class,
// and instead just insert specific css inline,
// this hook can be wp_head
// and frenchpress_switch_to_js_that_handles_submenus doesn't have to be a seperate function
add_action( 'wp', 'frenchpress_process_drawer' );

function frenchpress_process_drawer(){
	global $frenchpress_drawer;
	// poo(wp_get_sidebars_widgets());
	if ( is_active_sidebar( 'drawer' ) ) {

		add_filter( 'wp_nav_menu_args', 'frenchpress_set_main_menu_in_drawer', 1 );

		ob_start();
		dynamic_sidebar( 'drawer' );
		$frenchpress_drawer = ob_get_clean();

		// if ( false !== strpos( $frenchpress_drawer, 'widget_nav_menu' ) ) {
		// 	add_action( 'frenchpress_header_top', 'frenchpress_print_desk_drawer' );
		// }

		remove_filter( 'wp_nav_menu_args', 'frenchpress_set_main_menu_in_drawer', 1 );

	} else {
		$frenchpress_drawer = '';
	}
}

function frenchpress_print_desk_drawer(){
	global $frenchpress_drawer;
	echo '<div class="drawer desk-drawer">';
	echo $frenchpress_drawer;
    echo '<span id=menu-close role=button aria-controls=main-menu>×</span>';
	echo '</div>';

}

function frenchpress_mobile_test_desk_drawer() {
	$breakpoint = apply_filters( 'frenchpress_menu_breakpoint', 860 );
	if ( ! $breakpoint ) return;
	// If 'i' is undefined, this is the first ("initial") run, so set the drawer open on desktop sizes.
	// During resize, 'i' will have the event object and so it won't re-open the drawer if user had closed it.
	echo "<script>(function(){
    var c=document.documentElement.classList;
	function f(i){if(window.innerWidth>{$breakpoint}){c.remove('mnav');c.add('dnav');i||c.add('dopen')}else{c.remove('dnav');c.add('mnav')}}
	f();
	window.addEventListener('resize',f);
    })();</script>
";
}

function frenchpress_start_drawer_open() {
	$breakpoint = apply_filters( 'frenchpress_menu_breakpoint', 860 );
	if ( ! $breakpoint ) return;
	echo "<script>window.innerWidth>{$breakpoint}&&document.documentElement.classList.add('drar-open')</script>\n";
}

function frenchpress_set_main_menu( $args ) {

    /**
	* The preliminary object & empty checks are cause depending how the menu was called this data may not be present.
	* AFAIK it will be present for the menu widget, and that's what I plan to use, so it's ok for now.
	* For normal wp_nav_menu calls, $args['menu'] might == the slug, but it could be the ID or name too.
	* See https://developer.wordpress.org/reference/functions/wp_nav_menu/
	*/
	if ( ! is_object( $args['menu'] ) || empty( $args['menu']->slug ) ) return $args;


    // check if the slug is specified like: add_filter( 'frenchpress_main_menu_slug', 'main-menu' );
    $menu_slug = apply_filters( 'frenchpress_main_menu_slug', false );

    if ( ! $menu_slug ) {

        // check if the slug has been cached
        if ( false === ( $menu_slug = get_transient( 'frenchpress_main_menu_slug' ) ) ) {

            $menus = wp_get_nav_menus();

            // if there’s only 1 mune OR if there’s no menu slug with the word "main" in it, then just use the first menu
            if ( 1 === count( $menus ) || ! strpos( var_export( $menus, true ), "main" ) ) {

                $menu_slug = $menus[0]->slug;

            } else {

                // there are multiple menus and the word "main" is in there somewhere so find which menu it is
                foreach ( $menus as $menu ) {

                    if( false !== strpos( $menu->slug, "main" ) ) {// technically "main" could be in $menu->slug and not the slug...

                        $menu_slug = $menu->slug;

                        break;// found it, so quit this madness

                    }
                }
            }

            if ( ! $menu_slug ) {

                error_log("something’s wrong with finding the main menu slug");
                return $args;
            }
            // cache it for a day.
            set_transient( 'frenchpress_main_menu_slug', $menu_slug, DAY_IN_SECONDS );
        }
    }

    // So, if this menu matches the slug specified as the main menu, add the markup for the drawer.
    if ( $menu_slug === $args['menu']->slug ) {
        
        // add div class=drawer and close button around nav.  This is only for horizontal main nav in header.
        // Only real need for this wrapper div is so additional widgets can be added inside it too via the drawer widget area.
        // These would be widgets for the mobile drawer but hidden in desktop header mode.
        add_filter( 'wp_nav_menu', 'frenchpress_add_drawer_markup_to_main_menu', 10, 2 );

        $args = frenchpress_add_main_nav_args( $args );
    }

    return $args;
}
add_filter( 'wp_nav_menu_args', 'frenchpress_set_main_menu' );

function frenchpress_add_main_nav_args( $args ) {

    $args['container_class'] = trim( $args['container_class'] . ' main-nav' );
    $args['menu_id'] = 'main-menu';
    $args['menu_class'] .= ' fff fff-middle fff-' . apply_filters( 'frenchpress_main_menu_align', 'right' );// removed fff-pad for now
   // $args['items_wrap'] .= '<span id=menu-close role=button aria-controls=main-menu>×</span>';
    $args['item_spacing'] = 'discard';

    add_filter( "wp_nav_menu_{$args['menu']->slug}_items", "frenchpress_maybe_enqueue_submenu_js" );

	return $args;
}


function frenchpress_set_main_menu_in_drawer($args){

	// if this runs, it's the main menu so we can remove the normal main menu hook
	remove_filter( 'wp_nav_menu_args', 'frenchpress_set_main_menu' );
	remove_action( 'wp_print_scripts', 'frenchpress_mobile_test' );
	add_action( 'frenchpress_header_top', 'frenchpress_print_desk_drawer' );
	// add_filter( 'body_class', function( $classes ){ $classes[] = 'snav'; return $classes; } );
	// add_action( 'wp_print_scripts', 'frenchpress_start_drawer_open' );
	add_action( 'wp_print_scripts', 'frenchpress_mobile_test_desk_drawer' );
    add_filter( 'frenchpress_class_html', function(){ return "snav"; } );

	$args = frenchpress_add_main_nav_args( $args );

	return $args;
}


function frenchpress_maybe_enqueue_submenu_js( $items ) {

	if ( false !== strpos($items, "menu-item-has-children" ) ) {
        
        add_action( 'wp_footer', 'frenchpress_switch_to_js_that_handles_submenus', 1 );

	}

	return apply_filters( 'frenchpress_main_menu_items', $items );

}

function frenchpress_switch_to_js_that_handles_submenus() {
    
    wp_dequeue_script( 'frenchpress' );
	
	// sort of weird recycling the filter to check if snav layout is in use.
	if ( false === strpos( apply_filters( 'frenchpress_class_html', '' ), 'snav' ) )
	    wp_enqueue_script( 'frenchpress-submenu' );
	else
		wp_enqueue_script( 'frenchpress-subside' );

}


add_action('wp_before_admin_bar_render',function(){echo '<style>.mnav .drawer,.desk-drawer{padding-top:32px!important} @media(max-width:782px){.mnav .drawer{padding-top:46px!important}}</style>';});


function frenchpress_add_drawer_markup_to_main_menu( $nav_menu, $args ) {

    remove_filter( 'wp_nav_menu', 'frenchpress_add_drawer_markup_to_main_menu', 10, 2 );
    
    global $frenchpress_drawer;

    return "<div class=drawer>{$nav_menu}{$frenchpress_drawer}</div>";

    // below was for adding buttons, disabled for now... 
    // I think this should always be in the header branding section no matter hwere the actual menu is.

  /*   return '
        <div id=obfuscator></div>
        ' . $nav_menu . '
        <div id=menu-toggle role=button aria-controls=main-menu aria-expanded=false class=fffi>
            <div class=menu-tog></div><div class=menu-tog></div><div class=menu-tog></div>
			<span id=menu-toggle-label>Menu</span>
		</div>
		'; */
     
    /****
     *  old SVG buttons:
     * 
     * <svg id=menu-toggle-svg xmlns=http://www.w3.org/2000/svg width=24 height=24 viewBox="0 0 24 24">
	 *	 <path id=menu-toggle-close d="M13.4 12l9.3-9.3c0.4-0.4 0.4-1 0-1.4 -0.4-0.4-1-0.4-1.4 0L12 10.6 2.7 1.3c-0.4-0.4-1-0.4-1.4 0 -0.4 0.4-0.4 1 0 1.4L10.6 12l-9.3 9.3c-0.4 0.4-0.4 1 0 1.4 0.4 0.4 1 0.4 1.4 0L12 13.4l9.3 9.3c0.4 0.4 1 0.4 1.4 0 0.4-0.4 0.4-1 0-1.4L13.4 12z"/>
	 *	 <path id=menu-toggle-open  d="M23 20H1c-0.6 0-1 0.4-1 1s0.4 1 1 1h22c0.6 0 1-0.4 1-1S23.6 20 23 20zM23 11H1c-0.6 0-1 0.4-1 1 0 0.6 0.4 1 1 1h22c0.6 0 1-0.4 1-1C24 11.4 23.6 11 23 11zM1 4h22c0.6 0 1-0.4 1-1 0-0.6-0.4-1-1-1H1C0.4 2 0 2.4 0 3 0 3.6 0.4 4 1 4z"/>
	 * </svg>
	 ***/
}

function frenchpress_drawer_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Drawer', 'frenchpress' ),
		'id'            => 'drawer',
		'before_widget' => '<aside id="%1$s" class="widget drawer-widget %2$s">',
		'after_widget'  => "</aside>\n",
		'before_title'  => '<h3 class=widgettitle>',
		'after_title'   => "</h3>\n",
	) );
}
add_action( 'widgets_init', 'frenchpress_drawer_widgets_init' );
