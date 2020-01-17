<?php //phpcs:ignore
class LibertyHooks extends Hooks {
	/**
	 * Preference
	 * @param User $user user
	 * @param Preferences &$preferences preferences
	 */
	public static function onGetPreferences( $user, &$preferences ) {
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
			'default' => 'default',
			'options' => [
				wfMessage( 'liberty-font-name-default' )->text() => 'default',
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
			'help-message' => 'liberty-pref-fonts-help'
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
