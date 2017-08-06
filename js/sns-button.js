$( '.social-buttons>div' ).click( function () {
	'use strict';
	var selectedMedia, host, url, text;
	selectedMedia = $( this ).attr( 'class' );
	host = mw.config.get( 'wgServer' );
	if ( host.startsWith( '//' ) ) {
		host = location.protocol + host;
	}
	url = encodeURIComponent(
		host + mw.config.get( 'wgScriptPath' ) + '/index.php?curid=' + mw.config.get( 'wgArticleId' )
	);
	text = $( this ).attr( 'data-text' );
	switch ( selectedMedia ) {
		case 'facebook':
			window.open( 'https://www.facebook.com/sharer/sharer.php?u=' + url, 'facebook', 'width=800, height=400' );
			break;
		case 'twitter':
			window.open( 'https://twitter.com/intent/tweet?text=' + mw.config.get( 'wgSiteName' ) + ' [[' + text + ']]&url=' + url + '&hashtags=' + mw.config.get( 'wgSiteName' ).replace( / /g, '_' ), 'twitter', 'width=800, height=350' );
			break;
		default:
			break;
	}
} );
