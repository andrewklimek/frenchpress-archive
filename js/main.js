// an idea for fixing sub-menus on the far right.
//if ( document.body.clientWidth - document.querySelector('#menu-item-142 ul').getBoundingClientRect().right <= 0 ) { document.querySelector('#menu-item-142 ul').style.right=0; }

( function() {
	var menu = document.getElementById( 'primary-menu' ),
	button = document.getElementById( 'menu-open' ),
	mask = document.getElementById( 'mask' ),
	x = 'aria-expanded',
	o = 'mnav-open';
	
	if ( ! ( menu && button && mask ) ) return;

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