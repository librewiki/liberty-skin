<?php
// @codingStandardsIgnoreLine
class LibertyHooks
{
    public static function onGetPreferences(User $user, array &$preferences)
    {
    $preferences['colorMain'] = array(
        'type' => 'toggle',
        'label-message' => 'prefs-liberty-colorMain',
        'section' => 'rendering/liberty'
    );

    $preferences['colorSub'] = array(
        'type' => 'toggle',
        'label-message' => 'prefs-liberty-colorSub',
        'section' => 'rendering/liberty'
    );

    $preferences['colorAutoSub'] = array(
        'type' => 'toggle',
        'label-message' => 'prefs-liberty-colorAutoSub',
        'section' => 'rendering/liberty',
        'default' => 'true'
    );

    $preferences['sidebarPosition'] = array(
        'type' => 'radio',
        'label-message' => 'prefs-liberty-sidebarPosition',
        'section' => 'rendering/liberty',
        'options' => array(
            wfMessage('prefs-liberty-sidebarPosition_0')->plain() => '0',
            wfMessage('prefs-liberty-sidebarPosition_1')->plain() => '1',
            wfMessage('prefs-liberty-sidebarPosition_2')->plain() => '2'
        ),
        'default' => '0'
    );

    $preferences['sidebarContent'] = array(
        'type' => 'radio',
        'label-message' => 'prefs-liberty-sidebarContent',
        'section' => 'rendering/liberty',
        'options' => array(
            wfMessage('prefs-liberty-sidebarContent_0')->plain() => '0',
            wfMessage('prefs-liberty-sidebarContent_1')->plain() => '1',
            wfMessage('prefs-liberty-sidebarContent_2')->plain() => '2'
        ),
        'default' => '0'
    );

    $preferences['navbarFastOut'] = array(
        'type' => 'toggle',
        'label-message' => 'prefs-liberty-navbarFastOut',
        'section' => 'rendering/liberty',
        'default' => 'true'
    );

    $preferences['navbarHideName'] = array(
        'type' => 'toggle',
        'label-message' => 'prefs-liberty-navbarHideName',
        'section' => 'rendering/liberty',
        'default' => 'false'
    );

		return true;
    }
}
