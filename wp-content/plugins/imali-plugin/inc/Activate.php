<?php

/**
 *@package  ImaliPlugin
 */
namespace Inc;

class Activate {
    /**
     * Activate Plugin
     * @return void
     */
    public static function activate(): void
    {
        flush_rewrite_rules();
    }
}