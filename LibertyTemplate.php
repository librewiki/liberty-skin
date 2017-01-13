<?php
class LibertyTemplate extends BaseTemplate {

	function execute() {
		global $wgRequest;
        $request = $this->getSkin()->getRequest();
        $action = $request->getVal( 'action', 'view' );
		$title = $this->getSkin()->getTitle();
		$curid = $this->getSkin()->getTitle()->getArticleID();

		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
		<header>
		<div class="nav-wrapper navbar-fixed-top">
            <?php $this->nav_menu(); ?>
        </div>
		</header>
		<section>
        <div class="content-wrapper">
			<aside>
            <div class="liberty-sidebar">
                <div class="liberty-right-fixed">
                    <?php $this->live_recent(); ?>
                </div>
                <div class="right-ads">
                    <ins class="adsbygoogle"
                        style="display:block; min-width: 15rem; width: 100%;"
                        data-ad-client="ca-pub-9526107750460253"
                        data-ad-slot="6581447128"
                        data-ad-format="auto">
                    </ins>
                </div>
            </div>
			</aside>
            <div class="container-fluid liberty-content">
                <div class="liberty-content-header">
                    <?php if ( $this->data['sitenotice'] && $_COOKIE['alertcheck'] != "yes" ) { ?>
                        <div class="alert alert-dismissible fade in alert-info liberty-notice" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php $this->html( 'sitenotice' ) ?>
                        </div>
                    <?php } ?>
                    <div class="header-ads">
                        <ins class="adsbygoogle"
                            style="display:block; min-width:20rem; width:100%;"
                            data-ad-client="ca-pub-9526107750460253"
                            data-ad-slot="3627980722"
                            data-ad-format="auto">
                        </ins>
                    </div>
                    <?php $this->contents_toolbox(); ?>
                    <div class="title">
                        <h1>
                            <?php $this->html( 'title' ) ?>
                        </h1>
                    </div>
                    <div class="contentSub"<?php $this->html( 'userlangattributes' ) ?>>
                        <?php $this->html( 'subtitle' ) ?>
                    </div>
                </div>
                <div class="liberty-content-main">
                    <?php if ( $title->getNamespace() != NS_SPECIAL && $action != "edit" && $action != "history") { ?>
                        <div class="social-buttons">
                            <div class="google" data-url="https://librewiki.net/wiki/<?php $this->html( 'title' ) ?>" data-text="<?php $this->html( 'title' ) ?>" title="구글플러스"><div><i class="fa fa-google-plus"></i></div></div>
                            <div class="twitter" data-url="https://librewiki.net/?curid=<?=$curid;?>" data-text="[<?php $this->html( 'title' ) ?>]%0A" title="트위터"><div><i class="fa fa-twitter"></i></div></div>
                            <div class="facebook" data-url="https://librewiki.net/wiki/<?php $this->html( 'title' ) ?>" data-text="<?php $this->html( 'title' ) ?>" title="페이스북"><div><i class="fa fa-facebook"></i></div></div>
                        </div>
                    <?php } ?>
                    <?php if ( $this->data['catlinks'] ) {
                        $this->html( 'catlinks' );
                    } ?>
					<article>
                    <?php $this->html( 'bodycontent' ) ?>
					</article>
                </div>
                <div class="bottom-ads">
                </div>
				<footer>
                <div class="liberty-footer">
                    <?php $this->footer(); ?>
                </div>
				</footer>
            </div>
        </div>
        </section>
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
            <li class="nav-item dropdown">
                <span class="nav-link dropdown-toggle dropdown-toggle-fix" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="게시판에 접속합니다."><span class="fa fa-comments"></span><span class="hide-title">게시판</span></span>
                <div class="dropdown-menu" role="menu">
					<a class="dropdown-item" href="https://bbs.librewiki.net/wiki">위키방</a>
					<a class="dropdown-item" href="https://bbs.librewiki.net/coop">조합게시판</a>
					<a class="dropdown-item" href="https://bbs.librewiki.net/freeboard">자유게시판</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Specialpages', null ), '<span class="fa fa-gear"></span><span class="hide-title">도구</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                <div class="dropdown-menu" role="menu">
                    <?=Linker::linkKnown( SpecialPage::getTitleFor( 'SpecialPages', null ), '특수 문서 목록', array( 'class' => 'dropdown-item', 'title' => '특수 문서 목록을 불러옵니다. [alt+shift+q]', 'accesskey' => 'q') ); ?>
                    <?=Linker::linkKnown( SpecialPage::getTitleFor( 'upload', null ), '업로드', array( 'class' => 'dropdown-item', 'title' => '파일을 올립니다. [alt+shift+g]', 'accesskey' => 'g') ); ?>
                    <a class="dropdown-item" href="https://maps.librewiki.net">리브레 맵스</a>
	                <a class="dropdown-item" href="https://issue.librewiki.net/">이슈 트래커</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <?php echo Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '<span class="fa fa-book"></span><span class="hide-title">도움말</span>', array( 'class' => 'nav-link dropdown-toggle dropdown-toggle-fix', 'data-toggle' => 'dropdown', ' role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false', 'title' => '도구를 보여줍니다.') ); ?>
                <div class="dropdown-menu" role="menu">
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, '위키 문법' ), '위키 문법', array( 'class' => 'dropdown-item' ) ); ?>
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, 'Tex 문법' ), 'Tex 문법', array( 'class' => 'dropdown-item' ) ); ?>
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, '태그' ), '태그', array( 'class' => 'dropdown-item' ) ); ?>
                    <?=Linker::linkKnown( Title::makeTitle( NS_HELP, '이슈 트래커' ), '이슈 트래커', array( 'class' => 'dropdown-item' ) ); ?>
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
                <?php echo $this->makeSearchInput( array( "class" => "form-control", "id" => "searchInput") ); ?>
                <span class="input-group-btn">
                    <button type="submit" name="go" value="보기" id="searchGoButton" class="btn btn-secondary" type="button"><span class="fa fa-eye"></span></button>
                    <button type="submit" name="fulltext" value="검색" id="mw-searchButton" class="btn btn-secondary" type="button"><span class="fa fa-search"></span></button>
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
                        <?=Linker::linkKnown( Title::makeTitle( NS_USER, $wgUser->getName() ), $wgUser->getName(), array( 'id' => 'pt-userpage', 'class' => 'dropdown-item', 'title' => '내 사용자 문서. [alt+shift+u]', 'accesskey' => 'u' ) ); ?>
                        <div class="dropdown-divider"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'notifications', null ), '알림', array( 'class' => 'dropdown-item', 'title' => '알림 목록을 불러옵니다.' )); ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Contributions', $wgUser->getName() ), '내 기여 목록', array( 'class' => 'dropdown-item', 'title' => '내 기여 목록을 >불러옵니다. [alt+shift+y]', 'accesskey' => 'y' ) ); ?>
                        <?=Linker::linkKnown( Title::makeTitle( NS_USER_TALK, $wgUser->getName() ), '내 토론 문서', array( 'class' => 'dropdown-item', 'title' => '내 토론 문서. [alt+shift+m]', 'accesskey' => 'm' ) ); ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'watchlist', null ), '내 주시 문서', array( 'class' => 'dropdown-item', 'title' => '주시문서를 불러옵니다. [alt+shift+l]', 'accesskey' => 'l' ) ); ?>
                        <div class="dropdown-divider"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'preferences', null ), '환경설정', array( 'class' => 'dropdown-item', 'title' => '환경설정을 불러옵니다.' ) ); ?>
                        <div class="dropdown-divider view-logout"></div>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'logout', null ), '로그아웃', array( 'class' => 'dropdown-item view-logout', 'title' => '로그아웃' ) ); ?>
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
                            <input class="loginText form-control" id="wpName1" tabindex="1" placeholder="사용자 계정 이름을 입력하세요" value="" name="lgname">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input class="loginPassword form-control" id="wpPassword1" tabindex="2"  placeholder="비밀번호를 입력하세요" type="password" name="lgpassword">
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
                <a href="javascript:" class="nav-link active" id="liberty-recent-tab1">최근바뀜</a>
            </li>
            <li class="nav-item">
                <a href="javascript:" class="nav-link" id="liberty-recent-tab2">최근토론</a>
            </li>
          </ul>
	    </div>
	    <div class="live-recent-content">
	        <ul class="live-recent-list" id="live-recent-list">
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	            <li><span class="recent-item">&nbsp;</span></li>
	        </ul>
	    </div>
	    <div class="live-recent-footer">
          <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Recentchanges', null ), '<span class="label label-info">더보기</span>'); ?>
	    </div>
	</div>
	<?php
	}

	function contents_toolbox() {
	    global $wgUser;
        $title = $this->getSkin()->getTitle();
        $revid = $this->getSkin()->getRequest()->getText( 'oldid' );
        $watched = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() ) ? 'unwatch' : 'watch';
        $user = ( $wgUser->isLoggedIn() ) ? array_shift($userLinks) : array_pop($userLinks);

	    if ( $title->getNamespace() != NS_SPECIAL ) {
            $companionTitle = $title->isTalkPage() ? $title->getSubjectPage() : $title->getTalkPage();
            ?>
            <div class="content-tools">
                <div class="btn-group" role="group" aria-label="content-tools">
                    <?=Linker::linkKnown( $title, '읽기', array( 'class' => 'btn btn-secondary tools-btn', 'title' => '문서 캐쉬를 새로 지정하여 문서를 불러옵니다. [alt+shift+p]', 'accesskey' => 'p' ), array( 'action' => 'purge' ) ); ?>
                    <?php
                    if ($revid) {
                        $editaction = array( 'action' => 'edit', 'oldid' => $revid );
                    } else {
                        $editaction = array( 'action' => 'edit' );
                    }
                    ?>
                    <?=Linker::linkKnown( $title, '편집', array( 'class' => 'btn btn-secondary tools-btn', 'title' => '문서를 편집합니다. [alt+shift+e]', 'accesskey' => 'e' ), $editaction ); ?>
                    <?=Linker::linkKnown( $title, '추가', array( 'class' => 'btn btn-secondary tools-btn', 'title' => '새 문단을 추가합니다. [alt+shift+n]', 'accesskey' => 'n' ), array( 'action' => 'edit', 'section' => 'new' ) ); ?>
                    <?php
                        if ($companionTitle) {
                            if ($title->getNamespace() == NS_TALK || $title->getNamespace() == NS_PROJECT_TALK || $title->getNamespace() == NS_FILE_TALK || $title->getNamespace() == NS_TEMPLATE_TALK) {
                                $titlename = '본문';
                            } else {
                                $titlename = '토론';
                            }
                            echo Linker::linkKnown( $companionTitle, $titlename, array( 'class' => 'btn btn-secondary tools-btn', 'title' => $titlename.'을 불러옵니다. [alt+shift+t]', 'accesskey' => 't') );
                        }
                    ?>
                    <?=Linker::linkKnown( $title, '기록', array( 'class' => 'btn btn-secondary tools-btn', 'title' => '문서의 편집 기록을 불러옵니다. [alt+shift+h]', 'accesskey' => 'h' ), array( 'action' => 'history' ) ); ?>
                    <button type="button" class="btn btn-secondary tools-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php
                            if ($watched != 'watch') {
                                $watchname = '주시해제';
                            } else {
                                $watchname = '주시';
                            }
                            echo Linker::linkKnown( $title, $watchname, array('class' => 'dropdown-item'), array( 'action' => $mode ) );
                        ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'WhatLinksHere', $title ), '역링크', array('class' => 'dropdown-item')  ); ?>
                        <?=Linker::linkKnown( SpecialPage::getTitleFor( 'Movepage', $title ), '옮기기', array( 'class' => 'dropdown-item', 'title' => '문서를 옮깁니다. [alt+shift+b]', 'accesskey' => 'b' )); ?>
                        <?php
                            if ( $title->quickUserCan( 'protect', $user ) ) { ?>
                                <div class="dropdown-divider"></div>
                                <?=Linker::linkKnown( $title, '보호', array( 'class' => 'dropdown-item', 'title' => '문서를 보호합니다. [alt+shift+s]', 'accesskey' => 's' ), array( 'action' => 'protect' ) ); ?>
                            <?php } ?>
                            <?php if ( $title->quickUserCan( 'delete', $user ) ) { ?>
                                <div class="dropdown-divider"></div>
                                <?=Linker::linkKnown( $title, '삭제', array( 'class' => 'dropdown-item', 'title' => '문서를 삭제합니다. [alt+shift+d]', 'accesskey' => 'd' ), array( 'action' => 'delete' ) ); ?>
                            <?php }
                         ?>
                    </div>
                </div>
            </div>
        <?php
        }
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
} // end of class
