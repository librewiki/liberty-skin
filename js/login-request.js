// eslint-disable-next-line
function LoginManage() {
	'use strict';
	try {
		// @todo FIXME: could probably simplify this code a bit by using
		// ( new mw.Api() ).postWithToken( 'edit', paramsGoHere ).done( ... );
		$.ajax( {
			url: mw.util.wikiScript( 'api' ),
			type: 'post',
			data: {
				action: 'query',
				meta: 'tokens',
				type: 'login',
				format: 'json'
			},
			dataType: 'json'
		} )
			.done( function ( result ) {
				var token = result.query.tokens.logintoken;
				$.ajax( {
					url: mw.util.wikiScript( 'api' ),
					type: 'post',
					data: {
						action: 'clientlogin',
						loginreturnurl: location.href,
						username: $( '#wpName1' ).val(),
						password: $( '#wpPassword1' ).val(),
						rememberMe: $( '#lgremember' ).prop( 'checked' ) ? 1 : 0,
						logintoken: token,
						format: 'json'
					},
					dataType: 'json'
				} )
					.done( function ( result ) {
						if ( result.clientlogin.status !== 'PASS' ) {
							switch ( result.clientlogin.status ) {
								case 'FAIL':
									// @todo CHECKME: Isn't this rather English-specific?
									if ( result.clientlogin.message === 'The supplied credentials could not be authenticated.' ) {
										$( '#modal-login-alert' ).addClass( 'alert-warning' );
										$( '#modal-login-alert' ).fadeIn( 'slow' );
										$( '#modal-login-alert' ).html(
											'<strong>' + mw.msg( 'liberty-warning' ) +
											'</strong><br />' + mw.msg( 'liberty-warning-text' )
										);
									} else {
										$( '#modal-login-alert' ).addClass( 'alert-warning' );
										$( '#modal-login-alert' ).fadeIn( 'slow' );
										$( '#modal-login-alert' ).html( result.clientlogin.message );
									}
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
					} );
			} );
		return false;
	} catch ( e ) {
		return false;
	}
}

$( function () {
	$( '#modal-loginform' ).on( {
		keypress: function ( e ) {
			if ( e.which === 13 /* Enter was pressed */ ) {
				return LoginManage();
			}
		},
		submit: function () {
			return LoginManage();
		}
	} );
} );
