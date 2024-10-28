<?php
/**
 * @package bcard_themes_cache
 * @version 1.5.1
 */
/*
Plugin Name: bcard_themes_cache
Plugin URI: http://wordpress.org/#
Description: Cleanup sidebar
Author: Vital Fadeev
Version: 1.0
Author URI: http://www.mail.ru/
*/


function bcard_themes_cache()
{
    global $wp_themes;

    // prevent reqursion
    $bt = debug_backtrace();

    foreach($bt as $key=>$func)
    {
        if (isset($func['function']) && ($func['function'] == 'bcard_themes_cache'))
        {
            return;
        }
    }

    $cached = array(); // themes array

    // cached
    /*
    $stored;
    $cached = apc_fetch('bcard_themes_cache', &$stored);
    if ($stored)
    {
        $wp_themes = $cached;
        return true;
    }
    */
    $cached = wp_cache_get('bcard_themes_cache');
    if ($cached !== FALSE)
    {
        $wp_themes = $cached;
        return true;
    }

    $themes = get_themes();
    //$res = apc_store('bcard_themes_cache', $themes);
    wp_cache_set('bcard_themes_cache', $themes);

    $wp_themes = $themes;
}

add_action('setup_theme', 'bcard_themes_cache');
