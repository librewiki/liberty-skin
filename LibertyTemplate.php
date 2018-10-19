<?php // @codingStandardsIgnoreLine
class LibertyTemplate extends BaseTemplate {
	/**
	 * execute() Method
	 */
	public function execute() {
		global $wgLibertyAdSetting;

		$skin = $this->getSkin();
		$request = $skin->getRequest();
		$action = $request->getVal( 'action', 'view' );
		$title = $skin->getTitle();

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
							   !$request->getCookie( 'disable-notice' ) ) { ?>
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
					<?php
					// @codingStandardsIgnoreStart
					if ( $title->getNamespace() != NS_SPECIAL &&
							   $action != 'edit' && $action != 'history' ) { ?>
						<div class="social-buttons">
							<div class="twitter" data-text="<?php echo htmlspecialchars( $title, ENT_QUOTES ); ?>" title="<?php echo $skin->msg( 'liberty-twitter' )->escaped() ?>">
								<div><i class="fa fa-twitter"></i></div>
							</div>
							<div class="facebook" data-text="<?php echo htmlspecialchars( $title, ENT_QUOTES ); ?>" title="<?php echo $skin->msg( 'liberty-facebook' )->escaped() ?>">
								<div><i class="fa fa-facebook"></i></div>
							</div>
						</div>
					<?php
					}
					// @codingStandardsIgnoreEnd

					if ( $this->data['catlinks'] ) {
						$this->html( 'catlinks' );
					}
					?>
					<article class="mw-body-content">
						<?php $this->html( 'bodycontent' ); ?>
					</article>
					<?php
					if ( $this->data['dataAfterContent'] ) {
						$this->html( 'dataAfterContent' );
					}
					?>
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
	}

