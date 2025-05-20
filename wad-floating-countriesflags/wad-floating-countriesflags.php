<?php
/**
 * Plugin Name: WebAppDev Floating Countries Flags
 * Plugin URI: https://webappdev.my.id
 * Description: Displays floating country flags with customizable links in various screen positions.
 * Version: 1.0.0
 * Author: Habibie
 * Author URI: https://webappdev.my.id
 * Text Domain: wad_floating_countriesflags
 * License: GPL2
 */

defined('ABSPATH') or die('No script kiddies please!');

// Define plugin constants
define('WAD_FCF_VERSION', '1.0.0');
define('WAD_FCF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WAD_FCF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once WAD_FCF_PLUGIN_DIR . 'includes/admin-settings.php';
require_once WAD_FCF_PLUGIN_DIR . 'includes/frontend-display.php';

// Register activation hook
register_activation_hook(__FILE__, 'wad_fcf_activate');

function wad_fcf_activate() {
    // Set default options on activation
    if (!get_option('wad_fcf_settings')) {
        $default_options = array(
            'position' => 'bottom-right',
            'flags' => array(
                'us' => array('url' => 'https://example.com', 'enabled' => true),
                'gb' => array('url' => 'https://example.com/uk', 'enabled' => true),
            )
        );
        update_option('wad_fcf_settings', $default_options);
    }
}

// Load text domain
add_action('plugins_loaded', 'wad_fcf_load_textdomain');

function wad_fcf_load_textdomain() {
    load_plugin_textdomain('wad_floating_countriesflags', false, dirname(plugin_basename(__FILE__))) . '/languages/';
}