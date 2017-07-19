<?php
// @codingStandardsIgnoreLine
class LibertyHooks
{
    public static function onLoadExtensionSchemaUpdates(DatabaseUpdater $updater)
    {
        $updater->addExtensionTable('liberty_settings', __DIR__ . '/.maintenance/liberty_settings.sql');
        $updater->addExtensionTable('liberty_usersettings', __DIR__ . '/.maintenance/liberty_usersettings.sql');
        
        return true;
    }

    public static function onGetPreferences(User $user, array &$preferences)
    {
    $preferences['colorMain'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-colorMain',
        'section' => 'rendering/liberty'
    );

    $preferences['colorSub'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-colorSub',
        'section' => 'rendering/liberty'
    );

    $preferences['colorAutoSub'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-colorAutoSub',
        'section' => 'rendering/liberty',
        'default' => 'true'
    );

    $preferences['sidebarPosition'] = array(
        'type' => 'radio',
        'label-message' => 'liberty-sp-sidebarPosition',
        'section' => 'rendering/liberty',
        'options' => array(
            wfMessage('liberty-sp-sidebarPosition_0')->plain() => '0',
            wfMessage('liberty-sp-sidebarPosition_1')->plain() => '1',
            wfMessage('liberty-sp-sidebarPosition_2')->plain() => '2'
        ),
        'default' => '0'
    );

    $preferences['sidebarContent'] = array(
        'type' => 'radio',
        'label-message' => 'liberty-sp-sidebarContent',
        'section' => 'rendering/liberty',
        'options' => array(
            wfMessage('liberty-sp-sidebarContent_0')->plain() => '0',
            wfMessage('liberty-sp-sidebarContent_1')->plain() => '1',
            wfMessage('liberty-sp-sidebarContent_2')->plain() => '2'
        ),
        'default' => '0'
    );

    $preferences['navbarFastOut'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-navbarFastOut',
        'section' => 'rendering/liberty',
        'default' => 'true'
    );

    $preferences['navbarHideName'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-navbarHideName',
        'section' => 'rendering/liberty',
        'default' => 'false'
    );

		return true;
    }
}
