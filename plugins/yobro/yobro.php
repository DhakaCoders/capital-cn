<?php
/*
* Plugin Name: YoBro Pro
* Plugin URI: https://goo.gl/GTcEQD
* Description: A simple WordPress messaging / chat solution
* Version: 2.0
* Author: redqteam
* Author URI: https://redq.io
* Requires at least: 4.6
* Tested up to: 4.9.5
*
* Text Domain: yobro
* Domain Path: /languages/
*
* Copyright: © 2012-2018 RedQ,Inc.
* License: GNU General Public License v3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*
*/


/**
* Class Redq_YoBro
*/
class Redq_YoBro {

	protected $user;

	/**
	* @return mixed
	*/
	public function getUser()
	{
		return $this->user;
	}

	/**
	* @var null
	*/
	protected static $_instance = null;

	/**
	* @create instance on self
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		if( !defined('YOBRO_REQUIRED_PHP_VERSION') ) {
      define( 'YOBRO_REQUIRED_PHP_VERSION', 5.4);
    }

    if( !defined('YOBRO_REQUIRED_WP_VERSION') ) {
      define( 'YOBRO_REQUIRED_WP_VERSION', 4.5);
		}
    if( !defined('YOBRO_REQUIRED_MYSQL_VERSION') ) {
      define( 'YOBRO_REQUIRED_MYSQL_VERSION', 5.6);
		}
		add_action( 'admin_init', array( $this, 'check_version' ) );
		if ( ! self::compatible_version() ) {
			return;
		}
		$this->yobro_load_all_classes();
		$this->yobro_app_bootstrap();
		add_action( 'plugins_loaded', array( &$this, 'yobro_language_textdomain' ),1 );
	}

	/**
	*  App Bootstrap
	*  Fire all class
	*/
	public function yobro_app_bootstrap(){
		/**
		* Define plugin constant
		*/
		define( 'YOBRO_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'YOBRO_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		define( 'YOBRO_FILE', __FILE__ );
		define( 'YOBRO_CSS' , YOBRO_URL.'/assets/css/' );
		define( 'YOBRO_CSS_COMPILED' ,  YOBRO_URL.'/assets/dist/css/' );
		define( 'YOBRO_JS_COMPILED' ,  YOBRO_URL.'/assets/dist/js/' );
		define( 'YOBRO_VEN' , YOBRO_URL.'/assets/ven/');
		define( 'YOBRO_IMG' ,  YOBRO_URL.'/assets/img/' );



		new YoBro\App\YoBro_Install();          // TextDomain , install hook
		new YoBro\App\YoBro_Database();
		new YoBro\Admin\YoBro_Admin_Menu();
		new YoBro\App\YoBro_Frontend_Scripts(); // enqueue scripts and style
		new YoBro\App\YoBro_Ajax();             // all ajax
		new YoBro\App\BBPressBuddyPress();             // all ajax
	  // if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    //   require_once(YOBRO_DIR.'/app/yobro-visual-composer.php' );
    // }
	}

	/**
	* Load all the classes with composer auto loader
	*
	* @return void
	*/
	public function yobro_load_all_classes(){
		include_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
		include_once(__DIR__.DIRECTORY_SEPARATOR.'app/yobro-helper.php');
		include_once(__DIR__.DIRECTORY_SEPARATOR.'app/shortcode.php');
	}


		/**
		* The backup sanity check, in case the plugin is activated in a weird way,
		* or the versions change after activation.
		*/
		public function check_version() {
			if ( ! self::compatible_version() ) {
					if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
							deactivate_plugins( plugin_basename( __FILE__ ) );
							add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
							if ( isset( $_GET['activate'] ) ) {
									unset( $_GET['activate'] );
							}
					}
			}
		}

	/**
	 * Plugin on installation error notice
	 */
	public function disabled_notice() {
		global $wpdb;
		if(phpversion() < YOBRO_REQUIRED_PHP_VERSION) { ?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Can\'t Activate! Yobro requires PHP '.YOBRO_REQUIRED_PHP_VERSION.' or higher!', 'yobro' ); ?></p>
			</div>
		<?php
		}
		if($GLOBALS['wp_version'] < YOBRO_REQUIRED_WP_VERSION) { ?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Can\'t Activate! Yobro requires Wordpress '.YOBRO_REQUIRED_WP_VERSION.' or higher!', 'yobro' ); ?></p>
			</div>
		<?php
		}
		if($wpdb->db_version() < YOBRO_REQUIRED_MYSQL_VERSION) { ?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Can\'t Activate! Yobro requires MySQL '.YOBRO_REQUIRED_MYSQL_VERSION.' or higher!', 'yobro' ); ?></p>
			</div>
		<?php
		}
	}

	/**
	* Get the plugin textdomain for multilingual.
	* @return null
	*/
	public function yobro_language_textdomain() {
		load_plugin_textdomain( 'yobro', false,dirname( plugin_basename( __FILE__ ) ) . '/languages/');
	}

	static function compatible_version() {
		global $wpdb;
		if ( $wpdb->db_version() < YOBRO_REQUIRED_MYSQL_VERSION || phpversion() < YOBRO_REQUIRED_PHP_VERSION || $GLOBALS['wp_version'] < YOBRO_REQUIRED_WP_VERSION ) return false;
		return true;
	}
}

/**
* @return null|Redq_YoBro
*/
function YoBro() {
	return Redq_YoBro::instance();
}
$GLOBALS['yobro'] = YoBro();
