<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Stock_Sms
 *
 * @wordpress-plugin
 * Plugin Name:       Stock SMS
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Send stock trading tips via sms to people subscription
 * Version:           1.0.0
 * Author:            Blueprint Developers - Nishant Shaligram
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       stock-sms
 * Domain Path:       /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
*/
define( 'STOCK_SMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
*/
function activate_stock_sms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-stock-sms-activator.php';
	Stock_Sms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_stock_sms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-stock-sms-deactivator.php';
	Stock_Sms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_stock_sms' );
register_deactivation_hook( __FILE__, 'deactivate_stock_sms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-stock-sms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_stock_sms() {

	$plugin = new Stock_Sms();
	$plugin->run();

}
run_stock_sms();
