<?php
// @codingStandardsIgnoreLine
class LibertyHooks
{
    public static function onLoadExtensionSchemaUpdates(DatabaseUpdater $updater)
    {
        $updater->addExtensionTable('liberty_settings', __DIR__ . '/@@Structure/liberty_settings.sql');
        $updater->addExtensionTable('liberty_usersettings', __DIR__ . '/@@Structure/liberty_usersettings.sql');
        return true;
    }
}
