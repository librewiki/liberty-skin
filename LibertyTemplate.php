<?php // @codingStandardsIgnoreLine

use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\RevisionRecord;

class LibertyTemplate extends BaseTemplate {
	/**
	 * execute() Method
	 */
	public function execute() {
		global $wgLibertyAdSetting, $wgLibertyMobileReplaceAd;

		$skin = $this->getSkin();
		$user = $skin->getUser();
		$request = $skin->getRequest();
		$action = $request->getVal( 'action', 'view' );
		$title = $skin->getTitle();
		$LibertyUserSidebarSettings = $user->getOption( 'liberty-layout-sidebar' );

		$this->html( 'headelement' );
?>
		<header>
			<div class="nav-wrapper navbar-fixed-top">
				<?php $this->navMenu(); ?>
			</div>
		</header>
		<section>
			<div class="content-wrapper">
				<?php if ( $LibertyUserSidebarSettings == false ) { ?>
					<aside>
						<div class="liberty-sidebar">
							<div class="live-recent-wrapper">
								<?php $this->liveRecent(); ?>
							</div>
							<?php if ( isset( $wgLibertyAdSetting['right'] ) && $wgLibertyAdSetting['right'] ) {
								$this->buildAd( 'right' );
							} ?>
						</div>
					</aside>
				<?php } ?>
				<div class="container-fluid liberty-content">
					<div class="liberty-content-header">
						<?php if (
							$this->data['sitenotice'] &&
							!$request->getCookie( 'disable-notice' )
						) { ?>
							<div class="alert alert-dismissible fade in alert-info liberty-notice" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php $this->html( 'sitenotice' ); ?>
							</div>
						<?php } ?>
						<?php if ( isset( $wgLibertyAdSetting['header'] ) && $wgLibertyAdSetting['header'] ) {
							$this->buildAd( 'header' );
						}
						$this->contentsToolbox(); ?>
						<div class="title">
							<h1>
								<?php $this->html( 'title' ); ?>
							</h1>
						</div>
						<div class="contentSub" <?php $this->html( 'userlangattributes' ); ?>>
							<?php $this->html( 'subtitle' ); ?>
						</div>
					</div>
					<div class="liberty-content-main" id="content">
						<?php if ( $this->data['newtalk'] ) { ?>
							<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
						<?php }
						if ( $this->data['catlinks'] ) {
							$this->html( 'catlinks' );
						}
						?>
						<article class="mw-body-content" id="mw-content-text">
							<?php $this->html( 'bodycontent' ); ?>
						</article>
						<?php
						if ( isset( $wgLibertyAdSetting['belowarticle'] ) && $wgLibertyAdSetting['belowarticle'] ) {
							$this->buildAd( 'belowarticle' );
						}
						?>
						</div>
					<footer>

						<div class="liberty-footer">
							<?php
							if ( $this->data['dataAfterContent'] ) {
								$this->html( 'dataAfterContent' );
							}
							?>
						<?php if ( isset( $wgLibertyAdSetting['bottom'] ) && $wgLibertyAdSetting['bottom'] ) {
							$this->buildAd( 'bottom' );
						}
						if (
							isset( $wgLibertyMobileReplaceAd ) && $wgLibertyMobileReplaceAd &&
							isset( $wgLibertyAdSetting['right'] ) && $wgLibertyAdSetting['right']
						) { ?>
							<div class="mobile-ads"></div>
						<?php } ?>
							<?php $this->footer(); ?>
						</div>
					</footer>
					<div id="liberty-bottombtn">
						<div class="scroll-button" id="liberty-scrollup"><i class="fas fa-angle-up"></i></div>
						<div class="scroll-button" id="liberty-scrolldown"><i class="fas fa-angle-down"></i></div>
					</div>
				</div>
			</div>
		</section>
		<?php
		// Only load AdSense JS is ads are enabled in site configuration
		if ( isset( $wgLibertyAdSetting['client'] ) && $wgLibertyAdSetting['client'] ) {
			// @codingStandardsIgnoreLine
			echo '<script async defer src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
		}
		?>
		<?php $this->loginModal(); ?>
	<?php
		$this->printTrail();
		$this->html( 'debughtml' );
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		echo "\n";
	}

