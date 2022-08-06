<?php
// @codingStandardsIgnoreLine
class SkinLiberty extends SkinTemplate{
	// @codingStandardsIgnoreStart
	public $skinname = 'liberty';
	public $stylename = 'Liberty';
	public $template = 'LibertyTemplate';
	// @codingStandardsIgnoreEnd

	/**
	 * Page initialize.
	 *
	 * @param OutputPage $out OutputPage
	 */
	public function initPage( OutputPage $out ) {
		// @codingStandardsIgnoreLine
		global $wgSitename, $wgTwitterAccount, $wgLanguageCode, $wgNaverVerification, $wgLogo, $wgLibertyEnableLiveRC, $wgLibertyAdSetting, $wgLibertyAdGroup, $wgLibertyNavBarLogoImage;

		$user = $this->getUser();
		/* uncomment if needs to use UserGroupManager
		$service = MediaWiki\MediaWikiServices::getInstance();
		$usergroupmanager = $service->getUserGroupManager();
		$userGroups = $usergroupmanager->getUserGroups($user);
		*/

		$optionMainColor = $user->getOption( 'liberty-color-main' );
		$optionSecondColor = $user->getOption( 'liberty-color-second' );

		$mainColor = $optionMainColor ? $optionMainColor : $GLOBALS['wgLibertyMainColor'];
		// @codingStandardsIgnoreLine
		$tempSecondColor = isset( $GLOBALS['wgLibertySecondColor'] ) ? $GLOBALS['wgLibertySecondColor'] : '#' . strtoupper( dechex( hexdec( substr( $mainColor, 1, 6 ) ) - hexdec( '1A1415' ) ) );
		$secondColor = $optionSecondColor ? $optionSecondColor : $tempSecondColor;
		$ogLogo = isset( $GLOBALS['wgLibertyOgLogo'] ) ? $GLOBALS['wgLibertyOgLogo'] : $wgLogo;
		if ( !preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $ogLogo ) ) {
			$ogLogo = $GLOBALS['wgServer'] . $GLOBALS['wgLogo'];
		}

