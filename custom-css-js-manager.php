<?php
/*
Plugin Name: Custom CSS & JS Manager
Description: Add and manage custom CSS/JS globally and for various screen sizes.
Version: 1.0.0
Author: Seraj Ahmad
Author URI: https://www.linkedin.com/in/serajahmad1232
License: GPLv2 or later
Text Domain: custom-css-js-manager
*/

if (!defined('ABSPATH')) exit;

define('CCJ_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Includes
require_once CCJ_PLUGIN_DIR . 'includes/admin-page.php';
require_once CCJ_PLUGIN_DIR . 'includes/settings-fields.php';
require_once CCJ_PLUGIN_DIR . 'includes/output-hooks.php';
require_once CCJ_PLUGIN_DIR . 'includes/editor-assets.php';
require_once CCJ_PLUGIN_DIR . 'includes/backup-restore.php';

add_action('plugins_loaded', function() {
    load_plugin_textdomain('custom-css-js', false, dirname(plugin_basename(__FILE__)) . '/languages');
});
