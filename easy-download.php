<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Easy_Download
 *
 * @wordpress-plugin
 * Plugin Name: Easy Download
 * Plugin URI: https://wordpress.org/plugins/easy-download/
 * Description: Easy Download help you to manage the files you offer to your users to download.
 * Version: 1.3.6
 * Author: NeosLab
 * Author URI: https://neoslab.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: easy-download
 * Domain Path: /languages
*/

/**
 * If this file is called directly, then abort
*/
if(!defined('WPINC'))
{
	die;
}

/**
 * Currently plugin version
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions
*/
define('EASY_DOWNLOAD_VERSION', '1.3.6');

/**
 * The code that runs during plugin activation
 * This action is documented in includes/class-easy-download-activator.php
*/
function activate_easy_download()
{
	require_once plugin_dir_path(__FILE__).'includes/class-easy-download-activator.php';
	Easy_Download_Activator::activate();
}

/**
 * The code that runs during plugin deactivation
 * This action is documented in includes/class-easy-download-deactivator.php
*/
function deactivate_easy_download()
{
	require_once plugin_dir_path(__FILE__).'includes/class-easy-download-deactivator.php';
	Easy_Download_Deactivator::deactivate();
}

/**
 * Activation/deactivation hook
*/
register_activation_hook(__FILE__, 'activate_easy_download');
register_deactivation_hook(__FILE__, 'deactivate_easy_download');

/**
 * The core plugin class that is used to define internationalization and admin-specific hooks
*/
require plugin_dir_path(__FILE__).'includes/class-easy-download-core.php';

/**
 * The plugin external functions that can be use into the user website frontend
*/
require plugin_dir_path(__FILE__).'libraries/functions.php';
/**
 * Begins execution of the plugin
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle
 * @since 1.0.0
*/
function run_easy_download()
{
	$plugin = new Easy_Download();
	$plugin->run();
}

/**
 * Run plugin
*/
run_easy_download();

?>