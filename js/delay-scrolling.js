$( window ).load( function () {
	'use strict';
	var hash, navHeight, id;
	/* Anchor Process */
	hash = window.location.hash;
	navHeight = $( '.nav-wrapper' ).height();

	if ( hash.indexOf( '.' ) !== -1 ) {
		hash = String( hash );
		hash = document.getElementById( hash.replace( '#', '' ) );
	}

	if ( hash ) {
		$( 'html, body' ).animate( { scrollTop: $( hash ).offset().top - navHeight - 10 }, 350 );
	}
	/* Anchor Process End */

	/* Toc click process */
	$( '.toc ul li > a' ).click( function () {
		if ( $( this ).attr( 'href' )[ 0 ] === '#' ) {
			id = String( $( this ).attr( 'href' ) );
			if ( id.indexOf( '.' ) !== -1 ) {
				id = document.getElementById( id.replace( '#', '' ) );
			}
			$( 'html,body' ).animate( {
				scrollTop: ( $( id ).offset().top - navHeight - 10 )
			}, 350 );
			return false;
		}
	} );
	/* Toc click process End */

	/* Title number click process */
	$( '.mw-headline-number' ).click( function () {
		$( 'html,body' ).animate( {
			scrollTop: ( $( '#toctitle' ).offset().top - navHeight - 10 )
		}, 350 );
		return false;
	} );
	/* Title number click process End */

	/* Toc Click Process */
	$( '.mw-cite-backlink > a' ).click( function () {
		if ( $( this ).attr( 'href' )[ 0 ] === '#' ) {
			id = String( $( this ).attr( 'href' ) );
			if ( id.indexOf( '.' ) !== -1 ) {
				id = document.getElementById( id.replace( '#', '' ) );
			}
			$( 'html,body' ).animate( {
				scrollTop: ( $( id ).offset().top - navHeight - 10 )
			}, 400 );
			return false;
		}
	} );

	$( '.mw-cite-backlink > * > a' ).click( function () {
		if ( $( this ).attr( 'href' )[ 0 ] === '#' ) {
			id = String( $( this ).attr( 'href' ) );
			if ( id.indexOf( '.' ) !== -1 ) {
				id = document.getElementById( id.replace( '#', '' ) );
			}
			$( 'html,body' ).animate( {
				scrollTop: ( $( id ).offset().top - navHeight - 10 )
			}, 400 );
			return false;
		}
	} );

	$( '.reference > a' ).click( function () {
		if ( $( this ).attr( 'href' )[ 0 ] === '#' ) {
			id = String( $( this ).attr( 'href' ) );
			if ( id.indexOf( '.' ) !== -1 ) {
				id = document.getElementById( id.replace( '#', '' ) );
			}
			$( 'html,body' ).animate( {
				scrollTop: ( $( id ).offset().top - navHeight - 10 )
			}, 400 );
			return false;
		}
	} );
	/* Toc Click Process End */

	/* Preference Tab Click Process */
	$( '#preftoc li > a' ).click( function () {
		if ( $( this ).attr( 'href' )[ 0 ] === '#' ) {
			id = String( $( this ).attr( 'href' ) );
			if ( id.indexOf( '.' ) !== -1 ) {
				id = document.getElementById( id.replace( '#', '' ) );
			}
			$( 'html,body' ).animate( {
				scrollTop: ( 0 )
			}, 350 );
		}
	} );
	/* Preference Tab Click Process End */
} );
