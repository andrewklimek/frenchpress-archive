/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */

// an idea for fixing sub-menus on the far right.
//if ( document.body.clientWidth - document.querySelector('#menu-item-142 ul').getBoundingClientRect().right <= 0 ) { document.querySelector('#menu-item-142 ul').style.right=0; }

( function() {
	var menu = document.getElementById( 'primary-menu' ),
	button = document.getElementById( 'menu-toggle' ),
	obfuscator = document.getElementById( 'obfuscator' ),
	links, subMenus, height;

	if ( ! ( menu && button && obfuscator ) ) return;

	function toggleMenu() {
		if ( document.body.classList.contains( 'mobile-nav-open' ) ) {
			document.body.classList.remove( 'mobile-nav-open' );
			button.removeAttribute( 'aria-expanded' );
			menu.removeAttribute( 'aria-expanded' );
			document.removeEventListener('keyup', drawerEscKey );
		} else {
			document.body.classList.add( 'mobile-nav-open' );
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
			document.addEventListener('keyup', drawerEscKey );
		}
	}
	
	button.onclick = toggleMenu;
	obfuscator.onclick = toggleMenu;
	
	function drawerEscKey(e){
		if( e.keyCode === 27 )
			toggleMenu();
	}

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0; i < subMenus.length; ++i ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( var i = 0; i < links.length; ++i ) {
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
			if ( 'LI' == self.tagName ) {
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
	
	/**
	 * finds all links on the page which start with # and sets up smooth scrolling for them
	 * use an href of just "#" for "sroll to top" functionality
	 */
    function onPageLinkScroll(e){
    	var target = 0;
    	if ( this.hash ) {// href="#" has empty hash so target stays 0 (top of page)
    		target = document.querySelector(this.hash).offsetTop;
    	}
    	mnscrl(target);
    	e.preventDefault();
    }
    for ( var a = document.querySelectorAll('a[href^="#"]'), i=0; i<a.length; ++i ) {
    	a[i].addEventListener('click', onPageLinkScroll );
    }
})();

/**
* MNSCRL: Minimal ScrollTo animation with exponential ease out
* position: the target scrollY property of the window
* speed: time in pixels per second
*/
function mnscrl(position, speed) {

	var scrollY = window.scrollY || document.documentElement.scrollTop,// documentElement.scrollTop is for IE
	speed = speed || 1500,// 1500 pps default
	currentTime = 0,
	p,
	time = Math.max(.1, Math.min(Math.abs(scrollY - position) / speed, .8));// min time .1, max time .8 seconds

	function frame() {
		currentTime += 1 / 60;		

		p = currentTime / time;
		
		if (p < 1) {
			window.requestAnimationFrame(frame);// || window.setTimeout(frame, 100/6);// if you need IE9
			var t = -Math.pow(2, -10 * p) + 1;// easeOutExpo from https://github.com/danro/easing-js
			window.scrollTo(0, scrollY + ((position - scrollY) * t));
		} else {
			// console.log('scroll done');
			window.scrollTo(0, position);
		}
	}

	frame();// call it once to get started
}