<?php // @codingStandardsIgnoreLine
class LibertyTemplate extends BaseTemplate {
	/**
	 * execute() Method
	 */
	public function execute() {
		global $wgRequest, $wgLibertyAdSetting;
		$request = $this->getSkin()->getRequest();
		$action = $request->getVal( 'action', 'view' );
		$title = $this->getSkin()->getTitle();
		$curid = $title->getArticleID();

		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
		<header>
		<div class="nav-wrapper navbar-fixed-top">
			<?php $this->navMenu(); ?>
		</div>
		</header>
		<section>
		<div class="content-wrapper">
			<aside>
			<div class="liberty-sidebar">
				<div class="liberty-right-fixed">
					<?php $this->liveRecent(); ?>
				</div>
				<?php if ( !is_null( $wgLibertyAdSetting['right'] ) ) {
					$this->buildAd( 'right' );
				} ?>
			</div>
			</aside>
			<div class="container-fluid liberty-content">
				<div class="liberty-content-header">
					<?php if ( $this->data['sitenotice'] &&
							   !$wgRequest->getCookie( 'disable-notice' ) ) { ?>
						<div class="alert alert-dismissible fade in alert-info liberty-notice" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<?php $this->html( 'sitenotice' ); ?>
						</div>
					<?php } ?>
					<?php if ( !is_null( $wgLibertyAdSetting['header'] ) ) {
						$this->buildAd( 'header' );
					}
					$this->contentsToolbox(); ?>
					<div class="title">
						<h1>
							<?php $this->html( 'title' ); ?>
						</h1>
					</div>
					<div class="contentSub"<?php $this->html( 'userlangattributes' ); ?>>
						<?php $this->html( 'subtitle' ); ?>
					</div>
				</div>
				<div class="liberty-content-main">
					<?php if ( $title->getNamespace() != NS_SPECIAL &&
							   $action != 'edit' && $action != 'history' ) { ?>
						<div class="social-buttons">
							<div class="twitter" data-text="<?php echo $title; ?>" title="트위터">
								<div><i class="fa fa-twitter"></i></div>
							</div>
							<div class="facebook" data-text="<?php echo $title; ?>" title="페이스북">
								<div><i class="fa fa-facebook"></i></div>
							</div>
						</div>
					<?php } ?>
					<?php
					if ( $this->data['catlinks'] ) {
						$this->html( 'catlinks' );
					}
					?>
					<article>
						<?php $this->html( 'bodycontent' ); ?>
					</article>
				</div>
				<footer>
				<div class="liberty-footer">
					<div class="bottom-ads"></div>
					<?php $this->footer(); ?>
				</div>
				</footer>
			</div>
		</div>
		</section>
		<?php $this->loginModal(); ?>
		<?php
		$this->printTrail();
		$this->html( 'debughtml' );
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		echo "\n";
		wfRestoreWarnings();
	}

