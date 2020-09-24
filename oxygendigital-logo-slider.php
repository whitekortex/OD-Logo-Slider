<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              oxygendigital.co.nz
 * @since             1.0.0
 * @package           Oxygendigital_Logo_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Oxygen Digital Logo Slider
 * Plugin URI:        oxygendigital.co.nz
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jonathan
 * Author URI:        oxygendigital.co.nz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       oxygendigital-logo-slider
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
define( 'OXYGENDIGITAL_LOGO_SLIDER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-oxygendigital-logo-slider-activator.php
 */
function activate_oxygendigital_logo_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oxygendigital-logo-slider-activator.php';
	Oxygendigital_Logo_Slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-oxygendigital-logo-slider-deactivator.php
 */
function deactivate_oxygendigital_logo_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-oxygendigital-logo-slider-deactivator.php';
	Oxygendigital_Logo_Slider_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_oxygendigital_logo_slider' );
register_deactivation_hook( __FILE__, 'deactivate_oxygendigital_logo_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-oxygendigital-logo-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_oxygendigital_logo_slider() {

	$plugin = new Oxygendigital_Logo_Slider();
	$plugin->run();

}
run_oxygendigital_logo_slider();
