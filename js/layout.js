$( function () {
	'use strict';

	/* Dropdown fade in */
	$( '.dropdown' ).on( 'show.bs.dropdown', function () {
		$( this ).find( '.dropdown-menu' ).first().stop( true, true ).fadeToggle( 200 );
	} );

	$( '.dropdown' ).on( 'hide.bs.dropdown', function () {
		$( this ).find( '.dropdown-menu' ).first().stop( true, true ).fadeToggle( 200 );
	} );

	$( '.btn-group' ).on( 'show.bs.dropdown', function () {
		$( this ).find( '.dropdown-menu' ).first().stop( true, true ).fadeToggle( 200 );
	} );

	$( '.btn-group' ).on( 'hide.bs.dropdown', function () {
		$( this ).find( '.dropdown-menu' ).first().stop( true, true ).fadeToggle( 200 );
	} );
	/* Dropdown fade in End */

	/* Modal Focus */
	$( '#login-modal' ).on( 'shown.bs.modal', function () {
		$( '#wpName1' ).focus();
	} );
	/* Modal Focus End */
} );

/* Sub menu */
$( function () {
	var display;

	$( '.dropdown-toggle-sub' ).on( 'click', function ( element ) {
		display = $( this ).next( 'div.dropdown-menu' );
		display.toggle();
		element.stopPropagation();
		element.preventDefault();
	} );

	$( 'html' ).on( 'click', function () {
		if ( display !== undefined ) {
			display.hide();
		}
	} );
} );
/* Sub menu end */