	/**
	 * Nav menu function, build top menu.
	 */
	protected function navMenu() {
		?>
		<nav class="navbar navbar-dark">
			<a class="navbar-brand" href="<?php echo Title::newMainPage()->getLocalURL(); ?>"></a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'Recentchanges', null ),
						'<span class="fa fa-refresh"></span><span class="hide-title">최근바뀜</span>', [
							'class' => 'nav-link',
							'title' => '최근 변경 문서를 불러옵니다. [alt+shift+r]',
							'accesskey' => 'r'
						]
					); ?>
				</li>
				<li class="nav-item">
					<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'Randompage', null ),
						'<span class="fa fa-random"></span><span class="hide-title">임의문서</span>', [
							'class' => 'nav-link',
							'title' => '임의 문서를 불러옵니다. [alt+shift+x]',
							'accesskey' => 'x'
						]
					); ?>
				</li>
				<?php echo $this->renderPortal( $this->parseNavbar() ); ?>
			</ul>
			<?php $this->loginBox(); ?>
			<?php $this->getNotification(); ?>
			<?php $this->searchBox(); ?>
		</nav>
	<?php
	}

	/**
	 * Search box function, build top menu's search box.
	 */
	protected function searchBox() {
	?>
		<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform" class="form-inline">
			<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ); ?>"/>
			<div class="input-group">
				<?php echo $this->makeSearchInput( [ 'class' => 'form-control', 'id' => 'searchInput' ] ); ?>
				<span class="input-group-btn">
					<button type="submit" name="go" value="보기" id="searchGoButton"
							class="btn btn-secondary" type="button"><span class="fa fa-eye"></span></button>
					<button type="submit" name="fulltext" value="검색" id="mw-searchButton"
							class="btn btn-secondary" type="button"><span class="fa fa-search"></span></button>
				</span>
			</div>
		</form>
	<?php
	}

	/**
	 * Login box function, build top menu's login button.
	 */
	protected function loginBox() {
		global $wgUser;
		?>
		<div class="navbar-login">
			<?php
			if ( $wgUser->isLoggedIn() ) {
				if ( $wgUser->getEmailAuthenticationTimestamp() ) {
					$email = trim( $wgUser->getEmail() );
					$email = strtolower( $email );
					$email = md5( $email )."?d=identicon";
				} else {
					$email = "00000000000000000000000000000000?d=identicon&f=y";
				}
			?>
				<div class="dropdown login-menu">
					<a class="dropdown-toggle" type="button" id="login-menu"
					   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img class="profile-img" src="//secure.gravatar.com/avatar/<?php echo $email; ?>" />
					</a>
					<div class="dropdown-menu dropdown-menu-right login-dropdown-menu"
						 aria-labelledby="login-menu">
						<?php echo Linker::linkKnown(
							Title::makeTitle( NS_USER, $wgUser->getName() ),
							$wgUser->getName(), [
								'id' => 'pt-userpage',
								'class' => 'dropdown-item',
								'title' => '내 사용자 문서. [alt+shift+u]',
								'accesskey' => 'u'
							]
						); ?>
						<div class="dropdown-divider"></div>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'notifications', null ),
							'알림', [
								'class' => 'dropdown-item',
								'title' => '알림 목록을 불러옵니다.'
							]
						); ?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'Contributions', $wgUser->getName() ),
							'내 기여 목록', [
								'class' => 'dropdown-item',
								'title' => '내 기여 목록을 >불러옵니다. [alt+shift+y]',
								'accesskey' => 'y'
							]
						); ?>
						<?php echo Linker::linkKnown(
							Title::makeTitle( NS_USER_TALK, $wgUser->getName() ),
							'내 토론 문서', [
								'class' => 'dropdown-item',
								'title' => '내 토론 문서. [alt+shift+m]',
								'accesskey' => 'm'
							]
						); ?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'watchlist', null ),
							'내 주시 문서', [
								'class' => 'dropdown-item',
								'title' => '주시문서를 불러옵니다. [alt+shift+l]',
								'accesskey' => 'l'
							]
						); ?>
						<div class="dropdown-divider"></div>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'preferences', null ),
							'환경설정', [
								'class' => 'dropdown-item',
								'title' => '환경설정을 불러옵니다.'
							]
						); ?>
						<div class="dropdown-divider view-logout"></div>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'logout', null ),
							'로그아웃', [
								'class' => 'dropdown-item view-logout',
								'title' => '로그아웃'
							]
						); ?>
					</div>
				</div>
				<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'logout', null ),
						'<span class="fa fa-sign-out"></span>', [
							'class' => 'hide-logout logout-btn',
							'title' => '로그아웃'
						]
					);
				?>
			<?php } else { ?>
				<a href="#" class="none-outline" data-toggle="modal" data-target="#login-modal">
					<span class="fa fa-sign-in"></span>
				</a>
			<?php } ?>
		</div>
	<?php
	}

	/**
	 * Login model function, build login menu model.
	 */
	protected function loginModal() {
		$skin = $this->getSkin();
		$title = $skin->getTitle();

		// Probably no point in rendering a login window for the users who are
		// already logged in?
		if ( $skin->getUser()->isLoggedIn() ) {
			return;
		}
		?>
		<div class="modal fade login-modal" id="login-modal" tabindex="-1"
			 role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title"><?php echo $skin->msg( 'liberty-login' )->plain() ?></h4>
					</div>
					<div class="modal-body">
						<div id="modal-login-alert" class="alert alert-hidden alert-danger" role="alert">
						</div>
						<form id="modal-loginform" name="userlogin" class="modal-loginform"
							  method="post">
							<input class="loginText form-control" id="wpName1" tabindex="1"
								   placeholder="<?php echo $skin->msg( 'userlogin-yourname-ph' )->plain() ?>" value="" name="lgname">
							<label for="inputPassword" class="sr-only"><?php echo $skin->msg( 'userlogin-yourpassword' )->plain() ?></label>
							<input class="loginPassword form-control" id="wpPassword1" tabindex="2"
								   placeholder="<?php echo $skin->msg( 'userlogin-yourpassword-ph' )->plain() ?>" type="password" name="lgpassword">
							<div class="modal-checkbox">
								<input name="lgremember" type="checkbox" value="1" id="lgremember" tabindex="3">
								<label for="lgremember"><?php echo $skin->msg( 'liberty-remember' )->plain() ?></label>
							</div>
							<input class="btn btn-success btn-block" type="submit" value="<?php echo $skin->msg( 'liberty-login-btn' )->plain() ?>" tabindex="4">
							<?php echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'UserLogin' ),
								$skin->msg( 'userlogin-joinproject' ), [
									'class' => 'btn btn-primary btn-block',
									'tabindex' => 5,
									'type' => 'submit'
								], [
									'type' => 'signup',
									'returnto' => $title
								]
							); ?>
							<?php echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'PasswordReset' ),
								$skin->msg( 'liberty-forgot-pw' )->plain()
							); ?>
							<input type="hidden" name="action" value="login" />
							<input type="hidden" name="format" value="json" />
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $skin->msg( 'liberty-btn-close' )->plain() ?></button>
						<button type="button" class="btn btn-primary"><?php echo $skin->msg( 'liberty-btn-save-changes' )->plain() ?></button>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * Live recent function, build right side's Recent menus.
	 */
	protected function liveRecent() {
		$wgLibertyMaxRecent = isset( $GLOBALS['wgLibertyMaxRecent'] ) ?
							  $GLOBALS['wgLibertyMaxRecent'] : 10;
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
					<?php echo str_repeat(
						'<li><span class="recent-item">&nbsp;</span></li>',
						$wgLibertyMaxRecent
					); ?>
				</ul>
			</div>
			<div class="live-recent-footer">
				<?php echo Linker::linkKnown(
					SpecialPage::getTitleFor( 'Recentchanges', null ),
					'<span class="label label-info">더보기</span>'
				); ?>
			</div>
		</div>
	<?php
	}

	/**
	 * Contents tool box function, build article tool menu that will show at article title right.
	 */
	protected function contentsToolbox() {
		global $wgUser;
		$title = $this->getSkin()->getTitle();
		$revid = $this->getSkin()->getRequest()->getText( 'oldid' );
		$notWatched = $this->getSkin()->getUser()->isWatched(
				$this->getSkin()->getRelevantTitle() ) ? true : false;
		$user = ( $wgUser->isLoggedIn() ) ? array_shift( $userLinks ) : array_pop( $userLinks );

		if ( $title->getNamespace() != NS_SPECIAL ) {
			$companionTitle = $title->isTalkPage() ? $title->getSubjectPage() : $title->getTalkPage();
			?>
			<div class="content-tools">
				<div class="btn-group" role="group" aria-label="content-tools">
					<?php echo Linker::linkKnown(
						$title,
						'갱신', [
							'class' => 'btn btn-secondary tools-btn',
							'title' => '문서 캐쉬를 새로 지정하여 문서를 불러옵니다. [alt+shift+p]',
							'accesskey' => 'p'
						],
						[ 'action' => 'purge' ]
					); ?>
					<?php echo Linker::linkKnown(
						$title,
						'편집', [
							'class' => 'btn btn-secondary tools-btn',
							'title' => '문서를 편집합니다. [alt+shift+e]',
							'accesskey' => 'e'
						],
						$revid ? [ 'action' => 'edit', 'oldid' => $revid ] : [ 'action' => 'edit' ]
					); ?>
					<?php echo Linker::linkKnown(
						$title,
						'추가', [
							'class' => 'btn btn-secondary tools-btn',
							'title' => '새 문단을 추가합니다. [alt+shift+n]',
							'accesskey' => 'n'
						],
						[ 'action' => 'edit', 'section' => 'new' ]
					); ?>
					<?php
					if ( $companionTitle ) {
						echo Linker::linkKnown(
							$companionTitle,
							$title->isTalkPage() ? '본문' : '토론', [
								'class' => 'btn btn-secondary tools-btn',
								'title' => $titlename.'을 불러옵니다. [alt+shift+t]',
								'accesskey' => 't'
							]
						);
					}
					?>
					<?php echo Linker::linkKnown(
						$title,
						'기록', [
							'class' => 'btn btn-secondary tools-btn',
							'title' => '문서의 편집 기록을 불러옵니다. [alt+shift+h]',
							'accesskey' => 'h'
						],
						[ 'action' => 'history' ]
					); ?>
					<button type="button" class="btn btn-secondary tools-btn dropdown-toggle"
							data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<div class="dropdown-menu dropdown-menu-right" role="menu">
						<?php
						if ( $title->getNamespace() == NS_USER || $title->getNamespace() == NS_USER_TALK ) {
							echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
								'기여', [
									'class' => 'dropdown-item',
									'title' => '사용자의 기여 목록을 불러옵니다.'
								]
							);
						}
						echo Linker::linkKnown(
							$title,
							$notWatched ? '주시' : '주시해제',
							[ 'class' => 'dropdown-item' ],
							[ 'action' => 'watch' ]
						); ?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'WhatLinksHere', $title ),
							'역링크',
							[ 'class' => 'dropdown-item' ]
						); ?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'Movepage', $title ),
							'이동', [
								'class' => 'dropdown-item',
								'title' => '문서를 옮깁니다. [alt+shift+b]',
								'accesskey' => 'b'
							]
						); ?>
						<?php if ( $title->quickUserCan( 'protect', $user ) ) { ?>
							<div class="dropdown-divider"></div>
							<?php echo Linker::linkKnown(
								$title,
								'보호', [
									'class' => 'dropdown-item',
									'title' => '문서를 보호합니다. [alt+shift+s]',
									'accesskey' => 's'
								],
								[ 'action' => 'protect' ]
							); ?>
						<?php } ?>
						<?php if ( $title->quickUserCan( 'delete', $user ) ) { ?>
							<div class="dropdown-divider"></div>
							<?php echo Linker::linkKnown(
								$title,
								'삭제', [
									'class' => 'dropdown-item',
									'title' => '문서를 삭제합니다. [alt+shift+d]',
									'accesskey' => 'd'
								],
								[ 'action' => 'delete' ]
							); ?>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		}
	}

	/**
	 * Footer function, build footer.
	 */
	protected function footer() {
		foreach ( $this->getFooterLinks() as $category => $links ) { ?>
			<ul class="footer-<?php echo $category; ?>">
				<?php foreach ( $links as $link ) { ?>
					<li class="footer-<?php echo $category; ?>-<?php echo $link; ?>">
						<?php $this->html( $link ); ?>
					</li>
				<?php } ?>
			</ul>
		<?php
		}
		$footericons = $this->getFooterIcons( 'icononly' );
		if ( count( $footericons ) ) {
		?>
			<ul class="footer-icons">
				<?php
				foreach ( $footericons as $blockName => $footerIcons ) {
					?>
					<li class="footer-<?php echo htmlspecialchars( $blockName ); ?>ico">
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

	/**
	 * Get Notification function, build notification menu.
	 */
	protected function getNotification() {
		$personalTools = $this->getPersonalTools();
		$notiCount = $personalTools['notifications-alert']['links'][0]['text'] +
					 $personalTools['notifications-message']['links'][0]['text'];
		if ( $notiCount ) {
		?>
			<div id="pt-notifications" class="navbar-notification">
				<a href="#"><span class="label label-danger"><?php echo $notiCount; ?></span></a>
			</div>
		<?php
		}
	}

	/**
	 * Render Portal function, build top menu contents.
	 * @param Array $contents Menu data that will made by parseNavbar function.
	 */
	protected function renderPortal( $contents ) {
		foreach ( $contents as $content ) {
			if ( !$content ) {
				break;
			}
			?>
			<li class="nav-item dropdown">
				<span class="nav-link dropdown-toggle dropdown-toggle-fix"
					  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
					  title="게시판에 접속합니다.">
					<span class="fa fa-<?php echo $content['icon']; ?>"></span>
					<span class="hide-title"><?php echo $content['text']; ?></span>
				</span>
				<div class="dropdown-menu" role="menu">
					<?php
					if ( is_array( $content['children'] ) ) {
						foreach ( $content['children'] as $child ) {
							?><a href="<?php echo $child['href']; ?>" class="dropdown-item"
								 title="<?php echo $child['text']; ?>"><?php echo $child['text']; ?></a><?php
						}
					}
					?>
				</div>
			</li>
			<?php
		}
	}

	/**
	 * Parse [[MediaWiki:Liberty-Navbar]].
	 *
	 * Its format is:
	 * * <icon name>|Name of the menu displayed to the user
	 * ** link target|Link title (can be the name of an interface message)
	 *
	 * @return array Menu data
	 */
	protected function parseNavbar() {
		global $wgArticlePath;

		$headings = [];
		$currentHeading = null;
		$data = ContentHandler::getContentText( WikiPage::factory(
			Title::newFromText( 'Liberty-Navbar', NS_MEDIAWIKI )
		)->getContent( Revision::RAW ) );
		// Well, [[MediaWiki:Liberty-Navbar]] *should* have some content, but
		// if it doesn't, bail out here so that we don't trigger E_NOTICEs
		// about undefined indexes later on
		if ( empty( $data ) ) {
			return $headings;
		}

		$lines = explode( "\n", $data );

		foreach ( $lines as $line ) {
			$line = rtrim( $line, "\r" );
			if ( $line[0] !== '*' ) {
				// Line does not start with '*'
				continue;
			}
			if ( $line[1] !== '*' ) {
				// Root menu
				$split = explode( '|', $line, 3 );
				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				$descObj = wfMessage( trim( $split[1] ) );
				if ( $descObj->isDisabled() ) {
					$text = htmlentities( trim( $split[1] ), ENT_QUOTES, 'UTF-8' );
				} else {
					$text = $descObj->text();
				}
				$item = [
					'icon' => htmlentities( trim( substr( $split[0], 1 ) ), ENT_QUOTES, 'UTF-8' ),
					'text' => $text,
					'children' => []
				];
				$currentChildren = &$item['children'];
				$headings[] = $item;
			} else {
				// Sub menu
				$split = explode( '|', $line, 3 );
				$href = '';
				$split[0] = trim( substr( $split[0], 2 ) );
				// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
				if ( preg_match( '/http(?:s)?:\/\/(.*)/', $split[0] ) ) {
					// 'http://' or 'https://'
					$href = htmlentities( $split[0], ENT_QUOTES, 'UTF-8' );
				} else {
					// Internal Wiki Document Link
					$href = str_replace( '$1', str_replace( '%3A', ':', urlencode( $split[0] ) ),
							$wgArticlePath );
				}
				if ( !isset( $split[1] ) ) {
					$split[] = '';
				}
				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				$descObj = wfMessage( trim( $split[1] ) );
				if ( $descObj->isDisabled() ) {
					$text = htmlentities( trim( $split[1] ), ENT_QUOTES, 'UTF-8' );
				} else {
					$text = $descObj->text();
				}
				$item = [
					'text' => $text,
					'href' => $href
				];
				$currentChildren[] = $item;
			}
		}

		return $headings;
	}

	/**
	 * Build Adsense Function.
	 * @param String $position Ad Position
	 */
	protected function buildAd( $position ) {
		global $wgLibertyAdSetting;
		?>
			<div class="<?php echo $position; ?>-ads">
				<ins class="adsbygoogle"
					data-ad-client="<?php echo $wgLibertyAdSetting['client']; ?>"
					data-ad-slot="<?php echo $wgLibertyAdSetting[$position]; ?>"
					data-ad-format="auto">
				</ins>
			</div>
		<?php
	}
}
