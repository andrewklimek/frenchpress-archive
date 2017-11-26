/**
 * Handles toggling for submenus
 */
( function() {
	
	var menu = document.getElementById( 'primary-menu' ),
	button = document.getElementById( 'menu-open' ),
	mask = document.getElementById( 'mask' ),
	x = 'aria-expanded',
	o = 'mnav-open';
	
	if ( ! ( menu && button && mask ) ) return;

	/*
	* Begin Submenu Stuff
	*/
	var i=0,
	links = menu.getElementsByTagName( 'a' ),
	parentLink = menu.querySelectorAll( '.menu-item-has-children > a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( ; i < links.length; ++i ) {
		links[i].addEventListener( 'focus', toggleFocus );
		links[i].addEventListener( 'blur', toggleFocus );
		// links[i].addEventListener( 'click', toggleClick, true );
	}
	
	// Sets or removes .focus class on an element
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( ! self.classList.contains( 'menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'LI' == self.tagName ) {
				self.classList.toggle( 'focus' );
			}
			self = self.parentElement;
		}
	}
	
	// This is all that’s needed for the mobile drawer nav
	for ( i=0; i < parentLink.length; ++i ) {
		var btn = document.createElement('span');
		btn.className = "menutog";
		btn.addEventListener('click', function(){this.parentElement.classList.toggle('focus');});
		parentLink[i].parentElement.insertBefore(btn, parentLink[i].nextSibling);
	}
	
	// block that handles submenu toggling on touch devices
	if ( 'ontouchstart' in window ) {
		
		// All this madness except the last function is only for tablets in landscape mode
		 var touchStartFn = function( e ) {
			// console.log('touchStartFn');
			
			var menuItem = this.parentNode;
			
			// remove focus when clicking anywhere not in the menu
			document.addEventListener('click', tapAway );
			
			if ( ! menuItem.classList.contains( 'focus' ) ) {
				e.preventDefault();
				for ( var i=0; i < menuItem.parentNode.children.length; ++i ) {
					if ( menuItem === menuItem.parentNode.children[i] ) {
						continue;
					}
					menuItem.parentNode.children[i].classList.remove( 'focus' );
				}
				menuItem.classList.add( 'focus' );
			} else {
				menuItem.classList.remove( 'focus' );
			}
		},
		tapAway = function(e){
			// console.log('tapaway ran');
			if ( ! e || ! menu.contains(e.target) ) {
				for ( var i=0; i < parentLink.length; ++i ) {
					parentLink[i].parentNode.classList.remove( 'focus' );
				}
				document.removeEventListener('click', tapAway );
			}
		},
		tabletSubmenus = function() {
			var i = 0;
			if ( document.body.classList.contains('dnav') ) {
				for ( ; i < parentLink.length; ++i ) {
					parentLink[i].addEventListener( 'touchstart', touchStartFn );
				}
			} else {
				for ( ; i < parentLink.length; ++i ) {
					parentLink[i].removeEventListener( 'touchstart', touchStartFn );
				}
			}
		};
		
		window.addEventListener( 'resize', tabletSubmenus );
		tabletSubmenus();
		
	}
	/*
	* End Submenu Stuff
	*/
	
	function closeMenu() {
 		// if ( document.body.classList.contains( 'mnav-open' ) ) {
		document.body.classList.remove( o );
		button.removeAttribute( x );
		menu.removeAttribute( x );
		document.removeEventListener('keyup', drawerEscKey );
		// } else {
	}
	function openMenu() {
		document.body.classList.add( o );
		button.setAttribute( x, 'true' );
		menu.setAttribute( x, 'true' );
		document.addEventListener('keyup', drawerEscKey );
	}
	
	button.onclick = openMenu;
	document.getElementById( 'menu-close' ).onclick = closeMenu;
	mask.onclick = closeMenu;
	
	function drawerEscKey(e){
		if( e.keyCode === 27 )
			closeMenu();
	}
	
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