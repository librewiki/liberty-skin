<?php
// @codingStandardsIgnoreLine
class LibertyHooks
{
    public static function onGetPreferences(User $user, array &$preferences)
    {
		$preferences['liberty-sidebarPosition'] = array(
			'type' => 'select',
			'label-message' => 'prefs-liberty-sidebarPosition',
			'section' => 'rendering/liberty',
			'options' => array(
				wfMessage('prefs-liberty-sidebarPosition_0')->plain() => '0',
				wfMessage('prefs-liberty-sidebarPosition_1')->plain() => '1',
				wfMessage('prefs-liberty-sidebarPosition_2')->plain() => '2'
			)
		);

		$preferences['liberty-sidebarContent'] = array(
			'type' => 'select',
			'label-message' => 'prefs-liberty-sidebarContent',
			'section' => 'rendering/liberty',
			'options' => array(
				wfMessage('prefs-liberty-sidebarContent_0')->plain() => '0',
				wfMessage('prefs-liberty-sidebarContent_1')->plain() => '1',
				wfMessage('prefs-liberty-sidebarContent_2')->plain() => '2'
			)
		);

		$preferences['liberty-navbarFastOut'] = array(
			'type' => 'toggle',
			'label-message' => 'prefs-liberty-navbarFastOut',
			'section' => 'rendering/liberty'
		);

		$preferences['liberty-navbarHideName'] = array(
			'type' => 'toggle',
			'label-message' => 'prefs-liberty-navbarHideName',
			'section' => 'rendering/liberty'
		);

		return true;
    }
}
