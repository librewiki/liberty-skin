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
