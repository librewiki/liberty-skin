$( function () {
	'use strict';
	var documentNamespaces, topicNamespaces, isDocumentTab, limit;
	documentNamespaces = '0|4|10|12|14|1600';
	topicNamespaces = '1|3|5|7|9|11|13|15|2600|1601|1063';
	isDocumentTab = true;
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
			rcnamespace: isDocumentTab ? documentNamespaces : topicNamespaces,
			rctoponly: true
		};
		$.ajax( {
			url: mw.util.wikiScript( 'api' ),
			data: getParameter,
			xhrFields: {
				withCredentials: true
			},
			dataType: 'json'
		} ).then( function ( data ) {
			var recentChanges, html, time, line, text;
			recentChanges = data.query.recentchanges;
			html = recentChanges.map( function ( item ) {
				time = new Date( item.timestamp );
				line = '<li><a class="recent-item" href = "' + ( mw.config.get( 'wgArticlePath' ) ).replace( '$1', encodeURIComponent( item.title ) ) + '" title="' + item.title + '">[' + timeFormat( time ) + '] ';
				text = '';
				if ( item.type === 'new' ) {
					text += '[New]';
				}
				text += item.title;
				if ( text.length > 13 ) {
					text = text.substr( 0, 13 );
					text += '...';
				}
				// @todo FIXME: This just doesn't work and I've no idea why.
				// The i18n msg is properly defined etc. yet it shows up as <liberty-feed-new>
				// when called by the below line :-(
				// text = text.replace( '[New]', '<span class="new">' + mw.msg( 'liberty-feed-new' ) + ' </span>' );
				text = text.replace( '[New]', '<span class="new">[New] </span>' );
				line += text;
				line += '</a></li>';
				return line;
			} ).join( '\n' );
			$( '#live-recent-list' ).html( html );
		}, function () {
			return;
		} );
	}

	$( '#liberty-recent-tab1' ).click( function () {
		$( this ).addClass( 'active' );
		$( '#liberty-recent-tab2' ).removeClass( 'active' );
		isDocumentTab = true;
		refreshLiveRecent();
	} );

	$( '#liberty-recent-tab2' ).click( function () {
		$( this ).addClass( 'active' );
		$( '#liberty-recent-tab1' ).removeClass( 'active' );
		isDocumentTab = false;
		refreshLiveRecent();
	} );

	setInterval( refreshLiveRecent, 5 * 60 * 1000 );
	refreshLiveRecent();
} );
