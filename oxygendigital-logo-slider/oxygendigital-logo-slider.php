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


/**
 * The code that runs during plugin updates.
 * This action is documented in includes/class-logo-carousel-free-updates.php
 */
#require_once plugin_dir_path( __FILE__ ) . 'includes/class-logo-carousel-free-updates.php';
#require_once plugin_dir_path( __FILE__ ) . 'admin/views/notices/review.php';

/**
 * Handles core plugin hooks and action setup.
 *
 * @package logo-carousel-free
 * @since 3.0
 */
if ( ! class_exists( 'SP_Logo_Carousel' ) ) {
	class SP_Logo_Carousel {
		/**
		 * Plugin name
		 *
		 * @var string
		 */
		public $plugin_name = 'logo-carousel-free';

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '';

		/**
		 * @var SP_Logo_Carousel single instance of the class
		 *
		 * @since 3.0
		 */
		protected static $_instance = null;

		/**
		 * @var SPLC_Logo $project
		 */
		public $logo;

		/**
		 * @var SPLC_Router $router
		 */
		public $router;

		/**
		 * @var SPLC_Router $shortcode
		 */
		public $shortcode;

		/**
		 * @var SPLC_MetaBox $metabox
		 */
		public $metabox;

		/**
		 * Main SPLC Instance
		 *
		 * @since 3.0
		 * @static
		 * @see wpl_lc()
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor for the SP_Logo_Carousel class
		 */
		function __construct() {
			// Define constants.
			$this->define_constants();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

			// instantiate classes.
			$this->instantiate();

			// Initialize the filter hooks.
			$this->init_filters();

			// Initialize the action hooks.
			$this->init_actions();
		}

		/**
		 * Flush rewrite rules
		 */
		function sp_lc_flush_rewrites() {
			// call your CPT registration function here (it should also be hooked into 'init').
			$this->logo->register_post_type();
			flush_rewrite_rules();
		}

		/**
		 * Initialize WordPress filter hooks
		 *
		 * @return void
		 */
		function init_filters() {
			add_filter( 'plugin_action_links_' . SP_LC_BASENAME, array( $this, 'add_plugin_action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'after_logo_carousel_row_meta' ), 10, 4 );
			add_filter( 'manage_wpl_lcp_shortcodes_posts_columns', array( $this, 'add_shortcode_column' ) );
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts' ) );
			add_action( 'manage_wpl_lcp_shortcodes_posts_custom_column', array( $this, 'add_shortcode_form' ), 10, 2 );
			add_action( 'activated_plugin', array( $this, 'redirect_help_page' ) );
		}

		/**
		 * Define wpl_lc constants
		 *
		 * @since 3.0
		 */
		public function define_constants() {
			$this->define( 'SP_LC_VERSION', $this->version );
			$this->define( 'SP_LC_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'SP_LC_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'SP_LC_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define constant if not already set
		 *
		 * @since 3.0
		 *
		 * @param string      $name
		 * @param string|bool $value
		 */
		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Plugin Scripts and Styles
		 */
		function public_scripts() {
				// CSS Files.
				wp_register_style( 'sp-lc-slick', SP_LC_URL . 'public/assets/css/slick.min.css', array(), SP_LC_VERSION );
				wp_register_style( 'sp-lc-font-awesome', SP_LC_URL . 'public/assets/css/font-awesome.min.css', array(), SP_LC_VERSION );
				wp_register_style( 'sp-lc-style', SP_LC_URL . 'public/assets/css/style.min.css', array(), SP_LC_VERSION );

				// JS Files.
				wp_register_script( 'sp-lc-slick-js', SP_LC_URL . 'public/assets/js/slick.min.js', array( 'jquery' ), SP_LC_VERSION, true );
				wp_register_script( 'sp-lc-script', SP_LC_URL . 'public/assets/js/splc_script.min.js', array( 'jquery', 'sp-lc-slick-js' ), SP_LC_VERSION, true );
		}


		/**
		 * Load textdomain for plugin.
		 *
		 * @since 3.0
		 */
		public function load_plugin_textdomain() {
			load_textdomain( 'logo-carousel-free', WP_LANG_DIR . '/logo-carousel-free/logo-carousel-free-' . apply_filters( 'plugin_locale', get_locale(), 'logo-carousel-free' ) . '.mo' );
			load_plugin_textdomain( 'logo-carousel-free', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Add plugin action menu
		 *
		 * @since 3.0
		 *
		 * @param array  $links
		 * @param string $file
		 *
		 * @return array
		 */
		public function add_plugin_action_links( $links, $file ) {

			if ( SP_LC_BASENAME === $file ) {
				//$ui_links = sprintf( '<a href="%s">%s</a>', admin_url( 'post-new.php?post_type=wpl_lcp_shortcodes' ), __( 'Create Carousel', 'logo-carousel-free' ) );

				//array_unshift( $links, $ui_links );

				//$links['go_pro'] = sprintf( '<a href="%s" style="%s">%s</a>', 'https://shapedplugin.com/plugin/logo-carousel-pro/', 'color:#1dab87;font-weight:bold', __( 'Go Premium!', 'logo-carousel-free' ) );
			}

			return $links;
		}

		/**
		 * Add plugin row meta link
		 *
		 * @since 3.0
		 *
		 * @param $plugin_meta
		 * @param $file
		 *
		 * @return array
		 */
		function after_logo_carousel_row_meta( $plugin_meta, $file ) {
			if ( SP_LC_BASENAME === $file ) {
				//$plugin_meta[] = '<a href="https://shapedplugin.com/demo/logo-carousel-pro/" target="_blank">' . __( 'Live Demo', 'logo-carousel-free' ) . '</a>';
			}
			return $plugin_meta;
		}


		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name
		 */
		function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[1] ) ) {
				$class_name = strtolower( $name[1] );
				$filename   = SP_LC_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Instantiate all the required classes
		 *
		 * @since 3.0
		 */
		function instantiate() {

			$this->logo      = SPLC_Logo::getInstance();
			$this->shortcode = SPLC_Shortcode::getInstance();
			$this->metabox   = SPLC_MetaBox::getInstance();

			do_action( 'splc_instantiate', $this );
		}

		/**
		 * page router instantiate
		 *
		 * @since 3.0
		 */
		function page() {
			$this->router = SPLC_Router::instance();

			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		function includes() {
			// $this->version = SP_LC_VERSION;
			$this->page()->splc_function();
			$this->router->includes();
		}

		/**
		 * ShortCode Column
		 *
		 * @return mixed
		 */
		function add_shortcode_column() {
			$new_columns['cb']        = '<input type="checkbox" />';
			$new_columns['title']     = __( 'Carousel Title', 'logo-carousel-free' );
			$new_columns['shortcode'] = __( 'Shortcode', 'logo-carousel-free' );
			$new_columns['']          = '';
			$new_columns['date']      = __( 'Date', 'logo-carousel-free' );

			return $new_columns;
		}

		/**
		 * @param $column
		 * @param $post_id
		 */
		function add_shortcode_form( $column, $post_id ) {

			switch ( $column ) {

				case 'shortcode':
					$column_field = '<input style="width: 270px;padding: 6px;" type="text" onClick="this.select();" readonly="readonly" value="[logocarousel ' . 'id=&quot;' . $post_id . '&quot;' . ']"/>';
					echo $column_field;
					break;
				default:
					break;

			} // end switch

		}

		/**
		 * Redirect after active
		 *
		 * @param $plugin
		 */
		function redirect_help_page( $plugin ) {
			if ( SP_LC_BASENAME === $plugin ) {
				//exit( wp_redirect( admin_url( 'edit.php?post_type=wpl_logo_carousel&page=lc_help' ) ) );
				exit( wp_redirect( admin_url( 'edit.php?post_type=wpl_logo_carousel' ) ) );
			}
		}

	}
}


/**
 * Returns the main instance.
 *
 * @since 3.0
 * @return SP_Logo_Carousel
 */
function sp_logo_carousel() {
	return SP_Logo_Carousel::instance();
}

// sp_logo_carousel instance.
$cpm = sp_logo_carousel();

