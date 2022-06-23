$( function () {
	'use strict';
	var width, rightAds;
	if ( $( '.mobile-ads' ) !== undefined ) {
		width = $( window ).width();
		if ( width < 1024 ) {
			rightAds = $( '.right-ads' ).html();
			$( '.mobile-ads' ).html( rightAds );
			$( '.right-ads' ).remove();
		}
	}
	$( '.adsbygoogle' ).each( function () {
		( window.adsbygoogle = window.adsbygoogle || [] ).push( {} );
	} );
} );
