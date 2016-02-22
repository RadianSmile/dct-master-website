/**
 * Functionality specific to Bushwick.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	var secondary = $( '#secondary' );

	$( '.widget-handle' ).on( 'click.bushwick', function( e ) {
		e.preventDefault();

		$( this ).toggleClass( 'open' );
		secondary.slideToggle( 300 ).find( '.widget-container' ).masonry( {
			itemSelector: '.widget',
			gutterWidth: 0,
			isRTL: $( 'body' ).is( '.rtl' )
		} );
	} );

	$( '#404-widgets' ).masonry( {
		itemSelector: '.widget',
		gutterWidth: 0,
		isRTL: $( 'body' ).is( '.rtl' )
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var container, button, menu;

		container = document.getElementById( 'site-navigation' );
		if ( ! container )
			return;

		button = container.getElementsByTagName( 'h1' )[0];
		if ( 'undefined' === typeof button )
			return;

		menu = container.getElementsByTagName( 'ul' )[0];

		// Hide menu toggle button if menu is empty and return early.
		if ( 'undefined' === typeof menu ) {
			button.style.display = 'none';
			return;
		}

		if ( -1 === menu.className.indexOf( 'nav-menu' ) )
			menu.className += ' nav-menu';

		button.onclick = function() {
			if ( -1 !== container.className.indexOf( 'toggled' ) )
				container.className = container.className.replace( ' toggled', '' );
			else
				container.className += ' toggled';
		};
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	$( window ).on( 'hashchange.bushwick', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
				element.tabIndex = -1;

			element.focus();
		}
	} );

	/**
	 * Adds a class .home-link class to the navigation list item containing the home link.
	 */
	$( '.navigation-main a[href="' + bushwick_functions_vars.home_url + '"]' ).closest( 'li').addClass( 'home-link' );

} )( jQuery );
