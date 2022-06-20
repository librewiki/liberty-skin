$( '.tools-share' ).click( function () {
	'use strict';
	var ns, title, url, host;
	host = mw.config.get( 'wgServer' );
	if ( host.startsWith( '//' ) ) {
		host = location.protocol + host;
	}
	ns = mw.config.get( 'wgNamespaceNumber' );
	title = mw.config.get( 'wgTitle' );
	if ( ns ) {
		title = mw.config.get( 'wgFormattedNamespaces' )[ ns ] + ':' + title;
	}
	url = host + mw.config.get( 'wgScriptPath' ) + '/index.php?curid=' + mw.config.get( 'wgArticleId' );
	navigator.share( {
		title: title,
		text: title + ' - ' + mw.config.get( 'wgSiteName' ),
		url: url,
		hashtags: [ mw.config.get( 'wgSiteName' ).replace( / /g, '_' ) ]
	} )
	.catch( function ( error ) {
		console.error( 'Share API error: ', error );
	} );
} );
