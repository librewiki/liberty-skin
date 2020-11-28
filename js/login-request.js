// eslint-disable-next-line
function LoginManage() {
	'use strict';
	mw.loader.using( 'mediawiki.api' ).then(function() {
		try {
			// new mw.Api().postWithToken does not work with clientlogin
			var api = new mw.Api();
			api.post( {
				action: 'query',
				meta: 'tokens',
				type: 'login'
			} )
				.then( function ( result ) {
					var token = result.query.tokens.logintoken;
					return api.post( {
						action: 'clientlogin',
						loginreturnurl: location.href,
						username: $( '#wpName1' ).val(),
						password: $( '#wpPassword1' ).val(),
						rememberMe: $( '#lgremember' ).prop( 'checked' ) ? 1 : 0,
						logintoken: token
					} )
				} )
				.then( function ( result ) {
					if ( result.clientlogin.status !== 'PASS' ) {
						switch ( result.clientlogin.status ) {
							case 'FAIL':
								$( '#modal-login-alert' ).addClass( 'alert-warning' );
								$( '#modal-login-alert' ).fadeIn( 'slow' );
								$( '#modal-login-alert' ).text( result.clientlogin.message );
								break;
							default:

						}
					} else {
						if ( mw.config.get( 'wgNamespaceNumber' ) === -1 ) {
							$( location ).attr( 'href', mw.config.get( 'wgArticlePath' ).replace( '$1', '' ) );
						} else {
							window.location.reload();
						}
					}
				} )
				.catch( function () {} );
			return false;
		} catch ( e ) {
			return false;
		}
	});
}

$( function () {
	$( '#modal-loginform' ).on( {
		keypress: function ( e ) {
			if ( e.which === 13 /* Enter was pressed */ ) {
				e.preventDefault();
				return LoginManage();
			}
		},
		submit: function ( e ) {
			e.preventDefault();
			return LoginManage();
		}
	} );
} );
