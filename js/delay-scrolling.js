$( window ).load( function () {
	'use strict';
	var hash, navHeight, id;
	/* 주소에 앵커 있을 경우 처리 */
	hash = window.location.hash;
	navHeight = $( '.nav-wrapper' ).height();

	if ( hash.indexOf( '.' ) !== -1 ) {
		hash = String( hash );
		hash = document.getElementById( hash.replace( '#', '' ) );
	}

	if ( hash ) {
		$( 'html, body' ).animate( { scrollTop: $( hash ).offset().top - navHeight - 10 }, 350 );
	}
	/* 주소에 앵커 있을 경우 처리 End */

	/* 목차 클릭시 처리 */
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
	/* 목차 클릭시 처리 End */

	/* 타이틀 번호 클릭시 처리 */
	$( '.mw-headline-number' ).click( function () {
		$( 'html,body' ).animate( {
			scrollTop: ( $( '#toctitle' ).offset().top - navHeight - 10 )
		}, 350 );
		return false;
	} );
	/* 타이틀 번호 클릭시 처리 End */

	/* 주석 클릭시 처리 */
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
	/* 주석 클릭시 처리 End */

	/* 환경설정 탭 클릭시 처리 */
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
	/* 환경설정 탭 클릭시 처리 End */
} );
