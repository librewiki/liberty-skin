$( function () {
	'use strict';
	var articleNamespaces, talkNamespaces, isArticleTab, limit;

	articleNamespaces = $( '.live-recent' ).attr( 'data-article-ns' );
	talkNamespaces = $( '.live-recent' ).attr( 'data-talk-ns' );
	isArticleTab = true;
	limit = $( '#live-recent-list' )[ 0 ].childElementCount;

	function timeFormat( time ) {
		var aDayAgo, hour, minute, second;
		aDayAgo = new Date();
		aDayAgo.setDate( aDayAgo.getDate() - 1 );
		if ( time < aDayAgo ) {
			return ( time.getFullYear() ) + '/' + ( time.getMonth() + 1 ) + '/' + time.getDate();
		}
		hour = time.getHours();
		minute = time.getMinutes();
		second = time.getSeconds();
		if ( hour < 10 ) {
			hour = '0' + hour;
		}
		if ( minute < 10 ) {
			minute = '0' + minute;
		}
		if ( second < 10 ) {
			second = '0' + second;
		}
		return hour + ':' + minute + ':' + second;
	}

	function refreshLiveRecent() {
		var getParameter;

		if ( !$( '#live-recent-list' ).length || $( '#live-recent-list' ).is( ':hidden' ) ) {
			return;
		}

		getParameter = {
			action: 'query',
			list: 'recentchanges',
			rcprop: 'title|timestamp',
			rcshow: '!bot|!redirect',
			rctype: 'edit|new',
			rclimit: limit,
			format: 'json',
			rcnamespace: isArticleTab ? articleNamespaces : talkNamespaces,
			rctoponly: true
		};

		mw.loader.using( 'mediawiki.api' ).then( function () {
			var api = new mw.Api();
			api.get( getParameter ).then( function ( data ) {
				var recentChanges, html, time, line, text;
				recentChanges = data.query.recentchanges;
				html = recentChanges.map( function ( item ) {
					time = new Date( item.timestamp );
					line = '<li><a class="recent-item" href="' + mw.util.getUrl( item.title ) + '" title="' + item.title + '">[' + timeFormat( time ) + '] ';
					text = '';
					if ( item.type === 'new' ) {
						text += '[New]';
					}
					text += item.title;
					if ( text.length > 13 ) {
						text = text.substr( 0, 13 );
						text += '...';
					}
					text = text.replace( '[New]', '<span class="new">' + mw.msg( 'liberty-feed-new' ) + ' </span>' );
					line += text;
					line += '</a></li>';
					return line;
				} ).join( '\n' );
				$( '#live-recent-list' ).html( html );
			} )
			.catch( function () {} );
		});
	}

	$( '#liberty-recent-tab1' ).click( function () {
		$( this ).addClass( 'active' );
		$( '#liberty-recent-tab2' ).removeClass( 'active' );
		isArticleTab = true;
		refreshLiveRecent();
	} );

	$( '#liberty-recent-tab2' ).click( function () {
		$( this ).addClass( 'active' );
		$( '#liberty-recent-tab1' ).removeClass( 'active' );
		isArticleTab = false;
		refreshLiveRecent();
	} );

	setInterval( refreshLiveRecent, 5 * 60 * 1000 );
	refreshLiveRecent();
} );