	/**
	 * Nav menu function, build top menu.
	 */
	protected function navMenu() {
		$skin = $this->getSkin();
		?>
		<nav class="navbar navbar-dark">
			<a class="navbar-brand" href="<?php echo Title::newMainPage()->getLocalURL(); ?>"></a>
			<ul class="nav navbar-nav">
				<li class="nav-item">
					<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'Recentchanges' ),
						// @codingStandardsIgnoreStart
						'<span class="fa fa-refresh"></span><span class="hide-title">' . $skin->msg( 'recentchanges' )->plain() . '</span>',
						// @codingStandardsIgnoreEnd
						[
							'class' => 'nav-link',
							'title' => Linker::titleAttrib( 'n-recentchanges', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'n-recentchanges' )
						]
					); ?>
				</li>
				<li class="nav-item">
					<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'Randompage' ),
						// @codingStandardsIgnoreStart
						'<span class="fa fa-random"></span><span class="hide-title">' . $skin->msg( 'randompage' )->plain() . '</span>',
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
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ); ?>"/>
			<div class="input-group">
				<?php echo $this->makeSearchInput( [ 'class' => 'form-control', 'id' => 'searchInput' ] ); ?>
				<span class="input-group-btn">
					<button type="submit" name="go"
						value="<?php echo $skin->msg( 'go' )->plain() ?>" id="searchGoButton"
							class="btn btn-secondary" type="button"><span class="fa fa-eye"></span></button>
					<button type="submit" name="fulltext"
						value="<?php echo $skin->msg( 'searchbutton' )->plain() ?>"
						id="mw-searchButton" class="btn btn-secondary" type="button">
						<span class="fa fa-search"></span></button>
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
		?>
		<div class="navbar-login">
			<?php
			// If the user is logged in...
			if ( $user->isLoggedIn() ) {
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
						<?php echo Linker::linkKnown(
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
							$personalTools = $this->getPersonalTools();
							$notiCount = 0;
							if (
								isset( $personalTools['notifications-alert'] ) &&
								$personalTools['notifications-alert'] &&
								isset( $personalTools['notifications-message'] ) &&
								$personalTools['notifications-message']
							) {
								$notiCount = $personalTools['notifications-alert']['links'][0]['text'] +
											$personalTools['notifications-message']['links'][0]['text'];
							}
							echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'Notifications' ),
								$skin->msg( 'notifications' )->plain().( $notiCount ?  " ($notiCount)" : "" ),
								[
									'class' => 'dropdown-item',
									'title' => $skin->msg( 'tooltip-pt-notifications-notice' )->text()
								]
							);
						}
						?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'Contributions', $user->getName() ),
							$skin->msg( 'mycontris' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-mycontris', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-mycontris' )
							]
						); ?>
						<?php echo Linker::linkKnown(
							Title::makeTitle( NS_USER_TALK, $user->getName() ),
							$skin->msg( 'mytalk' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-mytalk', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-mytalk' )
							]
						); ?>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'Watchlist' ),
							$skin->msg( 'watchlist' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-watchlist', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-watchlist' )
							]
						); ?>
						<div class="dropdown-divider"></div>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'Preferences' ),
							$skin->msg( 'preferences' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'pt-preferences', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-preferences' )
							]
						); ?>
						<div class="dropdown-divider view-logout"></div>
						<?php echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'UserLogout' ),
							$skin->msg( 'logout' )->plain(),
							[
								'class' => 'dropdown-item view-logout',
								'title' => Linker::titleAttrib( 'pt-logout', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'pt-logout' )
							]
						); ?>
					</div>
				</div>
				<?php echo Linker::linkKnown(
						SpecialPage::getTitleFor( 'UserLogout' ),
						'<span class="fa fa-sign-out"></span>',
						[
							'class' => 'hide-logout logout-btn',
							'title' => Linker::titleAttrib( 'pt-logout', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'pt-logout' )
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

		// Turn off Continuous Integration warnings about "too long" lines which are
		// perfectly acceptable in this particular context
		// @codingStandardsIgnoreStart
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
                            <br>
							<?php echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'login' ),
								$skin->msg( 'liberty-login-alter' )->plain()
							); ?>
							<input type="hidden" name="action" value="login" />
							<input type="hidden" name="format" value="json" />
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $skin->msg( 'liberty-btn-close' )->plain(); ?></button>
						<button type="button" class="btn btn-primary"><?php echo $skin->msg( 'liberty-btn-save-changes' )->plain(); ?></button>
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
		global $wgLibertyEnableLiveRC;

		$skin = $this->getSkin();
		$wgLibertyMaxRecent = isset( $GLOBALS['wgLibertyMaxRecent'] ) ?
							  $GLOBALS['wgLibertyMaxRecent'] : 10;

		// Don't bother outputting this if the live RC feature is disabled in
		// site configuration
		if ( !$wgLibertyEnableLiveRC ) {
			return;
		}
		?>
		<div class="live-recent">
			<div class="live-recent-header">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="javascript:" class="nav-link active" id="liberty-recent-tab1">
						<?php echo $skin->msg( 'recentchanges' )->plain() ?>
					</a>
				</li>
				<li class="nav-item">
					<a href="javascript:" class="nav-link" id="liberty-recent-tab2">
						<?php echo $skin->msg( 'liberty-recent-discussions' )->plain() ?>
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
				<?php echo Linker::linkKnown(
					SpecialPage::getTitleFor( 'Recentchanges' ),
					'<span class="label label-info">' .
						$skin->msg( 'liberty-view-more' )->plain() .
					'</span>'
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
		$title = $skin->getTitle();
		$revid = $skin->getRequest()->getText( 'oldid' );
		$watched = $user->isWatched( $skin->getRelevantTitle() ) ? 'unwatch' : 'watch';

		if ( $title->getNamespace() != NS_SPECIAL ) {
			$companionTitle = $title->isTalkPage() ? $title->getSubjectPage() : $title->getTalkPage();
			?>
			<div class="content-tools">
				<div class="btn-group" role="group" aria-label="content-tools">
					<?php echo Linker::linkKnown(
						$title,
						$skin->msg( 'liberty-purge' )->plain(),
						[
							'class' => 'btn btn-secondary tools-btn',
							'title' => $skin->msg( 'liberty-tooltip-purge' )->plain() . ' [alt+shift+p]',
							'accesskey' => 'p'
						],
						[ 'action' => 'purge' ]
					);
					echo Linker::linkKnown(
						$title,
						$skin->msg( 'edit' )->plain(),
						[
							'class' => 'btn btn-secondary tools-btn',
							'title' => Linker::titleAttrib( 'ca-edit', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'ca-edit' )
						],
						$revid ? [ 'action' => 'edit', 'oldid' => $revid ] : [ 'action' => 'edit' ]
					);
					echo Linker::linkKnown(
						$title,
						$skin->msg( 'addsection' )->plain(),
						[
							'class' => 'btn btn-secondary tools-btn',
							'title' => Linker::titleAttrib( 'ca-addsection', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'ca-addsection' )
						],
						[ 'action' => 'edit', 'section' => 'new' ]
					);
					if ( $companionTitle ) {
						if ( $title->isTalkPage() ) {
							$titlename = $skin->msg( 'articlepage' )->plain();
							$additionalArrayStuff = [
								// @todo FIXME!
								'title' => $titlename . '을 불러옵니다. [alt+shift+t]',
								'accesskey' => 't'
							];
						} else {
							$titlename = $skin->msg( 'talk' )->plain();
							$additionalArrayStuff = [
								'title' => Linker::titleAttrib( 'ca-talk', 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-talk' )
							];
						}
						echo Linker::linkKnown(
							$companionTitle,
							$titlename,
							[
								'class' => 'btn btn-secondary tools-btn',
							] + $additionalArrayStuff
						);
					}
					echo Linker::linkKnown(
						$title,
						$skin->msg( 'history' )->plain(),
						[
							'class' => 'btn btn-secondary tools-btn',
							'title' => Linker::titleAttrib( 'ca-history', 'withaccess' ),
							'accesskey' => Linker::accesskey( 'ca-history' )
						],
						[ 'action' => 'history' ]
					); ?>
					<button type="button" class="btn btn-secondary tools-btn dropdown-toggle"
							data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<div class="dropdown-menu dropdown-menu-right" role="menu">
						<?php
						if ( $title->inNamespaces( NS_USER, NS_USER_TALK ) ) {
							// "User contributions" link on user and user talk pages
							echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
								$skin->msg( 'contributions' )->escaped(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 't-contributions', 'withaccess' ),
									'accesskey' => Linker::accesskey( 't-contributions' )
								]
							);
						}
						echo Linker::linkKnown(
							$title,
							$skin->msg( $watched )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 'ca-' . $watched, 'withaccess' ),
								'accesskey' => Linker::accesskey( 'ca-' . $watched )
							],
							[ 'action' => $watched ]
						);
						echo Linker::linkKnown(
							SpecialPage::getTitleFor( 'WhatLinksHere', $title ),
							$skin->msg( 'whatlinkshere' )->plain(),
							[
								'class' => 'dropdown-item',
								'title' => Linker::titleAttrib( 't-whatlinkshere', 'withaccess' ),
								'accesskey' => Linker::accesskey( 't-whatlinkshere' )
							]
						);
						if ( $title->quickUserCan( 'move', $user ) && $title->exists() ) {
							echo Linker::linkKnown(
								SpecialPage::getTitleFor( 'Movepage', $title ),
								$skin->msg( 'move' )->plain(),
								[
									'class' => 'dropdown-item',
									'title' => Linker::titleAttrib( 'ca-move', 'withaccess' ),
									'accesskey' => Linker::accesskey( 'ca-move' )
								]
							);
						}
						if ( $title->quickUserCan( 'protect', $user ) ) { ?>
							<div class="dropdown-divider"></div>
							<?php
							// different labels depending on whether the page is or isn't protected
							$protectionMsg = $title->isProtected() ? 'unprotect' : 'protect';
							echo Linker::linkKnown(
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
						<?php if ( $title->quickUserCan( 'delete', $user ) && $title->exists() ) { ?>
							<div class="dropdown-divider"></div>
							<?php echo Linker::linkKnown(
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
		$notiCount = 0;
		if (
			isset( $personalTools['notifications-alert'] ) &&
			$personalTools['notifications-alert'] &&
			isset( $personalTools['notifications-message'] ) &&
			$personalTools['notifications-message']
		) {
			$notiCount = $personalTools['notifications-alert']['links'][0]['text'] +
						 $personalTools['notifications-message']['links'][0]['text'];
		}
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
	 * @param array $contents Menu data that will made by parseNavbar function.
	 */
	protected function renderPortal( $contents ) {
		foreach ( $contents as $content ) {
			if ( !$content ) {
				break;
			}

			echo Html::openElement( 'li', [
				'class' => [ 'dropdown', 'nav-item' ]
			] );
				array_push( $content['classes'], 'nav-link' );
				if ( is_array( $content['children'] ) && count( $content['children'] ) ) {
					array_push( $content['classes'], 'dropdown-toggle', 'dropdown-toggle-fix' );
				}

				echo Html::openElement( 'a', [
					'class' => $content['classes'],
					'data-toggle' => 'dropdown',
					'role' => 'button',
					'aria-haspopup' => 'true',
					'aria-expanded' => 'true',
					'title' => $content['title']
				] );
					if ( isset( $content['icon'] ) ) {
						echo Html::rawElement( 'span', [
							'class' => 'fa fa-'.$content['icon']
						] );
					}

					if ( isset( $content['text'] ) ) {
						echo Html::rawElement( 'span', [
							'class' => 'hide-title'
						], $content['text'] );
					}
				echo Html::closeElement( 'a' );

				if ( is_array( $content['children'] ) && count( $content['children'] ) ) {
					// We should fix this
					array_shift( $content['children'] );
					echo Html::openElement( 'div', [
						'class' => 'dropdown-menu',
						'role' => 'menu'
					] );
						foreach ( $content['children'] as $child ) {
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
										'class' => 'fa fa-'.$child['icon']
									] );
								}

								if ( isset( $child['text'] ) ) {
									echo $child['text'];
								}
							echo Html::closeElement( 'a' );

							if ( is_array( $content['children'] ) && count( $content['children'] ) > 2 ) {
								echo Html::openElement( 'div', [
									'class' => 'dropdown-menu dropdown-submenu',
									'role' => 'menu'
								] );
								foreach ( $child['children'] as $sub ) {
									array_push( $sub['classes'], 'dropdown-item' );
									echo Html::openElement( 'a', [
										'accesskey' => $sub['access'],
										'class' => $sub['classes'],
										'href' => $sub['href'],
										'title' => $sub['title']
									] );
										if ( isset( $sub['icon'] ) ) {
											echo Html::rawElement( 'span', [
												'class' => 'fa fa-'.$sub['icon']
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
				// First level menu
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 1 );
				foreach ( $split as $key => $value ) {
					$split[$key] = trim( $value );
				}

				// Icon
				$icon = htmlentities( $split[0], ENT_QUOTES, 'UTF-8' );

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				$textObj = wfMessage( $split[1] );
				if ( $textObj->isDisabled() ) {
					$text = htmlentities( $split[1], ENT_QUOTES, 'UTF-8' );
				} else {
					$text = $textObj->text();
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $split[2] ) ) {
					$titleObj = wfMessage( $split[2] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $split[2], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				// Link href
				// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
				if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $split[3] ) ) {
					$href = htmlentities( $split[3], ENT_QUOTES, 'UTF-8' );
				} else {
					$href = str_replace( '%3A', ':', urlencode( $split[3] ) );
					$href = str_replace( '$1', $href, $wgArticlePath );
				}

				// Access
				$access = preg_match( '/^([0-9a-z]{1})$/i', $split[4] ) ? $split[4] : '';

				// Classes
				$classes = explode( ',', htmlentities( $split[5], ENT_QUOTES, 'UTF-8' ) );
				foreach ( $classes as $key => $value ) {
					$classes[$key] = trim( $value );
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title
				];
				$level2Children = &$item['children'];
				$headings[] = $item;
			}
			if ( $line[2] !== '*' ) {
				// Second level menu
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 2 );
				foreach ( $split as $key => $value ) {
					$split[$key] = trim( $value );
				}

				// Icon
				$icon = htmlentities( $split[0], ENT_QUOTES, 'UTF-8' );

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				$textObj = wfMessage( $split[1] );
				if ( $textObj->isDisabled() ) {
					$text = htmlentities( $split[1], ENT_QUOTES, 'UTF-8' );
				} else {
					$text = $textObj->text();
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $split[2] ) ) {
					$titleObj = wfMessage( $split[2] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $split[2], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				// Link href
				// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
				if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $split[3] ) ) {
					$href = htmlentities( $split[3], ENT_QUOTES, 'UTF-8' );
				} else {
					$href = str_replace( '%3A', ':', urlencode( $split[3] ) );
					$href = str_replace( '$1', $href, $wgArticlePath );
				}

				// Access
				$access = preg_match( '/^([0-9a-z]{1})$/i', $split[4] ) ? $split[4] : '';

				// Classes
				$classes = explode( ',', htmlentities( $split[5], ENT_QUOTES, 'UTF-8' ) );
				foreach ( $classes as $key => $value ) {
					$classes[$key] = trim( $value );
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title
				];
				$level3Children = &$item['children'];
				$level2Children[] = $item;
			} else {
				// Third level menu
				$split = explode( '|', $line );
				$split[0] = substr( $split[0], 3 );
				foreach ( $split as $key => $value ) {
					$split[$key] = trim( $value );
				}

				// Icon
				$icon = htmlentities( $split[0], ENT_QUOTES, 'UTF-8' );

				// support the usual [[MediaWiki:Sidebar]] syntax of
				// ** link target|<some MW: message name> and if the
				// thing on the right side of the pipe isn't the name of a MW:
				// message, then and _only_ then render it as-is
				$textObj = wfMessage( $split[1] );
				if ( $textObj->isDisabled() ) {
					$text = htmlentities( $split[1], ENT_QUOTES, 'UTF-8' );
				} else {
					$text = $textObj->text();
				}

				// If icon and text both empty
				if ( empty( $icon ) && empty( $text ) ) {
					continue;
				}

				// Title
				if ( isset( $split[2] ) ) {
					$titleObj = wfMessage( $split[2] );
					if ( $titleObj->isDisabled() ) {
						$title = htmlentities( $split[2], ENT_QUOTES, 'UTF-8' );
					} else {
						$title = $titleObj->text();
					}
				} else {
					$title = $text;
				}

				// Link href
				// @todo CHECKME: Should this use wfUrlProtocols() or somesuch instead?
				if ( preg_match( '/^((?:(?:http(?:s)?)?:)?\/\/(?:.{4,}))$/i', $split[3] ) ) {
					$href = htmlentities( $split[3], ENT_QUOTES, 'UTF-8' );
				} else {
					$href = str_replace( '%3A', ':', urlencode( $split[3] ) );
					$href = str_replace( '$1', $href, $wgArticlePath );
				}

				// Access
				$access = preg_match( '/^([0-9a-z]{1})$/i', $split[4] ) ? $split[4] : '';

				// Classes
				$classes = explode( ',', htmlentities( $split[5], ENT_QUOTES, 'UTF-8' ) );
				foreach ( $classes as $key => $value ) {
					$classes[$key] = trim( $value );
				}

				$item = [
					'access' => $access,
					'classes' => $classes,
					'href' => $href,
					'icon' => $icon,
					'text' => $text,
					'title' => $title
				];
				$level3Children[] = $item;
			}
		}

		return $headings;
	}

	/**
	 * Build Adsense Function.
	 * @param string $position Ad position
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
