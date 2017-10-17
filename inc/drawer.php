<?php
function frenchpress_set_main_menu( $args ) {
    
    // First check if the slug is specified like: add_filter( 'frenchpress_main_menu_slug', 'main-menu' );
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
    
    // So, if this is menu matches the slug specified as the main menu, add the markup for the drawer
    if ( $menu_slug === $args['menu']->slug ) {
    
        $args['container_class'] .= " main-nav";
        $args['menu_id'] = "primary-menu";
        $args['menu_class'] .= " " . apply_filters( 'frenchpress_class_menu_primary', 'fff fff-right fff-middle' );
        $args['item_spacing'] = "discard";
        
        // also add this filter to insert the button and mask
        add_filter( 'wp_nav_menu', 'frenchpress_add_button_to_main_menu', 10, 2 );
    }
    
    return $args;
}
add_filter( 'wp_nav_menu_args', 'frenchpress_set_main_menu' );


function frenchpress_add_button_to_main_menu( $nav_menu, $args ) {
    
    remove_filter( 'wp_nav_menu', 'frenchpress_add_button_to_main_menu', 10, 2 );
    
    return '
        <span id="menu-toggle" role="button" aria-controls="primary-menu" aria-expanded="false" class="fffi">
			<svg id="menu-toggle-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				<path id="menu-toggle-close" d="M13.4 12l9.3-9.3c0.4-0.4 0.4-1 0-1.4 -0.4-0.4-1-0.4-1.4 0L12 10.6 2.7 1.3c-0.4-0.4-1-0.4-1.4 0 -0.4 0.4-0.4 1 0 1.4L10.6 12l-9.3 9.3c-0.4 0.4-0.4 1 0 1.4 0.4 0.4 1 0.4 1.4 0L12 13.4l9.3 9.3c0.4 0.4 1 0.4 1.4 0 0.4-0.4 0.4-1 0-1.4L13.4 12z"/>
				<path id="menu-toggle-open"  d="M23 20H1c-0.6 0-1 0.4-1 1s0.4 1 1 1h22c0.6 0 1-0.4 1-1S23.6 20 23 20zM23 11H1c-0.6 0-1 0.4-1 1 0 0.6 0.4 1 1 1h22c0.6 0 1-0.4 1-1C24 11.4 23.6 11 23 11zM1 4h22c0.6 0 1-0.4 1-1 0-0.6-0.4-1-1-1H1C0.4 2 0 2.4 0 3 0 3.6 0.4 4 1 4z"/>
			</svg>
			<span id="menu-toggle-label">Menu</span>
		</span>
		' . $nav_menu . '
		<div id="obfuscator"></div>
		';
}