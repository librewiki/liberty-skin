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
	/* Model Focus End */

} );

/* Load Ads */
$( function () {
	'use strict';
	var width, rightAds;
	width = $( window ).width();
	if ( width < 1024 ) {
		rightAds = $( '.right-ads' ).html();
		$( '.bottom-ads' ).html( rightAds );
		$( '.right-ads' ).remove();
		$( '.adsbygoogle' ).each( function () {
			( window.adsbygoogle = window.adsbygoogle || [] ).push( {} );
		} );
	} else {
		$( '.adsbygoogle' ).each( function () {
			( window.adsbygoogle = window.adsbygoogle || [] ).push( {} );
		} );
	}
} );
/* Load Ads End */
