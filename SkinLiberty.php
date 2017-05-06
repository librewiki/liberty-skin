<?php
class SkinLiberty extends SkinTemplate {

	public $skinname = 'liberty';
	public $stylename = 'Liberty';
	public $template = 'LibertyTemplate';

    public function initPage( OutputPage $out ) {
		global $wgLibertyMainColor, $wgSitename, $wgTwitterAccount, $wgLogo, $wgLanguageCode, $wgNaverVerification;
		$wgLibertyMainColor = isset($wgLibertyMainColor) ? $wgLibertyMainColor : '#4188F1';

        parent::initPage( $out );
        $out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1');
        $out->addMeta( 'description', $wgSitename);
        $out->addMeta( 'keywords', $wgSitename);
		
		/* 네이버 웹마스터 도구 */
		if(isset($wgNaverVerification)) { $out->addMeta('naver-site-verification', $wgNaverVerification); }
		
		/* IOS 기기 및 모바일 크롬에서의 웹앱 옵션 켜기 및 상단바 투명화 */
		$out->addMeta('apple-mobile-web-app-capable', 'Yes');
		$out->addMeta('apple-mobile-web-app-status-bar-style', 'black-translucent');
		$out->addMeta('mobile-web-app-capable', 'Yes');
		
		/* 모바일에서의 테마 컬러 적용 */
		//크롬, 파이어폭스 OS, 오페라
		$out->addMeta('theme-color', $wgLibertyMainColor);
		//윈도우 폰
		$out->addMeta('msapplication-navbutton-color', $wgLibertyMainColor); 
		
		/* OpenGraph */
		$out->addMeta('og:image', $wgLogo);
		$out->addMeta('og:locale', $wgLanguageCode);

		
		/* 트위터 카드 */
		if(isset($wgTwitterAccount)) {
			$out->addMeta('twitter:card', 'summary');
			$out->addMeta('twitter:site', "@$wgTwitterAccount");
			$out->addMeta('twitter:title', $this->getSkin()->getTitle());
			$out->addMeta('twitter:description', strip_tags(preg_replace('/<table[^>]*>([\s\S]*?)<\/table[^>]*>/', '', $out->mBodytext)),'<br>');
			$out->addMeta('twitter:creator', "@$wgTwitterAccount");
			$out->addMeta('twitter:image', $wgLogo);
		}
		
		
		
        $out->addModuleScripts( array(
            'skins.liberty.bootstrap'
        ) );
        $out->addModuleScripts( array(
            'skins.liberty.layoutjs'
        ) );
    }

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addHeadItem( 'font-awesome', '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />' );
		$out->addHeadItem( 'google-ads', '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>' );
		$out->addModuleStyles( array(
			'skins.liberty.styles'
		) );
	}
	function addToBodyAttributes( $out, &$bodyAttrs ) {
        $bodyAttrs['class'] .= " Liberty width-size";
    }
}