	/**
	 * Nav menu function, build top menu.
	 */
	protected function navMenu() {
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();
		$skin = $this->getSkin();
	?>
		<nav class="navbar navbar-dark">
			<a class="navbar-brand" href="<?php echo Title::newMainPage()->getLocalURL(); ?>"></a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<?php echo $linkRenderer->makeKnownLink(
						new TitleValue( NS_SPECIAL, 'Recentchanges' ),
						// @codingStandardsIgnoreStart
						new HtmlArmor( '<span class="fas fa-sync"></span><span class="hide-title">' . $skin->msg( 'recentchanges' )->plain() . '</span>' ),
						// @codingStandardsIgnoreEnd )
						[
							'class' => 'nav-link',
							'title' => Linker::titleAttrib( 'n-recentchanges', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'n-recentchanges' )
						] );?>
				</li>
				<li class="nav-item">
					<?php echo $linkRenderer->makeKnownLink(
						new TitleValue( NS_SPECIAL, 'Randompage' ),
						// @codingStandardsIgnoreStart
						new HtmlArmor( '<span class="fa fa-random"></span><span class="hide-title">' . $skin->msg( 'randompage' )->plain() . '</span>' ),
						// @codingStandardsIgnoreEnd
						[
							'class' => 'nav-link',
							'title' => Linker::titleAttrib( 'n-randompage', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'n-randompage' )
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
		$skin = $this->getSkin();
	?>
		<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform" class="form-inline">
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ); ?>" />
			<div class="input-group">
				<?php echo $this->makeSearchInput( [ 'class' => 'form-control', 'id' => 'searchInput' ] ); ?>
				<span class="input-group-btn">
					<?php
					// @codingStandardsIgnoreStart 
					?>
					<button type="submit" name="go" value="<?php echo $skin->msg( 'go' )->escaped() ?>"id="searchGoButton" class="btn btn-secondary" type="button"><span class="fa fa-eye"></span></button>
					<button type="submit" name="fulltext" value="<?php echo $skin->msg( 'searchbutton' )->escaped() ?>"id="mw-searchButton" class="btn btn-secondary" type="button">
						<span class="fa fa-search"></span></button>
					<?php
					// @codingStandardsIgnoreEnd
					?>
				</span>
			</div>
		</form>
	<?php
	}

	/**
	 * Login box function, build top menu's login button.
	 */
	protected function loginBox() {
		global $wgLibertyUseGravatar;

		$skin = $this->getSkin();
		$user = $skin->getUser();
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();
	?>
		<div class="navbar-login">
			<?php
			// If the user is logged in...
			if ( $user->isRegistered() ) {
				$personalTools = $this->getPersonalTools();
				// ...and Gravatar is enabled in site config...
				if ( $wgLibertyUseGravatar ) {
					// ...and the user has a confirmed email...
					if ( $user->getEmailAuthenticationTimestamp() ) {
						// ...then, and only then, build the correct Gravatar URL
						$email = trim( $user->getEmail() );
						$email = strtolower( $email );
						$email = md5( $email ) . '?d=identicon';
					} else {
						$email = '00000000000000000000000000000000?d=identicon&f=y';
					}
					$avatar = Html::element( 'img', [
						'class' => 'profile-img',
						'src' => '//secure.gravatar.com/avatar/' . $email
					] );
				} else {
					$avatar = '';
				}

				// SocialProfile support
				if ( class_exists( 'wAvatar' ) ) {
					$avatar = new wAvatar( $user->getId(), 'm' );
					$avatar = $avatar->getAvatarURL( [
						'class' => 'profile-img'
					] );
				}
			?>
				<div class="dropdown login-menu">
					<a class="dropdown-toggle" type="button" id="login-menu" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $avatar; ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right login-dropdown-menu" 
						aria-labelledby="login-menu">
						<?php echo $linkRenderer->makeKnownLink(
							Title::makeTitle( NS_USER, $user->getName() ),
							$user->getName(),
							[
								'id' => 'pt-userpage',
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-userpage', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-userpage' )
							]
						); ?>
						<div class="dropdown-divider"></div>
						<?php
						if ( class_exists( 'EchoEvent' ) ) {
							$notiCount = 0;
							if (
								isset( $personalTools['notifications-alert'] ) &&
								$personalTools['notifications-alert'] &&
								isset( $personalTools['notifications-notice'] ) &&
								$personalTools['notifications-notice']
							) {
								$notiCount = $personalTools['notifications-alert']['links'][0]['data']['counter-num'] +
									$personalTools['notifications-notice']['links'][0]['data']['counter-num'];
							}
							echo $linkRenderer->makeKnownLink(
								new TitleValue( NS_SPECIAL, 'Notifications' ),
								$skin->msg( 'notifications' )->plain() . ( $notiCount ? " ($notiCount)" : '' ),
								[
									'class' => 'dropdown-item',
									'title' => $skin->msg( 'tooltip-pt-notifications-notice' )->text()
								]
							);
						}
						?>
						<?php echo $linkRenderer->makeKnownLink(
							SpecialPage::getTitleFor( 'Contributions', $user->getName() ),
							$skin->msg( 'mycontris' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-mycontris', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-mycontris' )
							]
						); ?>
						<?php echo $linkRenderer->makeKnownLink(
							Title::makeTitle( NS_USER_TALK, $user->getName() ),
							$skin->msg( 'mytalk' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-mytalk', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-mytalk' )
							]
						); ?>
						<?php echo $linkRenderer->makeKnownLink(
							SpecialPage::getTitleFor( 'Watchlist' ),
							$skin->msg( 'watchlist' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-watchlist', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-watchlist' )
							]
						); ?>
						<div class="dropdown-divider"></div>
						<?php echo $linkRenderer->makeKnownLink(
							SpecialPage::getTitleFor( 'Preferences' ),
							$skin->msg( 'preferences' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-preferences', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-preferences' )
							]
						); ?>
						<div class="dropdown-divider view-logout"></div>
						<a href="<?php echo $personalTools['logout']['links'][0]['href']; ?>" 
							class="dropdown-item view-logout" 
							title="<?php echo Linker::titleAttrib( 'pt-logout', 'withaccess' ); ?>">
							<?php echo $skin->msg( 'logout' )->escaped(); ?></a>
					</div>
				</div>
				<a href="<?php echo $personalTools['logout']['links'][0]['href']; ?>"
					class="hide-logout logout-btn" 
					title="<?php echo Linker::titleAttrib( 'pt-logout', 'withaccess' ); ?>">
					<span class="fa fa-sign-out"></span></a>
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
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();

		// Probably no point in rendering a login window for the users who are
		// already logged in?
		if ( $skin->getUser()->isRegistered() ) {
			return;
		}

		// Turn off Continuous Integration warnings about "too long" lines which are
		// perfectly acceptable in this particular context
		// @codingStandardsIgnoreStart
	?>
		<div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title"><?php echo $skin->msg( 'liberty-login' )->escaped() ?></h4>
					</div>
					<div class="modal-body">
						<div id="modal-login-alert" class="alert alert-hidden alert-danger" role="alert">
						</div>
						<form id="modal-loginform" name="userlogin" class="modal-loginform" method="post">
							<input class="loginText form-control" id="wpName1" tabindex="1" placeholder="<?php echo $skin->msg( 'userlogin-yourname-ph' )->escaped() ?>" value="" name="lgname">
							<label for="inputPassword" class="sr-only"><?php echo $skin->msg( 'userlogin-yourpassword' )->escaped() ?></label>
							<input class="loginPassword form-control" id="wpPassword1" tabindex="2" placeholder="<?php echo $skin->msg( 'userlogin-yourpassword-ph' )->escaped() ?>" type="password" name="lgpassword">
							<div class="modal-checkbox">
								<input name="lgremember" type="checkbox" value="1" id="lgremember" tabindex="3">
								<label for="lgremember"><?php echo $skin->msg( 'liberty-remember' )->escaped() ?></label>
							</div>
							<input class="btn btn-success btn-block" type="submit" value="<?php echo $skin->msg( 'liberty-login-btn' )->escaped() ?>" tabindex="4">
							<?php echo $linkRenderer->makeKnownLink(
								SpecialPage::getTitleFor( 'Userlogin' ),
								$skin->msg( 'userlogin-joinproject' ),
								[
									'class' => 'btn btn-primary btn-block',
									'tabindex' => 5,
									'type' => 'submit'
								],
								[
									'type' => 'signup',
									'returnto' => $title
								]
							); ?>
							<?php echo $linkRenderer->makeKnownLink(
								SpecialPage::getTitleFor( 'PasswordReset' ),
								$skin->msg( 'liberty-forgot-pw' )->plain()
							); ?>
							<br>
							<?php echo $linkRenderer->makeKnownLink(
								SpecialPage::getTitleFor( 'Userlogin' ),
								$skin->msg( 'liberty-login-alter' )->plain()
							); ?>
							<input type="hidden" name="action" value="login" />
							<input type="hidden" name="format" value="json" />
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $skin->msg( 'liberty-btn-close' )->escaped(); ?></button>
						<button type="button" class="btn btn-primary"><?php echo $skin->msg( 'liberty-btn-save-changes' )->escaped(); ?></button>
					</div>
				</div>
			</div>
		</div>
	<?php
		// Turn Continuous Integration stuff back on
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Live recent function, build right side's Recent menus.
	 */
	protected function liveRecent() {
		global $wgLibertyEnableLiveRC,
			$wgLibertyMaxRecent,
			$wgLibertyLiveRCArticleNamespaces,
			$wgLibertyLiveRCTalkNamespaces;

		// Don't bother outputting this if the live RC feature is disabled in
		// site configuration
		if ( !$wgLibertyEnableLiveRC ) {
			return;
		}

		$skin = $this->getSkin();
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();
		$articleNS = implode( '|', $wgLibertyLiveRCArticleNamespaces );
		$talkNS = implode( '|', $wgLibertyLiveRCTalkNamespaces );
	?>
		<div class="live-recent" data-article-ns="<?php echo $articleNS ?>" 
			data-talk-ns="<?php echo $talkNS ?>">
			<div class="live-recent-header">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="javascript:" class="nav-link active" id="liberty-recent-tab1">
							<?php echo $skin->msg( 'recentchanges' )->escaped() ?>
						</a>
					</li>
					<li class="nav-item">
						<a href="javascript:" class="nav-link" id="liberty-recent-tab2">
							<?php echo $skin->msg( 'liberty-recent-discussions' )->escaped() ?>
						</a>
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
				<?php echo $linkRenderer->makeKnownLink(
					SpecialPage::getTitleFor( 'Recentchanges' ),
					new HtmlArmor( '<span class="label label-info">' .
						$skin->msg( 'liberty-view-more' )->plain() .
						'</span>' )
				); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Contents tool box function, build article tool menu that will show at article title right.
	 */
	protected function contentsToolbox() {
		$skin = $this->getSkin();
		$user = $skin->getUser();
		$watchlistManager = MediaWikiServices::getInstance()->getWatchlistManager();
		$title = $skin->getTitle();
		$revid = $skin->getRequest()->getText( 'oldid' );
		$watched = $watchlistManager->isWatchedIgnoringRights( $user, $skin->getRelevantTitle() ) ? 'unwatch' : 'watch';
		$editable = isset( $this->data['content_navigation']['views']['edit'] );
		$action = $skin->getRequest()->getVal( 'action', 'view' );
		$permissionManager = MediaWikiServices::getInstance()->getPermissionManager();
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();
		if ( $title->getNamespace() != NS_SPECIAL ) {
			$companionTitle = $title->isTalkPage() ? $title->getSubjectPage() : $title->getTalkPage();
		?>
			<div class="content-tools">
				<div class="btn-group" role="group" aria-label="content-tools">
				<?php
				if ( $action != 'edit' ) {
					$editIcon = $editable ? '<i class="fa fa-edit"></i> ' : '<i class="fa fa-lock"></i> ';
					echo $linkRenderer->makeKnownLink(
						$title,
						new HtmlArmor( $editIcon . $skin->msg( 'edit' )->plain() ),
						[
							'class' => 'btn btn-secondary tools-btn',
							'id' => 'ca-edit',
							'title' => Linker::titleAttrib( 'ca-edit', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'ca-edit' )
						],
						$revid ? [ 'action' => 'edit', 'oldid' => $revid ] : [ 'action' => 'edit' ]
					);
				}
				if ( $action == 'edit' || $action == 'history' ) {
					echo $linkRenderer->makeKnownLink(
						$title,
						$titlename = $skin->msg( 'article' )->plain(),
						[
							'class' => 'btn btn-secondary tools-btn',
							'title' => Linker::titleAttrib( 'ca-nstab-main', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'ca-nstab-main' )
						]
					);
				}
					if ( $companionTitle && $action != 'edit' ) {
						if ( $title->isTalkPage() && $action != 'history' ) {
							$titlename = $skin->msg( 'nstab-main' )->plain();
							$additionalArrayStuff = [
								'title' => Linker::titleAttrib( 'ca-nstab-main', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-nstab-main' )
							];
						} else {
							$titlename = $skin->msg( 'talk' )->plain();
							$additionalArrayStuff = [
								'title' => Linker::titleAttrib( 'ca-talk', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-talk' )
							];
						}
						echo $linkRenderer->makeKnownLink(
							$companionTitle,
							$titlename,
							[
								'class' => 'btn btn-secondary tools-btn',
							] + $additionalArrayStuff
						);
					}
					if ( $action != 'history' ) {
						echo $linkRenderer->makeKnownLink(
							$title,
							$skin->msg( 'history' )->plain(),
							[
								'class' => 'btn btn-secondary tools-btn',
								'title' => Linker::titleAttrib( 'ca-history', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-history' )
							],
							[ 'action' => 'history' ]
						);
					}
					if ( $action == 'view' ) { ?>
						<button type="button" class="btn btn-secondary tools-btn tools-share">
							<i class="far fa-share-square"></i>
							<?php echo $skin->msg( 'liberty-share' )->escaped() ?>
						</button>
					<?php } ?>
					<?php
					// @codingStandardsIgnoreStart 
					?>
					<button type="button" class="btn btn-secondary tools-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<?php
					// @codingStandardsIgnoreEnd
					?>
					<div class="dropdown-menu dropdown-menu-right" role="menu">
						<?php
						if ( $title->inNamespaces( NS_USER, NS_USER_TALK ) ) {
							// "User contributions" link on user and user talk pages
							echo $linkRenderer->makeKnownLink(
								SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
								$skin->msg( 'contributions' )->escaped(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 't-contributions', 'withaccess' ),
									'accesskey' => Linker::accesskey( 't-contributions' )
								]
							);
						}
						echo $linkRenderer->makeKnownLink(
							$title,
							$skin->msg( 'liberty-purge' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => $skin->msg( 'liberty-tooltip-purge' )->plain() . ' [alt+shift+p]',
								'accesskey' => 'p'
							],
							[ 'action' => 'purge' ]
						);
						echo $linkRenderer->makeKnownLink(
							$title,
							$skin->msg( $watched )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'ca-' . $watched, 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-' . $watched )
							],
							[ 'action' => $watched ]
						);
						echo $linkRenderer->makeKnownLink(
							SpecialPage::getTitleFor( 'Whatlinkshere', $title ),
							$skin->msg( 'whatlinkshere' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 't-whatlinkshere', 'withaccess' ),
								'accesskey' => Linker::accesskey( 't-whatlinkshere' )
							]
						);
						echo $linkRenderer->makeKnownLink(
							$title,
							$skin->msg( 'liberty-info' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => $skin->msg( 'liberty-tooltip-info' )->plain(),
							],
							[ 'action' => 'info' ]
						);
						if ( $permissionManager->quickUserCan( 'move', $user, $title ) && $title->exists() ) {
							echo $linkRenderer->makeKnownLink(
								SpecialPage::getTitleFor( 'Movepage', $title ),
								$skin->msg( 'move' )->plain(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 'ca-move', 'withaccess' ),
									'accesskey' => Linker::accesskey( 'ca-move' )
								]
							);
						}
						if ( $permissionManager->quickUserCan( 'protect', $user, $title ) ) { ?>
							<div class="dropdown-divider"></div>
							<?php
							// different labels depending on whether the page is or isn't protected
							$protectionMsg = $title->isProtected() ? 'unprotect' : 'protect';
							echo $linkRenderer->makeKnownLink(
								$title,
								$skin->msg( $protectionMsg )->plain(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 'ca-' . $protectionMsg, 'withaccess' ),
									'accesskey' => Linker::accesskey( 'ca-' . $protectionMsg )
								],
								[ 'action' => 'protect' ]
							); ?>
						<?php } ?>
						<?php if ( $permissionManager->quickUserCan( 'delete', $user, $title ) && $title->exists() ) {
						?>
							<div class="dropdown-divider"></div>
							<?php echo $linkRenderer->makeKnownLink(
								$title,
								$skin->msg( 'delete' )->plain(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 'ca-delete', 'withaccess' ),
									'accesskey' => Linker::accesskey( 'ca-delete' )
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
		$footericons = $this->get( 'footericons' );
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
				<li class="designedbylibre">
					<a href="//librewiki.net">
						<?php // @codingStandardsIgnoreLine 
						?>
						<img src="<?php echo $this->getSkin()->getConfig()->get( 'StylePath' ); //phpcs:ignore 
									?>/Liberty/img/designedbylibre.png" style="height:31px" alt="Designed by Librewiki">
					</a>
				</li>
			</ul>
		<?php
		}
	}

	/**
	 * Get Notification function, build notification menu.
	 */
	protected function getNotification() {
		$personalTools = $this->getPersonalTools();
		if (
			isset( $personalTools['notifications-alert'] ) &&
			$personalTools['notifications-alert']['links'][0]['data']['counter-num']
		) {
			echo $this->makeListItem( 'notifications-alert', $personalTools['notifications-alert'] );
		}
		if (
			isset( $personalTools['notifications-notice'] ) &&
			$personalTools['notifications-notice']['links'][0]['data']['counter-num']
		) {
			echo $this->makeListItem( 'notifications-notice', $personalTools['notifications-notice'] );
		}
	}

	/**
	 * Render Portal function, build top menu contents.
	 *
	 * @param array $contents Menu data that will made by parseNavbar function.
	 */
	protected function renderPortal( $contents ) {
		$skin = $this->getSkin();
		$user = $skin->getUser();
		$userGroup = $user->getGroups();
		$userRights = MediaWikiServices::getInstance()->getPermissionManager()->getUserPermissions( $user );

		foreach ( $contents as $content ) {
			if ( !$content ) {
				break;
			}
			if (
				( $content['right'] && !in_array( $content['right'], $userRights ) ) ||
				( $content['group'] && !in_array( $content['group'], $userGroup ) )
			) {
				continue;
			}

			echo Html::openElement( 'li', [
				'class' => [ 'dropdown', 'nav-item' ]
			] );

			array_push( $content['classes'], 'nav-link' );

			if ( is_array( $content['children'] ) && count( $content['children'] ) > 1 ) {
				array_push( $content['classes'], 'dropdown-toggle', 'dropdown-toggle-fix' );
			}

			echo Html::openElement( 'a', [
				'class' => $content['classes'],
				'data-toggle' => is_array( $content['children'] ) &&
					count( $content['children'] ) > 1 ? 'dropdown' : '',
				'role' => 'button',
				'aria-haspopup' => 'true',
				'aria-expanded' => 'true',
				'title' => $content['title'],
				'href' => $content['href']
			] );

			if ( isset( $content['icon'] ) ) {
				echo Html::rawElement( 'span', [
					'class' => 'fa fa-' . $content['icon']
				] );
			}

			if ( isset( $content['text'] ) ) {
				echo Html::rawElement( 'span', [
					'class' => 'hide-title'
				], $content['text'] );
			}

			echo Html::closeElement( 'a' );

			if ( is_array( $content['children'] ) && count( $content['children'] ) ) {
				echo Html::openElement( 'div', [
					'class' => 'dropdown-menu',
					'role' => 'menu'
				] );

				foreach ( $content['children'] as $child ) {
					if (
						( $child['right'] && !in_array( $child['right'], $userRights ) ) ||
						( $child['group'] && !in_array( $child['group'], $userGroup ) )
					) {
						continue;
					}
					array_push( $child['classes'], 'dropdown-item' );

					if ( is_array( $child['children'] ) ) {
						array_push( $child['classes'], 'dropdown-toggle', 'dropdown-toggle-sub' );
					}

					echo Html::openElement( 'a', [
						'accesskey' => $child['access'],
						'class' => $child['classes'],
						'href' => $child['href'],
						'title' => $child['title']
					] );

					if ( isset( $child['icon'] ) ) {
						echo Html::rawElement( 'span', [
							'class' => 'fa fa-' . $child['icon']
						] );
					}

					if ( isset( $child['text'] ) ) {
						echo $child['text'];
					}

					echo Html::closeElement( 'a' );

					if (
						is_array( $content['children'] ) &&
						count( $content['children'] ) > 2 &&
						!empty( $child['children'] )
					) {
						echo Html::openElement( 'div', [
							'class' => 'dropdown-menu dropdown-submenu',
							'role' => 'menu'
						] );

						foreach ( $child['children'] as $sub ) {
							if (
								( $sub['right'] && !in_array( $sub['right'], $userRights ) ) ||
								( $sub['group'] && !in_array( $sub['group'], $userGroup ) )
							) {
								continue;
							}
							array_push( $sub['classes'], 'dropdown-item' );

							echo Html::openElement( 'a', [
								'accesskey' => $sub['access'],
								'class' => $sub['classes'],
								'href' => $sub['href'],
								'title' => $sub['title']
							] );

							if ( isset( $sub['icon'] ) ) {
								echo Html::rawElement( 'span', [
									'class' => 'fa fa-' . $sub['icon']
								] );
							}

							if ( isset( $sub['text'] ) ) {
								echo $sub['text'];
							}

							echo Html::closeElement( 'a' );
						}

						echo Html::closeElement( 'div' );
					}
				}

				echo Html::closeElement( 'div' );
			}

			echo Html::closeElement( 'li' );
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
		$userName = $this->getSkin()->getUser()->getName();
		$userLang = $this->getSkin()->getLanguage()->mCode;
		$globalData = ContentHandler::getContentText( WikiPage::factory(
			Title::newFromText( 'Liberty-Navbar', NS_MEDIAWIKI )
		)->getContent( RevisionRecord::RAW ) );
		$globalLangData = ContentHandler::getContentText( WikiPage::factory(
			Title::newFromText( 'Liberty-Navbar/' . $userLang, NS_MEDIAWIKI )
		)->getContent( RevisionRecord::RAW ) );
		$userData = ContentHandler::getContentText( WikiPage::factory(
			Title::newFromText( $userName . '/Liberty-Navbar', NS_USER )
		)->getContent( RevisionRecord::RAW ) );
		if ( !empty( $userData ) ) {
			$data = $userData;
		} elseif ( !empty( $globalLangData ) ) {
			$data = $globalLangData;
		} else {
			$data = $globalData;
		}
		// Well, [[MediaWiki:Liberty-Navbar]] *should* have some content, but
		// if it doesn't, bail out here so that we don't trigger E_NOTICEs
		// about undefined indexes later on
		if ( empty( $data ) ) {
			return $headings;
		}

		$lines = explode( "\n", $data );

		$types = [ 'icon', 'display', 'title', 'link', 'access', 'class' ];

		foreach ( $lines as $line ) {
			$line = rtrim( $line, "\r" );
			if ( $line[0] !== '*' ) {
				// Line does not start with '*'
				continue;
			}
			if ( $line[1] !== '*' ) {
				// First level menu
				$data = [];
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 1 );
				foreach ( $split as $key => $value ) {
					$valueArr = explode( '=', trim( $value ) );
					if ( isset( $valueArr[1] ) ) {
						$data[$valueArr[0]] = $valueArr[1];
					} else {
						$data[$types[$key]] = trim( $value );
					}
				}

				// Icon
				$icon = isset( $data['icon'] ) ? htmlentities( $data['icon'], ENT_QUOTES, 'UTF-8' ) : null;

				// Group
				$group = isset( $data['group'] ) ? htmlentities( $data['group'], ENT_QUOTES, 'UTF-8' ) : null;

				// Right
				$right = isset( $data['right'] ) ? htmlentities( $data['right'], ENT_QUOTES, 'UTF-8' ) : null;

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				if ( isset( $data['display'] ) ) {
					$textObj = wfMessage( $data['display'] );
					if ( $textObj->isDisabled() ) {
						$text = htmlentities( $data['display'], ENT_QUOTES, 'UTF-8' );
					} else {
						$text = $textObj->text();
					}
				} else {
					$text = '';
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $data['title'] ) ) {
					$titleObj = wfMessage( $data['title'] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $data['title'], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				// Link href
				if ( isset( $data['link'] ) ) {
					// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
					if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $data['link'] ) ) {
						$href = htmlentities( $data['link'], ENT_QUOTES, 'UTF-8' );
					} else {
						$href = str_replace( '%3A', ':', urlencode( $data['link'] ) );
						$href = str_replace( '$1', $href, $wgArticlePath );
					}
				} else {
					$href = null;
				}

				if ( isset( $data['access'] ) ) {
					// Access
					$access = preg_match( '/^([0-9a-z]{1})$/i', $data['access'] ) ? $data['access'] : '';
				} else {
					$access = null;
				}

				if ( isset( $data['class'] ) ) {
					// Classes
					$classes = explode( ',', htmlentities( $data['class'], ENT_QUOTES, 'UTF-8' ) );
					foreach ( $classes as $key => $value ) {
						$classes[$key] = trim( $value );
					}
				} else {
					$classes = [];
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title,
					'group' => $group,
					'right' => $right
				];
				$level2Children = &$item['children'];
				$headings[] = $item;
				continue;
			}
			if ( $line[2] !== '*' ) {
				// Second level menu
				$data = [];
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 2 );
				foreach ( $split as $key => $value ) {
					$valueArr = explode( '=', trim( $value ) );
					if ( isset( $valueArr[1] ) ) {
						$data[$valueArr[0]] = $valueArr[1];
					} else {
						$data[$types[$key]] = trim( $value );
					}
				}

				// Icon
				$icon = isset( $data['icon'] ) ? htmlentities( $data['icon'], ENT_QUOTES, 'UTF-8' ) : null;

				// Group
				$group = isset( $data['group'] ) ? htmlentities( $data['group'], ENT_QUOTES, 'UTF-8' ) : null;

				// Right
				$right = isset( $data['right'] ) ? htmlentities( $data['right'], ENT_QUOTES, 'UTF-8' ) : null;

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				if ( isset( $data['display'] ) ) {
					$textObj = wfMessage( $data['display'] );
					if ( $textObj->isDisabled() ) {
						$text = htmlentities( $data['display'], ENT_QUOTES, 'UTF-8' );
					} else {
						$text = $textObj->text();
					}
				} else {
					$text = '';
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $data['title'] ) ) {
					$titleObj = wfMessage( $data['title'] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $data['title'], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				if ( isset( $data['link'] ) ) {
					// Link href
					// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
					if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $data['link'] ) ) {
						$href = htmlentities( $data['link'], ENT_QUOTES, 'UTF-8' );
					} else {
						$href = str_replace( '%3A', ':', urlencode( $data['link'] ) );
						$href = str_replace( '$1', $href, $wgArticlePath );
					}
				}

				if ( isset( $data['access'] ) ) {
					// Access
					$access = preg_match( '/^([0-9a-z]{1})$/i', $data['access'] ) ? $data['access'] : '';
				} else {
					$access = null;
				}

				if ( isset( $data['class'] ) ) {
					// Classes
					$classes = explode( ',', htmlentities( $data['class'], ENT_QUOTES, 'UTF-8' ) );
					foreach ( $classes as $key => $value ) {
						$classes[$key] = trim( $value );
					}
				} else {
					$classes = [];
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title,
					'group' => $group,
					'right' => $right
				];
				$level3Children = &$item['children'];
				$level2Children[] = $item;
				continue;
			}
			if ( $line[3] !== '*' ) {
				// Third level menu
				$data = [];
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 3 );
				foreach ( $split as $key => $value ) {
					$valueArr = explode( '=', trim( $value ) );
					if ( isset( $valueArr[1] ) ) {
						$data[$valueArr[0]] = $valueArr[1];
					} else {
						$data[$types[$key]] = trim( $value );
					}
				}

				// Icon
				$icon = isset( $data['icon'] ) ? htmlentities( $data['icon'], ENT_QUOTES, 'UTF-8' ) : null;

				// Group
				$group = isset( $data['group'] ) ? htmlentities( $data['group'], ENT_QUOTES, 'UTF-8' ) : null;

				// Right
				$right = isset( $data['right'] ) ? htmlentities( $data['right'], ENT_QUOTES, 'UTF-8' ) : null;

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				if ( isset( $data['display'] ) ) {
					$textObj = wfMessage( $data['display'] );
					if ( $textObj->isDisabled() ) {
						$text = htmlentities( $data['display'], ENT_QUOTES, 'UTF-8' );
					} else {
						$text = $textObj->text();
					}
				} else {
					$text = "";
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $data['title'] ) ) {
					$titleObj = wfMessage( $data['title'] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $data['title'], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				// Link href
				// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
				if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $data['link'] ) ) {
					$href = htmlentities( $data['link'], ENT_QUOTES, 'UTF-8' );
				} else {
					$href = str_replace( '%3A', ':', urlencode( $data['link'] ) );
					$href = str_replace( '$1', $href, $wgArticlePath );
				}

				// Access
				if ( isset( $data['access'] ) ) {
					$access = preg_match( '/^([0-9a-z]{1})$/i', $data['access'] ) ? $data['access'] : '';
				} else {
					$access = null;
				}

				if ( isset( $data['class'] ) ) {
					// Classes
					$classes = explode( ',', htmlentities( $data['class'], ENT_QUOTES, 'UTF-8' ) );
					foreach ( $classes as $key => $value ) {
						$classes[$key] = trim( $value );
					}
				} else {
					$classes = [];
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title,
					'group' => $group,
					'right' => $right
				];
				$level3Children[] = $item;
				continue;
			} else {
				// Not supported
				continue;
			}
		}

		return $headings;
	}

	/**
	 * Build an AdSense ad unit wrapped in a div tag.
	 *
	 * @param string $position Ad position
	 */
	protected function buildAd( $position ) {
		global $wgLibertyAdSetting;

		$adFormat = 'auto';
		$fullWidthResponsive = 'true';
		if ( $position === 'header' ) {
			$adFormat = 'horizontal';
			$fullWidthResponsive = 'false';
		}
		?>
		<div class="<?php echo $position; ?>-ads">
			<ins class="adsbygoogle" 
				data-full-width-responsive="<?php echo $fullWidthResponsive; ?>" 
				data-ad-client="<?php echo $wgLibertyAdSetting['client']; ?>" 
				data-ad-slot="<?php echo $wgLibertyAdSetting[$position]; ?>"
				data-ad-format="<?php echo $adFormat; ?>">
			</ins>
		</div>
<?php
	}
}
