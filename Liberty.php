<?php
if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Liberty' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Liberty'] = __DIR__ . '/i18n';
	return true;
} else {
	die( 'This version of the Liberty skin requires MediaWiki 1.25+' );
}
