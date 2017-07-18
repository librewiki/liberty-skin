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
        'section' => 'rendering'
    );

    $preferences['colorSub'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-colorSub',
        'section' => 'rendering'
    );

    $preferences['colorAutoSub'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-colorAutoSub',
        'section' => 'rendering',
        'default' => 'true'
    );

    $preferences['sidebarPosition'] = array(
        'type' => 'radio',
        'label-message' => 'liberty-sp-sidebarPosition',
        'section' => 'rendering',
        'options' => array(
            'liberty-sp-sidebarPosition_0' => '0',
            'liberty-sp-sidebarPosition_1' => '1',
            'liberty-sp-sidebarPosition_2' => '2'
        ),
        'default' => '2'
    );

    $preferences['sidebarContent'] = array(
        'type' => 'radio',
        'label-message' => 'liberty-sp-sidebarContent',
        'section' => 'rendering',
        'options' => array(
            'liberty-sp-sidebarContent_0' => '0',
            'liberty-sp-sidebarContent_1' => '1',
            'liberty-sp-sidebarContent_2' => '2',
            'liberty-sp-sidebarContent_3' => '3'
        ),
        'default' => '2'
    );

    $preferences['navbarFastout'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-navbarFastout',
        'section' => 'rendering',
        'default' => 'true'
    );

    $preferences['navbarHideName'] = array(
        'type' => 'toggle',
        'label-message' => 'liberty-sp-navbarHideName',
        'section' => 'rendering',
        'default' => 'false'
    );

    return true;
    }
}
