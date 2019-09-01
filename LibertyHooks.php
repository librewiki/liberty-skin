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
			'options' => [
				'기본값' => "default",
				'본고딕' => "Noto Sans KR",
				'스포카 한 산스' => "Spoqa Han Sans",
				'나눔고딕' => "Nanum Gothic",
				'나눔명조' => 'Nanum Myeongjo',
				'독도' => 'Dokdo',
				'개구쟁이' => 'Gaegu',
				'한겨레결체' => 'Hankc',
				'청소년체' => 'Youth',
				'맑은 고딕' => 'Malgun Gothic'
			],
			'help-message' => 'liberty-pref-fonts-help'
		];
	}
}