		$skin = $this->getSkin();

		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );

		if (
			!class_exists( ArticleMetaDescription::class ) ||
			!class_exists( Description2::class )
		) {
			// The validator complains if there's more than one description,
			// so output this here only if none of the aforementioned SEO
			// extensions aren't installed
			$out->addMeta( 'description', strip_tags(
				preg_replace( '/<table[^>]*>([\s\S]*?)<\/table[^>]*>/', '', $out->mBodytext ),
				'<br>'
			) );
		}
		$out->addMeta( 'keywords', $wgSitename . ',' . $skin->getTitle() );

		/* 네이버 웹마스터 도구 */
		if ( isset( $wgNaverVerification ) ) {
			$out->addMeta( 'naver-site-verification', $wgNaverVerification );
		}

		/* IOS 기기 및 모바일 크롬에서의 웹앱 옵션 켜기 및 상단바 투명화 */
		$out->addMeta( 'apple-mobile-web-app-capable', 'Yes' );
		$out->addMeta( 'apple-mobile-web-app-status-bar-style', 'black-translucent' );
		$out->addMeta( 'mobile-web-app-capable', 'Yes' );

		/* 모바일에서의 테마 컬러 적용 */
		// 크롬, 파이어폭스 OS, 오페라
		$out->addMeta( 'theme-color', $mainColor );
		// 윈도우 폰
		$out->addMeta( 'msapplication-navbutton-color', $mainColor );

		/* 트위터 카드 */
		$out->addMeta( 'twitter:card', 'summary' );
		if ( isset( $wgTwitterAccount ) ) {
			$out->addMeta( 'twitter:site', "@$wgTwitterAccount" );
			$out->addMeta( 'twitter:creator', "@$wgTwitterAccount" );
		}

		$modules = [
			'skins.liberty.bootstrap',
			'skins.liberty.layoutjs'
		];

		// Only load ad-related JS if ads are enabled in site configuration
		if ( isset( $wgLibertyAdSetting['client'] ) && $wgLibertyAdSetting['client'] ) {
			$modules[] = 'skins.liberty.ads';
		}

		// Only load LiveRC JS is we have enabled that feature in site config
		if ( $wgLibertyEnableLiveRC ) {
			$modules[] = 'skins.liberty.liverc';
		}

		// Only load modal login JS for anons, no point in loading it for logged-in
		// users since the modal HTML isn't even rendered for them.
		if ( $skin->getUser()->isAnon() ) {
			$modules[] = 'skins.liberty.loginjs';
		}

		$out->addModules( $modules );

		// @codingStandardsIgnoreStart
		$out->addInlineStyle(
			".Liberty .nav-wrapper,
		.Liberty .nav-wrapper .navbar .form-inline .btn:hover,
		.Liberty .nav-wrapper .navbar .form-inline .btn:focus,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link.active::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:hover::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:focus::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:active::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-footer .label,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:hover,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:focus,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:active {
			background-color: $mainColor;
		}

		.Liberty .nav-wrapper .navbar .form-inline .btn:hover,
		.Liberty .nav-wrapper .navbar .form-inline .btn:focus {
			border-color: $secondColor;
		}

		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link.active::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:hover::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:focus::before,
		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link:active::before {
			border-bottom: 2px solid $mainColor;
		}

		.Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-footer .label:hover,
		.Liberty .nav-wrapper .navbar .navbar-nav .nav-item .nav-link:hover,
		.Liberty .nav-wrapper .navbar .navbar-nav .nav-item .nav-link:focus,
		.dropdown-menu .dropdown-item:hover {
			background-color: $secondColor;
		}


		.Liberty .content-wrapper #liberty-bottombtn,
		.Liberty .content-wrapper #liberty-bottombtn:hover {
			background-color: $mainColor;
		}"
		);

		// navbar image settings
		if ( isset( $wgLibertyNavBarLogoImage ) ) {
			$out->addInlineStyle(
				".Liberty .nav-wrapper .navbar .navbar-brand {
					background: transparent url($wgLibertyNavBarLogoImage) no-repeat scroll left center/auto 1.9rem;
				}"
			);
		}

		// layout settings
		$LibertyUserWidthSettings = $user->getOption( 'liberty-layout-width' );
		$LibertyUserSidebarSettings = $user->getOption( 'liberty-layout-sidebar' );
		$LibertyUserNavbarSettings = $user->getOption( 'liberty-layout-navfix' );
		$LibertyUsercontrolbarSettings = $user->getOption( 'liberty-layout-controlbar' );


		if ( isset( $LibertyUserNavbarSettings ) && $LibertyUserNavbarSettings ) {
			$out->addInlineStyle(
				".navbar-fixed-top {
					position: absolute;
				}"
			);
		}

		if ( isset( $LibertyUserSidebarSettings ) && $LibertyUserSidebarSettings ) {
			$out->addInlineStyle(
				".Liberty .content-wrapper .liberty-content {
					margin-right: 0;
				}"
			);
		}

		if ( $LibertyUserWidthSettings !== null ) {
			$out->addInlineStyle(
				".Liberty .content-wrapper {
					max-width: $LibertyUserWidthSettings;
				}

				.Liberty .nav-wrapper .navbar {
					max-width: $LibertyUserWidthSettings;
				}"
			);
		}

		if ( isset( $LibertyUsercontrolbarSettings ) && $LibertyUsercontrolbarSettings ) {
			$out->addInlineStyle(
				".Liberty .content-wrapper #liberty-bottombtn {
					display: none;
				}"
			);
		}

		// 폰트 설정
		$LibertyUserFontSettings = $user->getOption( 'liberty-font' );
		if ( $LibertyUserFontSettings !== null ) {
			$out->addInlineStyle(
				"body, h1, h2, h3, h4, h5, h6, b {
					font-family: $LibertyUserFontSettings;
				}"
			);
		}

		// Ads setting
		if ( isset( $wgLibertyAdSetting['client'] ) && $wgLibertyAdSetting['client'] ) {
			// change ads option by rights
			if ( isset( $wgLibertyAdGroup ) && $wgLibertyAdGroup == 'differ' ) {
				if (
					isset( $wgLibertyAdSetting['header'] ) && $wgLibertyAdSetting['header'] &&
					$user->getOption( 'liberty-ads-header' )
				) {
					$wgLibertyAdSetting['header'] == null;
				}
				if (
					isset( $wgLibertyAdSetting['right'] ) && $wgLibertyAdSetting['right'] &&
					$user->getOption( 'liberty-ads-right' )
				) {
					$wgLibertyAdSetting['right'] == null;
				}
				if (
					isset( $wgLibertyAdSetting['bottom'] ) && $wgLibertyAdSetting['bottom'] &&
					$user->getOption( 'liberty-ads-bottom' )
				) {
					$wgLibertyAdSetting['bottom'] == null;
				}
				if (
					isset( $wgLibertyAdSetting['belowarticle'] ) && $wgLibertyAdSetting['belowarticle'] &&
					$user->getOption( 'liberty-ads-belowarticle' )
				) {
					$wgLibertyAdSetting['belowarticle'] == null;
				}
			}
		}

		$LibertyDarkCss = "body, .Liberty, .dropdown-menu, .dropdown-item, .Liberty .nav-wrapper .navbar .form-inline .btn, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item .nav-link.active, .Liberty .content-wrapper .liberty-content .liberty-content-main table.wikitable tr > th, .Liberty .content-wrapper .liberty-content .liberty-content-main table.wikitable tr > td, table.mw_metadata th, .Liberty .content-wrapper .liberty-content .liberty-content-main table.infobox th, #preferences fieldset:not(.prefsection), #preferences div.mw-prefs-buttons, .navbox, .navbox-subgroup, .navbox > tbody > tr:nth-child(even) > .navbox-list {
			background-color: #000;
			color: #DDD;
		}

		.liberty-content-header, .liberty-footer, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-footer, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item, .Liberty .content-wrapper .liberty-content .liberty-content-header, .Liberty .content-wrapper .liberty-footer, .editOptions, html .wikiEditor-ui-toolbar, #pagehistory li.selected, .mw-datatable td, .Liberty .content-wrapper .liberty-content .liberty-content-main table.wikitable tr > td, table.mw_metadata td, .Liberty .content-wrapper .liberty-content .liberty-content-main table.wikitable, .Liberty .content-wrapper .liberty-content .liberty-content-main table.infobox, #preferences, .navbox-list, .dropdown-divider {
			background-color: #1F2023;
			color: #DDD;
		}

		.Liberty .content-wrapper .liberty-content .liberty-content-main, .mw-datatable th, .mw-datatable tr:hover td, textarea, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-content, div.mw-warning-with-logexcerpt, div.mw-lag-warn-high, div.mw-cascadeprotectedwarning, div#mw-protect-cascadeon {
			background-color: #000;
		}

		.Liberty .content-wrapper .liberty-content .liberty-content-header .title>h1, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-content .live-recent-list .recent-item, caption { color: #DDD; }

		.btn-secondary { background: transparent; color: #DDD; }

		#pagehistory li { border: 0; }

		.Liberty .content-wrapper .liberty-footer, .Liberty .content-wrapper .liberty-content .liberty-content-header, .Liberty .content-wrapper .liberty-content .liberty-content-main, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-footer, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-content, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-header .nav .nav-item + .nav-item, .Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:hover, .Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:focus, .Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn, .dropdown-menu, .dropdown-divider, .Liberty .content-wrapper .liberty-content .liberty-content-main fieldset, hr, .Liberty .content-wrapper .liberty-sidebar .live-recent-wrapper .live-recent .live-recent-content .live-recent-list li, .mw-changeslist-legend, .Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools { border-color: #555; }

		.flow-post, .Liberty .content-wrapper .liberty-content .liberty-content-main .toc .toctext { color: #DDD; }
		.flow-topic-titlebar { color: #000; }
		.flow-ui-navigationWidget { color: #FFF; }
		.Liberty .content-wrapper .liberty-content .liberty-content-main .toccolours, .Liberty .content-wrapper .liberty-content .liberty-content-main .toc ul, .Liberty .content-wrapper .liberty-content .liberty-content-main .toc li { background-color: #000; }
		.Liberty .content-wrapper .liberty-content .liberty-content-main .toc .toctitle { background-color: #1F2023; }";

		$LibertyUserDarkSetting = $user->getOption( 'liberty-dark' );
		if ( $LibertyUserDarkSetting === 'dark' ) {
			$out->addInlineStyle( $LibertyDarkCss );
		} elseif ( $LibertyUserDarkSetting === null ) {
			$out->addInlineStyle( "@media (prefers-color-scheme: dark) { $LibertyDarkCss }" );
		}

		// @codingStandardsIgnoreEnd
		$this->setupCss( $out );
	}

	/**
	 * Setup skin CSS.
	 *
	 * @param OutputPage $out OutputPage
	 */
	public function setupCss( OutputPage $out ) {
		$out->addHeadItem(
			'font-awesome',
			// @codingStandardsIgnoreLine
			'<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.13.1/css/all.css" />'
		);

		$out->addHeadItem(
			'font-awesome-shims',
			// @codingStandardsIgnoreLine
			'<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.13.1/css/v4-shims.css" />'
		);

		$out->addHeadItem(
			'webfonts',
			// @codingStandardsIgnoreLine
			'<link href="https://fonts.googleapis.com/css?family=Dokdo|Gaegu|Nanum+Gothic|Nanum+Gothic+Coding|Nanum+Myeongjo|Noto+Serif+KR|Noto+Sans+KR&display=swap&subset=korean" rel="stylesheet">'
		);

		$out->addHeadItem(
			'share-api-polyfill',
			// @codingStandardsIgnoreLine
			'<script async src="https://unpkg.com/share-api-polyfill/dist/share-min.js"></script>'
		);
		$out->addModuleStyles( [ 'skins.liberty.styles' ] );
	}
}
