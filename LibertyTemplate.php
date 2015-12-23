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
                    <?php $this->live_recent(); ?>
                </div>
            </div>
            <div class="container-fluid liberty-content">
                <div class="liberty-content-header">
                    <?php $this->contents_toolbox(); ?>
                    <div class="title">
                        <h1>
                            <?php $this->html( 'title' ) ?>
                        </h1>
                    </div>
                </div>
                <div class="liberty-content-main">
                    <?php $this->html( 'bodycontent' ) ?>
                </div>
                <div class="liberty-footer">
                    <?php $this->footer(); ?>
                </div>
            </div>
        </div>
        <?php $this->login_modal(); ?>
		<?php
		$this->printTrail();
		$this->html('debughtml');
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		echo "\n";
		wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/

    function nav_menu() {
    ?>
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="/"></a>
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Recentchanges', null ), '<span class="fa fa-refresh"></span><span class="hide-title">최근바뀜</span>', array( 'class' => 'nav-link', 'title' => '최근 변경 문서를 불러옵니다. [alt+shift+r]', 'accesskey' => 'r') ); ?>
            </li>
            <li class="nav-item">
                <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Randompage', null ), '<span class="fa fa-random"></span><span class="hide-title">임의문서</span>', array( 'class' => 'nav-link', 'title' => '임의 문서를 불러옵니다. [alt+shift+x]', 'accesskey' => 'x' ) ); ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://bbs.librewiki.net/wiki"><span class="fa fa-comments"></span><span class="hide-title">위키방</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://bbs.librewiki.net/anon"><span class="fa fa-users"></span><span class="hide-title">익명방</span></a>
            </li>
            <li class="nav-item dropdown">
                <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Specialpages', null ), '<span class="fa fa-gear"></span><span class="hide-title">도구</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                <div class="dropdown-menu" role="menu">
                    <?=Linker::linkKnown( SpecialPage::getTitleFor( 'SpecialPages', null ), '특수 문서 목록', array( 'class' => 'dropdown-item', 'title' => '특수 문서 목록을 불러옵니다. [alt+shift+q]', 'accesskey' => 'q') ); ?>
                    <?=Linker::linkKnown( SpecialPage::getTitleFor( 'upload', null ), '업로드', array( 'class' => 'dropdown-item', 'title' => '파일을 올립니다. [alt+shift+g]', 'accesskey' => 'g') ); ?>
                    <a class="dropdown-item" href="https://maps.librewiki.net">리브레맵스</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '<span class="fa fa-book"></span><span class="hide-title">도움말</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                <div class="dropdown-menu" role="menu">
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '위키 문법', array( 'class' => 'dropdown-item' ) ); ?>
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, 'Tex 문법' ), 'Tex 문법', array( 'class' => 'dropdown-item' ) ); ?>
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, '태그' ), '태그', array( 'class' => 'dropdown-item' ) ); ?>
                </div>
            </li>
        </ul>
        <?php $this->loginBox(); ?>
        <?php $this->getNotification(); ?>
        <?php $this->searchBox(); ?>
    </nav>
    <?php
    }

	function searchBox() {
    ?>
        <form action="<?php $this->text( 'wgScript' ) ?>" id="searchform" class="form-inline">
            <input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
            <div class="input-group">
                <?php echo $this->makeSearchInput( array( "class" => "form-control", "id" => "searchInput", "type" => "text") ); ?>
                <span class="input-group-btn">
                    <button type="submit" name="fulltext" value="검색" id="mw-searchButton" class="btn btn-secondary" type="button"><span class="fa fa-search"></span></button>
                    <button type="submit" name="go" value="보기" id="searchGoButton" class="btn btn-secondary" type="button"><span class="fa fa-eye"></span></button>
                </span>
            </div>
        </form>
    <?php
	}

	function loginBox() {
	    global $wgUser, $wgRequest;
	    ?>
        <div class="navbar-login">
            <?php if ($wgUser->isLoggedIn()) {
                if ($wgUser->getEmailAuthenticationTimestamp()) {
                    $email = trim($wgUser->getEmail());
                    $email = strtolower($email);
                    $email = md5($email) . "?d=identicon";
                } else {
                    $email = "00000000000000000000000000000000?d=identicon&f=y";
                }
            ?>
                <div class="dropdown login-menu">
                    <a class="dropdown-toggle" type="button" id="login-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="profile-img" src="//secure.gravatar.com/avatar/<?=$email?>" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right login-dropdown-menu" aria-labelledby="login-menu">
                        <?=Linker::linkKnown( Title::makeTitle( NS_USER, $wgUser->getName() ), $wgUser->getName(), array( 'class' => 'dropdown-item', 'title' => '내 사용자 문서. [alt+shift+u]', 'accesskey' => 'u' ) ); ?>
                        <div class="dropdown-divider"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'notifications', null ), '알림', array( 'class' => 'dropdown-item', 'title' => '알림 목록을 불러옵니다.' )); ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Contributions', $wgUser->getName() ), '내 기여 목록', array( 'class' => 'dropdown-item', 'title' => '내 기여 목록을 >불러옵니다. [alt+shift+y]', 'accesskey' => 'y' ) ); ?>
                        <?=Linker::linkKnown( Title::makeTitle( NS_USER_TALK, $wgUser->getName() ), '내 토론 문서', array( 'class' => 'dropdown-item', 'title' => '내 토론 문서. [alt+shift+m]', 'accesskey' => 'm' ) ); ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'watchlist', null ), '내 주시 문서', array( 'class' => 'dropdown-item', 'title' => '주시문서를 불러옵니다. [alt+shift+l]', 'accesskey' => 'l' ) ); ?>
                        <div class="dropdown-divider"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'preferences', null ), '환경설정', array( 'class' => 'dropdown-item', 'title' => '환경설정을 불러옵니다.' ) ); ?>
                        <div class="dropdown-divider view-logout"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'logout', null ), '로그아웃', array( 'class' => 'dropdown-item view-logout', 'title' => '로그아웃' ) ); ?></li>
                    </div>
                </div>
                <?=Linker::linkKnown( SpecialPage::getTitleFor( 'logout', null ), '<span class="fa fa-sign-out"></span>', array( 'class' => 'hide-logout logout-btn', 'title' => '로그아웃' ) ); ?>
            <?php } else { ?>
            <a href="#" class="none-outline" data-toggle="modal" data-target="#login-modal">
                <span class="fa fa-sign-in"></span>
            </a>
            <?php } ?>
        </div>
	    <?php
	}

    function login_modal() {
    ?>
        <div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">로그인</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal-login-alert" class="alert alert-hidden alert-danger" role="alert">
                        </div>
                        <form id="modal-loginform" name="userlogin" class="modal-loginform" method="post" onsubmit="return LoginManage('<?php $this->html( 'title' ); ?>');">
                            <input class="loginText form-control" id="wpName1" tabindex="1" placeholder="사용자 계정 이름을 입력하세요" value="" name="lgname" autofocus="">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input class="loginPassword form-control" id="wpPassword1" tabindex="2" autofocus="" placeholder="비밀번호를 입력하세요" type="password" name="lgpassword">
                            <div class="modal-checkbox">
                                <input name="lgremember" type="checkbox" value="1" id="lgremember" tabindex="3">
                                <label for="lgremember">로그인 상태를 유지하기</label>
                            </div>
                            <input class="btn btn-success btn-block" type="submit" value="로그인" tabindex="4">
                            <a href="/index.php?title=<?=SpecialPage::getTitleFor( 'UserLogin', null ); ?>&amp;type=signup&amp;returnto=<?php $this->html( 'title' ); ?>" tabindex="5" class="btn btn-primary btn-block" type="submit"><?php $this->msg( 'userlogin-joinproject' ); ?></a>
                            <?=Linker::linkKnown( SpecialPage::getTitleFor( 'PasswordReset', null ), '비밀번호를 잊으셨나요?', array() ); ?>
                            <input type="hidden" name="action" value="login">
                            <input type="hidden" name="format" value="json">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

	function live_recent() {
	?>
	<div class="live-recent">
	    <div class="live-recent-header">
	        <ul class="nav nav-tabs">
                <li class="nav-item">
                <a class="nav-link active" href="#">최근바뀜</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">최근토론</a>
                </li>
            </ul>
	    </div>
	    <div class="live-recent-content">
	        <ul class = "live-recent-list" id="live-recent-list">
	            <li><a class="recent-item" href="/wiki/%EC%9E%A5%ED%95%9C%ED%8F%89%EC%97%AD" title="장한평역">[18:03:40] 장한평역</a></li>
	            <li><a class="recent-item" href="/wiki/%EC%96%B4%EB%A6%B0%EC%9D%B4%EB%8C%80%EA%B3%B5%EC%9B%90%EC%97%AD" title="어린이대공원역">[17:52:56] 어린이대공원역</a></li>
	            <li><a class="recent-item" href="/wiki/%EC%9D%B4%EC%88%98%EC%97%AD" title="이수역">[17:46:41] 이수역</a></li>
	            <li><a class="recent-item" href="/wiki/%EA%B1%B4%EB%8C%80%EC%9E%85%EA%B5%AC%EC%97%AD" title="건대입구역">[17:39:32] 건대입구역</a></li>
	            <li><a class="recent-item" href="/wiki/%ED%8B%80%3ADeemo%EC%9D%98%20%EC%88%98%EB%A1%9D%EA%B3%A1" title="틀:Deemo의 수록곡">[16:32:08] 틀:Deemo의 수록곡</a></li>
	            <li><a class="recent-item" href="/wiki/%ED%8B%80%3ADecimals" title="틀:Decimals">[16:29:12] 틀:Decimals</a></li>
	            <li><a class="recent-item" href="/wiki/%EC%9C%A4%EC%84%9D%EC%98%81" title="윤석영">[16:27:38] 윤석영</a></li>
	            <li><a class="recent-item" href="/wiki/%ED%8B%80%3AClarify" title="틀:Clarify">[16:20:30] 틀:Clarify</a></li>
	            <li><a class="recent-item" href="/wiki/%ED%8B%80%3A%EC%82%AC%EC%9A%A9%EC%9E%90%20%EB%AC%B8%EC%84%9C" title="틀:사용자 문서">[16:19:13] 틀:사용자 문서</a></li>
	            <li><a class="recent-item" href="/wiki/%ED%8B%80%3A100%25%20%EC%98%A4%EB%A0%8C%EC%A7%80%20%EC%A3%BC%EC%8A%A4%20%EC%B9%B4%EB%93%9C" title="틀:100% 오렌지 주스 카드">[16:18:00] 틀:100% 오렌지 주...</a></li>
	        </ul>
	    </div>
	    <div class="live-recent-footer">
            <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Recentchanges', null ), '<span class="label label-info">더보기</span>'); ?>
	    </div>
	</div>
	<?php
	}

	function contents_toolbox() {
	?>
    <div class="content-tools">
        <div class="btn-group" role="group" aria-label="content-tools">
            <button type="button" class="btn btn-secondary tools-btn">읽기</button>
            <button type="button" class="btn btn-secondary tools-btn">편집</button>
            <button type="button" class="btn btn-secondary tools-btn">추가</button>
            <button type="button" class="btn btn-secondary tools-btn">토론</button>
            <button type="button" class="btn btn-secondary tools-btn">역사</button>
            <button type="button" class="btn btn-secondary tools-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a class="dropdown-item" href="#">주시</a>
                <a class="dropdown-item" href="#">역링크</a>
                <a class="dropdown-item" href="#">옮기기</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">보호</a>
                <a class="dropdown-item" href="#">삭제</a>
            </div>
        </div>
    </div>
	<?php
	}

    function footer() {
        foreach ( $this->getFooterLinks() as $category => $links ) {
            ?>
            <ul class="footer-<?=$category;?>">
                <?php foreach ( $links as $link ) {
                ?>
                    <li class="footer-<?=$category;?>-<?=$link;?>"><?php $this->html( $link ); ?></li>
                <?php
                }
                ?>
            </ul>
            <?php
        }
        $footericons = $this->getFooterIcons( "icononly" );
        if ( count( $footericons ) > 0 ) {
        ?>
            <ul class="footer-icons">
                <?php
                    foreach ( $footericons as $blockName => $footerIcons ) {
                    ?>
                        <li class="footer-<?=htmlspecialchars( $blockName );?>ico">
                        <?php
                            foreach ( $footerIcons as $icon ) {
                                echo $this->getSkin()->makeFooterIcon( $icon );
                            }
                        ?>
                        </li>
                    <?php
                    }
                ?>
            </ul>
        <?php
        }
    }

    function getNotification() {
        $personalTools = $this->getPersonalTools();
        $noti_count = $personalTools['notifications']['links']['0']['text'];
        if ($noti_count != "0") {
            ?>
            <div id="pt-notifications" class="navbar-notification">
                <a href="#"><span class="label label-danger"><?=$noti_count;?></span></a>
            </div>
            <?php
        }
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