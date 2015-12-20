<?php
class LibertyTemplate extends BaseTemplate {

	function execute() {
		global $wgRequest;

		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
		<div class="nav-wrapper">
            <?php $this->nav_menu(); ?>
        </div>
        <div class="content-wrapper">
        </div>
        처음부터~~~~~~~ 다시~~~~~~시작하는거~시야~
        <div class="dropdown open">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <button class="dropdown-item" type="button">Action</button>
            <button class="dropdown-item" type="button">Another action</button>
            <button class="dropdown-item" type="button">Something else here</button>
          </div>
        </div>
        <!--<div class="nav-wrapper navbar-fixed-top">
            <?php //$this->nav_menu(); ?>
        </div>
        <div class="content-wrapper">
            <div class="liberty-sidebar">
                <div class="liberty-right-fixed">
                    <?php //$this->liverecent(); ?>
                test
                </div>
                <div>
                </div>
            </div>
            <div class="container-fluid liberty-content">
                <div class="liberty-content-header">
                    <?php //$this->contents_toolbox(); ?>
                    <div class="title">
                        <h1>
                            <?php //$this->html( 'title' ) ?>
                        </h1>
                    </div>
                </div>
                <div class="liberty-content-main">
                    <h1>h1</h1>
                    <h2>h2</h2>
                    <h3>h3</h3>
                    <h4>h4</h4>
                    <h5>h5</h5>
                    <h6>h6</h6>
                    <a href="#" class="new">와아ㅏㅏㅏㅏㅏㅏㅏㅏㅏ 없는문서다ㅏㅏㅏㅏㅏㅏㅏㅏ</a>
                </div>
                <div class="liberty-footer">
                    <?php //$this->footer(); ?>
                </div>
            </div>
        </div>
        -->
        <?php $this->login_modal(); ?>
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
                <a class="nav-link" href="https://bbs.librewiki.net/wiki"><span class="fa fa-leaf"></span><span class="hide-title">위키방</span></a>
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
        <!--알람 만들곳<span style="float: right;">asdf</span>-->
        <?php $this->searchBox(); ?>
    </nav>
    <?php
    }

	function searchBox() {
    ?>
        <form action="<?php $this->text( 'wgScript' ) ?>" id="searchform" class="form-inline pull-xs-right">
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

	function liverecent() {
	?>
	<?php
	}

	function contents_toolbox() {
	?>
    <div class="content-tools">
        <div class="btn-group" role="group" aria-label="content-tools">
            <button type="button" class="btn btn-default none-outline tools-btn">읽기</button>
            <button type="button" class="btn btn-default none-outline tools-btn">편집</button>
            <button type="button" class="btn btn-default none-outline tools-btn">추가</button>
            <button type="button" class="btn btn-default none-outline tools-btn">토론</button>
            <button type="button" class="btn btn-default none-outline tools-btn">역사</button>
            <button type="button" class="btn btn-default none-outline tools-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-right" role="menu">
                <li><a href="#">주시</a></li>
                <li><a href="#">역링크</a></li>
                <li><a href="#">옮기기</a></li>
                <li class="divider"></li>
                <li><a href="#">보호</a></li>
                <li><a href="#">삭제</a></li>
            </ul>
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