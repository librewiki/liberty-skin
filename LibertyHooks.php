<?php //phpcs:ignore
class LibertyHooks extends Hooks {
	/**
	 * @since 1.17.0
	 * @param OutputPage $out
	 * @param Skin $sk
	 * @param array &$bodyAttrs
	 */
	public static function onOutputPageBodyAttributes( OutputPage $out, Skin $sk, &$bodyAttrs ) {
		if ( $sk->getSkinName() === 'liberty' ) {
			$bodyAttrs['class'] .= ' Liberty width-size';
		}
	}

	/**
	 * Set up user preferences specific to the Liberty skin.
	 *
	 * @param User $user user
	 * @param Preferences &$preferences preferences
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		global $wgLibertyAdSetting, $wgLibertyAdGroup;

		$service = MediaWiki\MediaWikiServices::getInstance();
		$userGroupManager = $service->getUserGroupManager();
		$userGroups = $userGroupManager->getUserGroups( $user );
		$permissionManager = $service->getPermissionManager();

		$preferences['liberty-layout-width'] = [
			'type' => 'select',
			'label-message' => 'liberty-pref-layout-width',
			'section' => 'liberty/layout',
			'options' => [
				wfMessage( 'liberty-layout-select-1000' )->text() => '1000px',
				wfMessage( 'liberty-layout-select-1100' )->text() => '1100px',
				wfMessage( 'liberty-layout-select-1200' )->text() => null,
				wfMessage( 'liberty-layout-select-1300' )->text() => '1300px',
				wfMessage( 'liberty-layout-select-1400' )->text() => '1400px',
				wfMessage( 'liberty-layout-select-1500' )->text() => '1500px',
				wfMessage( 'liberty-layout-select-1600' )->text() => '1600px',
			],
			'help-message' => 'liberty-pref-layout-width-help',
			'default' => null
		];

		$preferences['liberty-layout-navfix'] = [
			'type' => 'toggle',
			'label-message' => 'liberty-pref-layout-navfix',
			'section' => 'liberty/layout',
		];

		$preferences['liberty-layout-sidebar'] = [
			'type' => 'toggle',
			'label-message' => 'liberty-pref-layout-sidebar',
			'section' => 'liberty/layout',
		];

		$preferences['liberty-layout-controlbar'] = [
			'type' => 'toggle',
			'label-message' => 'liberty-pref-layout-controlbar',
			'section' => 'liberty/layout',
		];

		if (
			isset( $wgLibertyAdSetting['client'] ) && $wgLibertyAdSetting['client'] &&
			isset( $wgLibertyAdGroup ) && $wgLibertyAdGroup == 'differ'
		) {
			if (
				isset( $wgLibertyAdSetting['belowarticle'] ) && $wgLibertyAdSetting['belowarticle'] &&
				$permissionManager->userHasRight( $user, 'blockads-belowarticle' )
			) {
				$preferences['liberty-ads-morearticle'] = [
					'type' => 'toggle',
					'label-message' => 'liberty-pref-ads-belowarticle',
					'section' => 'liberty/ads',
				];
			}

			if (
				isset( $wgLibertyAdSetting['header'] ) && $wgLibertyAdSetting['header'] &&
				$permissionManager->userHasRight( $user, 'blockads-header' )
			) {
				$preferences['liberty-ads-header'] = [
					'type' => 'toggle',
					'label-message' => 'liberty-pref-ads-header',
					'section' => 'liberty/ads',
				];
			}

			if (
				isset( $wgLibertyAdSetting['right'] ) && $wgLibertyAdSetting['right'] &&
				$permissionManager->userHasRight( $user, 'blockads-right' )
			) {
				$preferences['liberty-ads-rightads'] = [
					'type' => 'toggle',
					'label-message' => 'liberty-pref-ads-right',
					'section' => 'liberty/ads',
				];
			}

			if (
				isset( $wgLibertyAdSetting['bottom'] ) && $wgLibertyAdSetting['bottom'] &&
				$permissionManager->userHasRight( $user, 'blockads-bottom' )
			) {
				$preferences['liberty-ads-bottom'] = [
					'type' => 'toggle',
					'label-message' => 'liberty-pref-ads-bottom',
					'section' => 'liberty/ads',
				];
			}
		}

		$preferences['liberty-color-main'] = [
			'type' => 'text',
			'label-message' => 'liberty-pref-color-main',
			'section' => 'liberty/color',
			'help-message' => 'liberty-pref-color-main-help'
		];

		$preferences['liberty-color-second'] = [
			'type' => 'text',
			'label-message' => 'liberty-pref-color-second',
			'section' => 'liberty/color',
			'help-message' => 'liberty-pref-color-second-help'
		];

		$preferences['liberty-font'] = [
			'type' => 'selectorother',
			'label-message' => 'liberty-pref-fonts',
			'section' => 'liberty/font',
			'options' => [
				wfMessage( 'liberty-font-name-default' )->text() => null,
				wfMessage( 'liberty-font-name-noto-sans-kr' )->text() => 'Noto Sans KR',
				wfMessage( 'liberty-font-name-noto-serif-kr' )->text() => 'Noto Serif KR',
				wfMessage( 'liberty-font-name-spoqa-han-sans' )->text() => 'Spoqa Han Sans',
				wfMessage( 'liberty-font-name-nanum-gothic' )->text() => 'Nanum Gothic',
				wfMessage( 'liberty-font-name-nanum-myeongjo' )->text() => 'Nanum Myeongjo',
				wfMessage( 'liberty-font-name-dokdo' )->text() => 'Dokdo',
				wfMessage( 'liberty-font-name-gaegu' )->text() => 'Gaegu',
				wfMessage( 'liberty-font-name-hankc' )->text() => 'Hankc',
				wfMessage( 'liberty-font-name-youth' )->text() => 'Youth',
				wfMessage( 'liberty-font-name-malgun-gothic' )->text() => 'Malgun Gothic'
			],
			'help-message' => 'liberty-pref-fonts-help',
			'default' => null,
		];

		$preferences['liberty-dark'] = [
			'type' => 'select',
			'label-message' => 'liberty-pref-dark',
			'section' => 'liberty/color',
			'options' => [
				wfMessage( 'liberty-dark-default' )->text() => null,
				wfMessage( 'liberty-dark-dark' )->text() => 'dark',
				wfMessage( 'liberty-dark-light' )->text() => 'light'
			],
			'help-message' => 'liberty-pref-dark-help',
			'default' => null
		];
	}
}
