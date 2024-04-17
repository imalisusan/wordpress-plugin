<?php

/**
 *@package  ImaliPlugin
 */

namespace Inc;

class Deactivate {
    /**
     * Deactivate Plugin
     * @return void
     *
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }
}