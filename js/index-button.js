/* Make button to make fixed toc */
$( function () {
	'use strict';
	var width, contentHeaderOffset, indexButton, navHeight, id;
	width = $( window ).width();
	if ( $( '#toc' ).html() && width > 1649 ) {
		contentHeaderOffset = $( '.liberty-content-header' ).offset();
		indexButton = document.createElement( 'button' );
		indexButton.id = 'fixed-toc-button';
		indexButton.type = 'button';
		indexButton.className = 'btn btn-primary';
		indexButton.innerHTML = '<span class="fa fa-list" aria-hidden="true"></span>';
		indexButton.style.position = 'fixed';
		indexButton.style.top = contentHeaderOffset.top + 'px';
		indexButton.style.left = ( contentHeaderOffset.left - 47 - 15 ) + 'px';
		window.damezuma = { doc: null };
		$( indexButton ).click( function () {
			$( indexButton ).fadeOut( 200 );
			if ( !window.damezuma.doc ) {
				window.damezuma.doc = $( '#toc' ).clone();
				$( document.body ).append( window.damezuma.doc );
				$( window.damezuma.doc ).css( {
					position: 'fixed',
					top: 44,
					left: 0,
					'background-color': '#f5f8fa',
					'border-right': '1px solid #e1e8ed',
					color: '#373a3c',
					padding: '16px',
					bottom: 0,
					'overflow-y': 'auto',
					display: 'none',
					'max-width': '200px',
					'z-index': 3000
				} );
				window.damezuma.doc[ 0 ].id = 'fixed-toc';
				window.damezuma.doc.fadeIn( 200 );
				$( '#fixed-toc #togglelink' ).click( function () {
					$( '#fixed-toc-button' ).fadeIn( 200 );
					$( window.damezuma.doc ).remove();
					window.damezuma.doc = null;
					return false;
				} );

				/* Left toc click process */
				navHeight = $( '.nav-wrapper' ).height();
				$( '#fixed-toc ul li > a' ).click( function () {
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
				/* Left toc click process End */
			}
		} );
		$( document.body ).append( indexButton );
	}
} );
