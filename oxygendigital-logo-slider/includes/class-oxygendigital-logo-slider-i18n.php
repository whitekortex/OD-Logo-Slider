<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       oxygendigital.co.nz
 * @since      1.0.0
 *
 * @package    Oxygendigital_Logo_Slider
 * @subpackage Oxygendigital_Logo_Slider/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Oxygendigital_Logo_Slider
 * @subpackage Oxygendigital_Logo_Slider/includes
 * @author     Jonathan <jonathan.entila@oxygendigital.co.nz>
 */
class Oxygendigital_Logo_Slider_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'oxygendigital-logo-slider',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
