<?php
class LibertyTemplate extends BaseTemplate {

	function execute() {
		global $wgRequest;

		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
        <div class="nav-wrapper navbar-fixed-top">
            <?php $this->nav_menu(); ?>
        </div>
        <div class="content-wrapper">
            <div class="liberty-sidebar">
                <div class="liberty-right-fixed">
                test
                </div>
                <div>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                </div>
            </div>
            <div class="container-fluid liberty-content">
                <div class="liberty-content-header">
                title부분
                </div>
                <div class="liberty-content-main">
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                <?php echo $this->makeSearchInput( array( "class" => "search-form", "id" => "searchInput" ) ); ?>
                <input type="search" value="test">
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>
                content부분</br>

                <?php
                    echo $wgRequest->getSessionData( 'wsCreateaccountToken' );
                ?>
                </div>
                <div class="liberty-footer">
                    <?php $this->footer(); ?>
                </div>
            </div>
        </div>
        <div class="modal fade modal-login" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">로그인</h4>
                    </div>
                    <div class="modal-body">
                    <div id="modal-login-alert" class="alert alert-hidden" role="alert">
                    </div>
                    <form id="modal-loginform" name="userlogin" class="modal-loginform" method="post" onsubmit="return LoginManage('<?php $this->html( 'title' ); ?>');">
                    <input class="loginText form-control" id="wpName1" tabindex="1" placeholder="사용자 계정 이름을 입력하세요" value="" name="lgname" autofocus="">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input class="loginPassword form-control" id="wpPassword1" tabindex="2" autofocus="" placeholder="비밀번호를 입력하세요" type="password" name="lgpassword">
                    <div class="modal-checkbox">
                    <input name="wpRemember" type="checkbox" value="1" id="lgremember" tabindex="3">
                    <label for="lgremember">로그인 상태를 유지하기</label>
                    </div>
                    <input class="btn btn-lg btn-success btn-block" type="submit" value="로그인" tabindex="4">
                    <a href="/index.php?title=<?=SpecialPage::getTitleFor( 'UserLogin', null ); ?>&amp;type=signup&amp;returnto=<?php $this->html( 'title' ); ?>" tabindex="5" class="btn btn-lg btn-primary btn-block" type="submit"><?php $this->msg( 'userlogin-joinproject' ); ?></a>
                    <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'PasswordReset', null ), '비밀번호를 잊으셨나요?', array() ); ?>
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="format" value="json">
                    </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
		<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		echo "\n";
		wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/

    function nav_menu() {
    ?>
        <nav class="navbar">
            <div class="navbar-header">
                <a class="navbar-brand" href="/"></a>
            </div>
            <div class="navgation">
                <ul class="nav navbar-nav">
                    <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Recentchanges', null ), '<span class="fa fa-refresh"></span><span class="hide-title">최근바뀜</span>', array( 'class' => 'nav-link', 'title' => '최근 변경 문서를 불러옵니다. [alt+shift+r]', 'accesskey' => 'r') ); ?></li>
                    <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Randompage', null ), '<span class="fa fa-random"></span><span class="hide-title">임의문서</span>', array( 'class' => 'nav-link', 'title' => '임의 문서를 불러옵니다. [alt+shift+x]', 'accesskey' => 'x' ) ); ?></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/wiki"><span class="fa fa-leaf"></span><span class="hide-title">위키방</span></a></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/anon"><span class="fa fa-users"></span><span class="hide-title">익명방</span></a></li>
                    <li class="dropdown"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Specialpages', null ), '<span class="fa fa-gear"></span><span class="hide-title">도구</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                        <ul class="dropdown-menu" role="menu">
                            <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'SpecialPages', null ), '특수 문서 목록', array( 'title' => '특수 문서 목록을 불러옵니다. [alt+shift+q]', 'accesskey' => 'q') ); ?></li>
                            <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'upload', null ), '업로드', array( 'title' => '파일을 올립니다. [alt+shift+g]', 'accesskey' => 'g') ); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown"><?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '<span class="fa fa-book"></span><span class="hide-title">도움말</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                        <ul class="dropdown-menu" role="menu">
                            <li><?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '위키 문법' ) ; ?></li>
                            <li><?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, 'Tex 문법' ), 'Tex 문법' ) ; ?></li>
                            <li><?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, '태그' ), '태그' ) ; ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-nav">
                <?php $this->searchBox(); ?>
                <?php $this->loginBox(); ?>
            </div>
        </nav>
    <?php
    }

	function searchBox() {
        ?>
        <div id="p-search" class="portlet" role="search">
            <div id="searchBody" class="pBody">
                <form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
                    <input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
                    <?php echo $this->makeSearchInput( array( "class" => "search-form", "id" => "searchInput" ) ); ?>
                    <span class="search-icon">
                        <button type="submit" name="fulltext" value="검색" class="fa fa-search" id="mw-searchButton" tabindex="-1">
                            <span class="visuallyhidden">검색</span>
                        </button>
                    </span>
                    <span class="go-icon">
                        <button type="submit" name="go" value="보기" class="fa fa-eye" id="searchGoButton" tabindex="-1">
                            <span class="visuallyhidden">보기</span>
                        </button>
                    </span>
                </form>
                <?php $this->renderAfterPortlet( 'search' ); ?>
            </div>
        </div>
        <?php
	}

	function loginBox() {
	    global $wgUser, $wgRequest;
	    ?>
	    <div class="dropdown nav-login">
            <?php
            if ($wgUser->isLoggedIn()) {
            ?>
                <a id="drop1" href="#" class="dropdown-toggle profile-link" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                    <?php
                        if ($wgUser->getEmailAuthenticationTimestamp()) {
                            $email = trim($wgUser->getEmail());
                            $email = strtolower($email);
                            $email = md5($email) . "?d=identicon";
                        } else {
                            $email = "00000000000000000000000000000000?d=identicon&f=y";
                        }
                    ?>
                    <img class="profile-img" src="//secure.gravatar.com/avatar/<?=$email?>" />
                </a>
                <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'logout', null ), '<span class="fa fa-sign-out"></span>', array( 'title' => '로그아웃' ) ); ?>
                <?php
            } else {
            ?>
                <a href="#" class="none-outline" data-toggle="modal" data-target="#login-modal">
                    <span class="fa fa-sign-in"></span>
                </a>
            <?php
            }
            ?>
            <?php
                if ($wgUser->isLoggedIn()) {
            ?>
            <ul class="dropdown-menu dropdown-menu-right login-menu" role="menu" aria-labelledby="drop1">
                <li id="pt-userpage"><?php echo Linker::linkKnown( Title::makeTitle( NS_USER, $wgUser->getName() ), $wgUser->getName(), array( 'title' => '내 사용자 문서. [alt+shift+u]', 'accesskey' => 'u' ) ); ?></li>
                <li role="presentation" class="divider"></li>
                <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'notifications', null ), '알림', array( 'title' => '알림 목록을 불러옵니다.' )); ?></li>
                <li id="pt-mycontris"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Contributions', $wgUser->getName() ), '내 기여 목록', array( 'title' => '내 기여 목록을 >불러옵니다. [alt+shift+y]', 'accesskey' => 'y' ) ); ?></li>
                <li id="pt-mytalk"><?php echo Linker::linkKnown( Title::makeTitle( NS_USER_TALK, $wgUser->getName() ), '내 토론 문서', array( 'title' => '내 토론 문서. [alt+shift+m]', 'accesskey' => 'm' ) ); ?></li>
                <li id="pt-watchlist"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'watchlist', null ), '내 주시 문서', array( 'title' => '주시문서를 불러옵니다. [alt+shift+l]', 'accesskey' => 'l' ) ); ?></li>
                <li role="presentation" class="divider"></li>
                <li id="pt-preferences"><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'preferences', null ), '환경설정', array( 'title' => '환경설정을 불러옵니다.' ) ); ?></li>
            </ul>
            <?php
            }
            ?>
	    </div>
	    <?php
	}

    function footer() {
        foreach ( $this->getFooterLinks() as $category => $links ) { ?>
        <ul id="footer-<?php echo $category ?>">
        <?php foreach ( $links as $link ) { ?>
        <li id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></li>
        <?php } ?>
        </ul>
        <?php }
    }

	/*************************************************************************************************/
	function toolbox() {
		?>
		<div class="portlet" id="p-tb" role="navigation">
			<h3><?php $this->msg( 'toolbox' ) ?></h3>

			<div class="pBody">
				<ul>
					<?php
					foreach ( $this->getToolbox() as $key => $tbitem ) {
						?>
						<?php echo $this->makeListItem( $key, $tbitem ); ?>

					<?php
					}
					wfRunHooks( 'LibertyTemplateToolboxEnd', array( &$this ) );
					wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
					?>
				</ul>
				<?php $this->renderAfterPortlet( 'tb' ); ?>
			</div>
		</div>
	<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if ( $this->data['language_urls'] !== false ) {
			?>
			<div id="p-lang" class="portlet" role="navigation">
				<h3<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h3>

				<div class="pBody">
					<ul>
						<?php foreach ( $this->data['language_urls'] as $key => $langlink ) { ?>
							<?php echo $this->makeListItem( $key, $langlink ); ?>

						<?php
}
						?>
					</ul>

					<?php $this->renderAfterPortlet( 'lang' ); ?>
				</div>
			</div>
		<?php
		}
	}

	/*************************************************************************************************/
	/**
	 * @param string $bar
	 * @param array|string $cont
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = array(
			'class' => 'generated-sidebar portlet',
			'id' => Sanitizer::escapeId( "p-$bar" ),
			'role' => 'navigation'
		);

		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'div', $portletAttribs );
		$msgObj = wfMessage( $bar );
		?>

		<h3><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $bar ); ?></h3>
		<div class='pBody'>
			<?php
			if ( is_array( $cont ) ) {
				?>
				<ul>
					<?php
					foreach ( $cont as $key => $val ) {
						?>
						<?php echo $this->makeListItem( $key, $val ); ?>

					<?php
					}
					?>
				</ul>
			<?php
			} else {
				# allow raw HTML block to be defined by extensions
				print $cont;
			}

			$this->renderAfterPortlet( $bar );
			?>
		</div>
		</div>
	<?php
	}
} // end of class