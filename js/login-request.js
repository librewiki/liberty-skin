async function LoginManage() {
	// @todo FIXME: could probably simplify this code a bit by using
	// ( new mw.Api() ).postWithToken( 'edit', paramsGoHere ).done( ... );
	let logintoken, status, message;
	( { query: { tokens: { logintoken } } } = await $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		type: 'post',
		data: {
			action: 'query',
			meta: 'tokens',
			type: 'login',
			format: 'json'
		},
		dataType: 'json'
	} ) );

	( { clientlogin: { status, message } } = await $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		type: 'post',
		data: {
			action: 'clientlogin',
			loginreturnurl: location.href,
			username: $( '#wpName1' ).val(),
			password: $( '#wpPassword1' ).val(),
			rememberMe: $( '#lgremember' ).prop( 'checked' ) ? 1 : 0,
			logintoken,
			format: 'json'
		},
		dataType: 'json'
	} ) );

	if ( status !== 'PASS' ) {
		switch ( status ) {
			case 'FAIL':
			// @todo CHECKME: Isn't this rather English-specific?
				if ( message === 'The supplied credentials could not be authenticated.' ) {
					$( '#modal-login-alert' ).addClass( 'alert-warning' );
					$( '#modal-login-alert' ).fadeIn( 'slow' );
					$( '#modal-login-alert' ).html(
						'<strong>' + mw.msg( 'liberty-warning' ) +
						'</strong><br />' + mw.msg( 'liberty-warning-text' )
					);
				} else {
					$( '#modal-login-alert' ).addClass( 'alert-warning' );
					$( '#modal-login-alert' ).fadeIn( 'slow' );
					$( '#modal-login-alert' ).html( message );
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
	$( '#loginform-submit' ).click( LoginManage );
} );
