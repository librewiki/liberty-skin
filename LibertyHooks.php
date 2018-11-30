<?php
class LibertyHooks extends Hooks {
	/**
	 * Preference
	 * @param $user User
	 * @param $preferences Preferences
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
	}
}
