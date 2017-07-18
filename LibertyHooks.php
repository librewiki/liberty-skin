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
}
