<?php
class SkinLiberty extends SkinTemplate {

	public $skinname = 'liberty';
	public $stylename = 'Liberty';
	public $template = 'LibertyTemplate';

    public function initPage( OutputPage $out ) {
        parent::initPage( $out );
        $out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );
        $out->addMeta( 'description', 'librewiki' );
        $out->addMeta( 'keywords', 'wiki,librewiki,리브레위키,리브레 위키,' . $this->getSkin()->getTitle() );
		
		/* IOS 기기 및 모바일 크롬에서의 웹앱 옵션 켜기 및 상단바 투명화 */
		$out->addMeta('apple-mobile-web-app-capable', 'Yes');
		$out->addMeta('apple-mobile-web-app-status-bar-style', 'black-translucent');
		$out->addMeta('mobile-web-app-capable', 'Yes');

		
		
        $out->addModuleScripts( array(
            'skins.liberty.bootstrap'
        ) );
        $out->addModuleScripts( array(
            'skins.liberty.layoutjs'
        ) );
    }

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
			/* 스킨 깨짐 방지 임시조치 */
			$out->addHeadItem( 'maincss', '<link rel="stylesheet" href="css/default.css" />' );
			$out->addHeadItem( 'mobilecss', '<link rel="stylesheet" href="css/default_mobile.css" />' );
			$out->addHeadItem( 'mobilecss', '<link rel="stylesheet" href="css/default_mobile.css" />' );
			$out->addHeadItem( 'onlymwcss', '<link rel="stylesheet" href="css/only-mw.css" />' );
			$out->addHeadItem( 'wikitablecss', '<link rel="stylesheet" href="css/wiki-table.css" />' );
			
			
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
