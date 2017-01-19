/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */

// an idea for fixing sub-menus on the far right.
//if ( document.body.clientWidth - document.querySelector('#menu-item-142 ul').getBoundingClientRect().right <= 0 ) { document.querySelector('#menu-item-142 ul').style.right=0; }

( function() {
	var container, button, menu, links, subMenus, height, obfuscator;

	container = document.getElementById( 'main-nav' );
	if ( ! container ) {
		return;
	}

	button = document.getElementById( 'menu-toggle' );
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];
	obfuscator = document.getElementById('obfuscator');

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	menu.classList.add( 'nav-menu' );
	
	function toggleMenu() {
		if ( document.body.classList.contains( 'mobile-nav-open' ) ) {
			document.body.classList.remove( 'mobile-nav-open' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			document.body.classList.add( 'mobile-nav-open' );
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
			document.addEventListener('keyup', drawerEscKey );
		}
		obfuscator.classList.toggle('active');
	}
	
	button.onclick = toggleMenu;
	obfuscator.onclick = toggleMenu;
	
	function drawerEscKey(e){
		if( e.keyCode === 27 ) {
			document.removeEventListener('keyup', drawerEscKey );
			toggleMenu();
		}
	}

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
		// links[i].addEventListener( 'click', toggleClick, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( ! self.classList.contains( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				self.classList.toggle( 'focus' );
			}
			self = self.parentElement;
		}
	}

	/**
	 * Sets or removes .clicked class on an element.
	 */
	// function toggleClick() {
	// 	this.parentElement.classList.toggle( 'clicked' );
	// }
})();
