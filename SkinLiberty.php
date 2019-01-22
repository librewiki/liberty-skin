<?php // @codingStandardsIgnoreLine
class SkinLiberty extends SkinTemplate {
	public $skinname = 'liberty';
	public $stylename = 'Liberty';
	public $template = 'LibertyTemplate';

	/**
	 * Page initialize.
	 * @param OutputPage $out OutputPage
	 */
	public function initPage( OutputPage $out ) {
		// @codingStandardsIgnoreLine
		global $wgSitename, $wgTwitterAccount, $wgLanguageCode, $wgNaverVerification, $wgLogo, $wgLibertyEnableLiveRC;
		$optionMainColor = $this->getUser()->getOption( 'liberty-color-main' );
		$optionSecondColor = $this->getUser()->getOption( 'liberty-color-second' );

		$mainColor = $optionMainColor ? $optionMainColor : $GLOBALS['wgLibertyMainColor'];
		// @codingStandardsIgnoreLine
		$tempSecondColor = isset( $GLOBALS['wgLibertySecondColor'] ) ? $GLOBALS['wgLibertySecondColor'] : '#'.strtoupper( dechex( hexdec( substr( $mainColor, 1, 6 ) ) - hexdec( '1A1415' ) ) );
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

		// Only load LiveRC JS is we have enabled that feature in site config
		if ( $wgLibertyEnableLiveRC ) {
			$modules[] = 'skins.liberty.liverc';
		}

		// Only load modal login JS for anons, no point in loading it for logged-in
		// users since the modal HTML isn't even rendered for them.
		if ( $skin->getUser()->isAnon() ) {
			$modules[] = 'skins.liberty.loginjs';
		}

		$out->addModuleScripts( $modules );

		// @codingStandardsIgnoreStart
		$out->addInlineStyle( ".Liberty .nav-wrapper,
		.Liberty .nav-wrapper .navbar .form-inline .btn:hover,
		.Liberty .nav-wrapper .navbar .form-inline .btn:focus,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link.active::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:hover::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:focus::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:active::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-footer .label,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:hover,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:focus,
		.Liberty .content-wrapper .liberty-content .liberty-content-header .content-tools .tools-btn:active {
			background-color: $mainColor;
		}
		
		.Liberty .nav-wrapper .navbar .form-inline .btn:hover,
		.Liberty .nav-wrapper .navbar .form-inline .btn:focus {
			border-color: $secondColor;
		}
		
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link.active::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:hover::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:focus::before,
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-header .nav .nav-item .nav-link:active::before {
			border-bottom: 2px solid $mainColor;
		}
		
		.Liberty .content-wrapper .liberty-sidebar .liberty-right-fixed .live-recent .live-recent-footer .label:hover,
		.Liberty .nav-wrapper .navbar .navbar-nav .nav-item .nav-link:hover,
		.Liberty .nav-wrapper .navbar .navbar-nav .nav-item .nav-link:focus,
		.dropdown-menu .dropdown-item:hover {
			background-color: $secondColor;
		}" );

				// 폰트 설정
				$LibertyUserFontSettings = $this->getUser()->getOption( 'liberty-font' );
				if ( $LibertyUserFontSettings != "default") {
					$out->addInlineStyle( "body, h1, h2, h3, h4, h5, h6, b {
					font-family: $LibertyUserFontSettings;
					}");
				}
				
				// 웹폰트 로딩
				$LibertyUserWebFontSettings = $this->getUser()->getOption( 'liberty-font-web' );
				$LibertyAvailableWebFonts = ['Nanum Gothic', 'Nanum Myeongjo', 'KoPubDotum', 'Noto Sans CJK KR'  ];
				$LibertyWebFontAvailableCheck = in_array ( $LibertyUserFontSettings , $LibertyAvailableWebFonts);
				if ( $LibertyUserFontSettings != "default" && $LibertyUserWebFontSettings == True && $LibertyWebFontAvailableCheck == True) {
					$LibertyWebFontAddress = $this -> getSkin() -> getSkinStylePath ('fonts/'.$LibertyUserFontSettings.".woff");
					$out->addInlineStyle( "
					@font-face {
						font-family: $LibertyUserFontSettings; 
						src: url('$LibertyWebFontAddress')  format('woff')
					  }
					  ");
				}

				// @codingStandardsIgnoreEnd
	}

	/**
	 * Setup Skin CSS.
	 * @param OutputPage $out OutputPage
	 */
	public function setupSkinUserCss( OutputPage $out ) {
		global $wgLibertyAdSetting;

		parent::setupSkinUserCss( $out );

		$out->addHeadItem(
			'font-awesome',
			// @codingStandardsIgnoreLine
			'<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />'
		);

		// Only load AdSense JS is ads are enabled in site configuration
		if ( !is_null( $wgLibertyAdSetting['client'] ) ) {
			$out->addHeadItem(
				'google-ads',
				// @codingStandardsIgnoreLine
				'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'
			);
		}

		$out->addModuleStyles( [ 'skins.liberty.styles' ] );
	}

	/**
	 * Set body class.
	 * @param OutputPage $out OutputPage
	 * @param Mixed &$bodyAttrs Body Attributes
	 */
	public function addToBodyAttributes( $out, &$bodyAttrs ) {
		$bodyAttrs['class'] .= ' Liberty width-size';
	}
}
