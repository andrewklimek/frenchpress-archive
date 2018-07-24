/**
 * Handles toggling for submenus with a slide effect
 */
(function() {
	
	var menu = document.getElementById( 'main-menu' ),
	nav = menu.parentElement,
	// current = menu.querySelector('.current-menu-item'),// dunno if it's worth it to make a click on the current menu item simple close the drawer and not reload. see onload action below.
	button = document.getElementById( 'menu-open' ),
	mask = document.getElementById( 'mask' ),
	htmlClass = document.documentElement.classList,
	x = 'aria-expanded',
	o = 'dopen';
	
	if ( ! ( menu && button && mask ) ) return;

	/*
	* Begin Submenu Stuff
	*/
	var i=0,
	links = nav.getElementsByTagName( 'a' ),
	parents = nav.querySelectorAll( '.menu-item-has-children' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( ; i < links.length; ++i ) {
		links[i].addEventListener( 'focus', toggleFocus );
		links[i].addEventListener( 'blur', toggleFocus );
		// links[i].addEventListener( 'click', toggleClick, true );
	}
	
	// Sets or removes .focus class on an element
	function toggleFocus(e) {
		
		if ( htmlClass.contains('mnav') ) return;
		
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( ! self.classList.contains( 'menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'LI' == self.tagName ) {
				e.type == "blur" ? self.classList.remove( 'focus' ) : self.classList.add( 'focus' );
			}
			self = self.parentElement;
		}
	}
	
	// This is all that’s needed for the mobile drawer nav
	function slide(e){
		if ( htmlClass.contains('dnav') ) return;
		e.preventDefault();
		if ( ! nav.style.height ) nav.style.height = menu.offsetHeight+"px";
		this.parentElement.classList.toggle('focus');
		this.parentElement.parentElement.classList.toggle('focus');
		nav.style.height = Math.max( menu.offsetHeight, this.parentElement.lastChild.scrollHeight ) + "px";
	};
	for ( i=0; i < parents.length; ++i ) {
		var tog = document.createElement('span'),
		back = document.createElement('span');
		back.className = "menuback";
		back.textContent = "back";
		back.onclick = function(){
			var p=this.parentElement.parentElement;
			p.classList.toggle('focus');
			p=p.parentElement;
			p.classList.toggle('focus');
			nav.style.height = Math.max( menu.offsetHeight, p.offsetHeight ) + "px";
		};
		parents[i].lastChild.insertAdjacentElement('afterbegin',back);
		tog.className = "menutog";
		tog.onclick = slide;
		// parents[i].firstChild.insertAdjacentElement('afterend',tog);
		parents[i].insertBefore(tog, parents[i].lastChild);
		if ( parents[i].firstChild.getAttribute('href')=="#" ){
			parents[i].firstChild.onclick = slide;
		} else {
			parents[i].className += ' seperate-tog';
		}
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
			if ( ! e || ! nav.contains(e.target) ) {
				for ( var i=0; i < parents.length; ++i ) {
					parents[i].classList.remove( 'focus' );
				}
				document.removeEventListener('click', tapAway );
			}
		},
		tabletSubmenus = function() {
			var i = 0;
			if ( htmlClass.contains('dnav') ) {
				for ( ; i < parents.length; ++i ) {
					parents[i].addEventListener( 'touchstart', touchStartFn );
				}
			} else {
				for ( ; i < parents.length; ++i ) {
					parents[i].removeEventListener( 'touchstart', touchStartFn );
				}
			}
		};
		
		window.addEventListener( 'resize', tabletSubmenus );
		tabletSubmenus();
		
	}
	/*
	* End Submenu Stuff
	*/
	
	function toggleDrawer() {
 		if ( htmlClass.contains( o ) ) {
			htmlClass.remove( o );
			button.removeAttribute( x );
			nav.removeAttribute( x );
			document.removeEventListener('keyup', drawerEscKey );
		} else {
	// }
	// function openMenu() {
			htmlClass.add( o );
			button.setAttribute( x, 'true' );
			nav.setAttribute( x, 'true' );
			document.addEventListener('keyup', drawerEscKey );
		}
	}
	
	button.onclick = toggleDrawer;
	// document.getElementById( 'menu-close' ).onclick = toggleDrawer;
	mask.onclick = toggleDrawer;
	current.onclick = function(e){ htmlClass.contains('mnav') && e.preventDefault(), toggleDrawer(); };
	
	function drawerEscKey(e){
		if( e.keyCode == 27 )
			toggleDrawer();
	}
	
	/**
	 * finds all links on the page which start with # and sets up smooth scrolling for them
	 * use an href of just "#" for "sroll to top" functionality
	 *
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
	*/
})();

/**
* MNSCRL: Minimal ScrollTo animation with exponential ease out
* position: the target scrollY property of the window
* speed: time in pixels per second
*
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
*/