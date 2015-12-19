<?php
class LibertyTemplate extends BaseTemplate {
	function execute() {
		// Suppress warnings to prevent notices about missing indexes in $this->data
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
            </div>
            <div class="container-fluid liberty-content">
                <i class="fa fa-car"></i>
                <?php
                echo SpecialPage::getTitleFor('Userlogin')
                ?>
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
                <a class="navbar-brand" href="#"></a>
            </div>
            <div class="navgation">
                <ul class="nav navbar-nav">
                    <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Recentchanges', null ), '<span class="fa fa-refresh"></span><span class="hide-title">최근바뀜</span>', array( 'class' => 'nav-link', 'title' => '최근 변경 문서를 불러옵니다. [alt+shift+r]', 'accesskey' => 'r') ); ?></li>
                    <li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Randompage', null ), '<span class="fa fa-random"></span><span class="hide-title">임의문서</span>', array( 'class' => 'nav-link', 'title' => '임의 문서를 불러옵니다. [alt+shift+x]', 'accesskey' => 'x' ) ); ?></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/wiki"><span class="fa fa-leaf"></span><span class="hide-title">위키방</span></a></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/anon"><span class="fa fa-users"></span><span class="hide-title">익명방</span></a></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/anon"><span class="fa fa-gear"></span><span class="hide-title">도구</span></a></li>
                    <li><a class="nav-link" href="https://bbs.librewiki.net/anon"><span class="fa fa-book"></span><span class="hide-title">도움말</span></a></li>
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
	    global $wgUser;
	    ?>
	    <div class="dropdown nav-login">
            <?php
            if ($wgUser->isLoggedIn()) {
            ?>
                <a id="drop1" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                    로그인<span class="caret"></span>
                </a>
                <?php
            } else {
            ?>
                <a href="#" class="none-outline" data-toggle="modal" data-target="#loginform">
                    <span class="fa fa-sign-in"></span>
                </a>
            <?php
            }
            ?>
            <?php
                if ($wgUser->isLoggedIn()) {
            ?>
            <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Another action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Something else here</a></li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="https://twitter.com/fat">Separated link</a></li>
            </ul>
            <?php
            } else {
            ?>
            <div class="modal fade modal-login" id="loginform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">로그인</h4>
                        </div>
                        <div class="modal-body">
                            <form name="userlogin" class="modal-loginform" method="post" action="/index.php?title=<?=SpecialPage::getTitleFor( 'UserLogin', null ); ?>&amp;action=submitlogin&amp;type=login&amp;returnto=<?php $this->html( 'title' ); ?>">
                                <input class="loginText form-control" id="wpName1" tabindex="1" placeholder="사용자 계정 이름을 입력하세요" value="" name="wpName" autofocus="">
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input class="loginPassword form-control" id="wpPassword1" tabindex="2" autofocus="" placeholder="비밀번호를 입력하세요" type="password" name="wpPassword">
                                <div class="modal-checkbox">
                                    <input name="wpRemember" type="checkbox" value="1" id="wpRemember" tabindex="3">
                                    <label for="wpRemember">로그인 상태를 유지하기</label>
                                </div>
                                <button class="btn btn-lg btn-success btn-block" type="submit" tabindex="4">로그인</button>
                                <a href="/index.php?title=<?=SpecialPage::getTitleFor( 'UserLogin', null ); ?>&amp;type=signup&amp;returnto=<?php $this->html( 'title' ); ?>" tabindex="5" class="btn btn-lg btn-primary btn-block" type="submit"><?php $this->msg( 'userlogin-joinproject' ); ?></a>
                                <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'PasswordReset', null ), '비밀번호를 잊으셨나요?', array() ); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
	    </div>
	    <?php
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