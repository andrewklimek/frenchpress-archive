(function($) {
   $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
         var target = $(this.hash);
         var compensations = 50;
         target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
         if (target.length) {
            $('html, body').animate({
               scrollTop: target.offset().top - compensations
            }, 700);
            
            // Hide mobile menu
            if ( document.body.classList.contains( 'mobile-nav-open' ) ) {
      			document.body.classList.remove( 'mobile-nav-open' );
      			document.getElementById( 'menu-toggle' ).setAttribute( 'aria-expanded', 'false' );
      			document.querySelector('#main-nav ul.menu').setAttribute( 'aria-expanded', 'false' );
         		document.getElementById('obfuscator').classList.remove('active');
            }
            return false;
         }
      }
   });
})(jQuery);