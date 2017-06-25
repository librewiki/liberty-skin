<?php
// @codingStandardsIgnoreLine
class LibertyHooks
{
    public static function onLoadExtensionSchemaUpdates(DatabaseUpdater $updater)
    {
        $updater->addExtensionTable('liberty_navbar', __DIR__ . '/structure/liberty_navbar.sql');
        return true;
    }
}
