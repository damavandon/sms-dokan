<?php
// ═══════════════════════════ :هشدار: ═══════════════════════════

// ‫ تمامی حقوق مادی و معنوی این افزونه متعلق به سایت پیامیتو به آدرس payamito.com می باشد
// ‫ و هرگونه تغییر در سورس یا استفاده برای درگاهی غیراز پیامیتو ،
// ‫ قانوناً و شرعاً غیرمجاز و دارای پیگرد قانونی می باشد.

// © 2022 Payamito.com, Kian Dev Co. All rights reserved.

// ════════════════════════════════════════════════════════════════

?><?php

/**
 * @package   Payamito
 * @link      https://payamito.com/
 *
 * Plugin Name:       Payamito:vendor-verification
 * Plugin URI:        https://payamito.com/
 * Description:       payamito vendor verification version 
 * Version:           1.2.0
 * Author:            Payamito
 * Author URI:        https://payamito.com/
 * Text Domain:      payamito-vendor-verification     
 * Domain Path:       /languages
 * Requires PHP: 7.0
 */

//require_once __DIR__.'/add-license-header.php';
if (!defined('ABSPATH')) {

	die('Invalid request.');
}
/**
 * main class payamito_vendor_verification
 *
 * @since    1.0.0
 */
if (!class_exists('Payamito_Vendor_Verification')) :

	final class Payamito_Vendor_Verification
	{

		public $textdomain = "payamito-vendor-verification";
		/**
		 * Instance of this loader class.
		 *
		 * @since    1.0.0
		 * @var      object
		 */
		protected static $instance = null;
		/**
		 * Return an instance of this class.
		 *
		 * @since     1.0.0
		 * @return    object    A single instance of this class.
		 */
		/**
		 * Required version of the core.
		 *
		 * The minimum version of the core that's required
		 * to properly run this addon. If the minimum version
		 * requirement isn't met an error message is displayed
		 * and the addon isn't registered.
		 *
		 * @since  1.0.0
		 * @var    string
		 */
		protected $version_required = '5.0.0';

		/**
		 * Required version of PHP.
		 *
		 * Follow WordPress latest requirements and require
		 * PHP version 5.4 at least.
		 * 
		 * @var string
		 */
		protected $php_version_required = '7.0.0';

		/**
		 * Plugin slug.
		 *
		 * @since  1.0.0
		 * @var    string
		 */
		public static  $slug = 'payamito_vv';

		public $core_version = '2.0.0';

		/**
		 * functions container
		 * 
		 * @var object
		 */
		public $functions;

		/**
		 * options container
		 * 
		 * @var object
		 */
		public $options;

		/**
		 * vendor verification container
		 * 
		 * @var object
		 */
		public $vendor;

		/**
		 * send container
		 * 
		 * @var object
		 */
		public $send;



		/**
		 * plugin name container
		 * 
		 * @var object
		 */
		public $plugin_name = ' Payamito vendor verification';

		/**
		 * payamito_vv constructor
		 */
		public function __construct()
		{
			register_activation_hook(__FILE__, [__CLASS__, 'activate']);
			register_deactivation_hook(__FILE__, [__CLASS__, 'deactivate']);
		}
		public static function activate()
		{
			do_action("payamito_vv_activate");
			require_once PATH_PAYAMITO_VV . '/includes/functions.php';
			require_once PATH_PAYAMITO_VV . '/includes/class-install.php';

			Payamito\VV\Install::install();
			require_once  PATH_PAYAMITO_VV . '/includes/core/payamito-core/includes/class-payamito-activator.php';
			Payamito_Activator::activate();
		}
		public static function deactivate()
		{
			do_action("payamito_vv_deactivate");
			require_once PATH_PAYAMITO_VV . '/includes/core/payamito-core/includes/class-payamito-deactivator.php';
			Payamito_Deactivator::deactivate();
		}
		// If the single instance hasn't been set, set it now.


		public static function get_instance()
		{
			if (null == self::$instance) {

				self::$instance = new self;
			}

			self::$instance->init();

			return self::$instance;
		}

		public function load_tgm_object()
		{
			new Payamito\VV\Required\Required();
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __clone()
		{
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'payamito-vendor-verification'), '1.0.0');
		}

		/**
		 * Disable unserializing of the class
		 *
		 * Attempting to wakeup an FES instance will throw a doing it wrong notice.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __wakeup()
		{
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'payamito-vendor-verification'), '1.0.0');
		}
		/**
		 * Declare addon constants
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function declare_constants()
		{
			if (!defined('VERSION_PAYAMITO_VV')) {
				define('VERSION_PAYAMITO_VV', '1.2.0');
			}
			if (!defined('FILE_PAYAMITO_VV')) {
				define('FILE_PAYAMITO_VV', __FILE__);
			}
			if (!defined('URL_PAYAMITO_VVE')) {
				define('URL_PAYAMITO_VVE', trailingslashit(plugin_dir_url(__FILE__)));
			}
			if (!defined('PATH_PAYAMITO_VV')) {
				define('PATH_PAYAMITO_VV', trailingslashit(plugin_dir_path(__FILE__)));
			}
			if (!defined('ROOT_PAYAMITO_VV')) {
				define('ROOT_PAYAMITO_VV', trailingslashit(dirname(plugin_basename(__FILE__))));
			}
			if (!defined('PAYAMITO_CORE_VERSION_VV')) {
				define('PAYAMITO_CORE_VERSION_VV', '2.0.0');
			}
			if (!defined('PAYAMITO_CORE_DIR_VV')) {
				define('PAYAMITO_CORE_DIR_VV', PATH_PAYAMITO_VV . 'includes/core/payamito-core');
			}
		}


		/**
		 * Initialize the addon.
		 *
		 * This method is the one running the checks and
		 * registering the addon to the core.
		 *
		 * @since  0.1.0
		 * @return boolean Whether or not the addon was registered
		 */
		public function init()
		{
			$this->declare_constants();

			$this->include_files();

			$this->get_options();

			$this->init_classes();

			$this->add_action();


			if (!$this->is_php_version_enough()) {

				wp_die(__('Minimum php required version 7.0.0 or higher is required', 'payamito-vendor-verification'));
			}

			return true;
		}
		/**
		 * Get options
		 *
		 *create a global variable containe options
		 *
		 * @since  1.0.0
		 * @return array
		 */
		public function get_options()
		{
			global $pvv_otp_options;

			$otp = get_option('payamito_vv_otp');
			if ($otp == false) {
				$pvv_otp_options['active'] = false;
			} else {
				$pvv_otp_options = $otp;
			}
		}
		/**
		 * Initialize the actions  .
		 *
		 *@param 0 param
		 * @since 1.0
		 * @return void
		 */
		public function add_action()
		{
			add_action('kianfr_' . 'payamito' . '_save_before', [$this, 'option_save'], 10, 1);
			// Load the plugin translation.
			add_action('plugins_loaded', array($this, 'localization_setup'), 1);
			add_action("admin_init", ["PVV_Updater", "init"]);
		}
		/**
		 * Check if vendor verification is active.
		 *
		 * Checks if the vendor verification is plugin is listed in the active
		 * plugins in the WordPress database.
		 *
		 * @since  1.0.0
		 * @return boolean Whether or not the core is active
		 */
		protected function is_dokan_pro_active()
		{
			if (in_array('dokan-pro/dokan-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Initialize plugin for localization
		 *
		 * @uses load_plugin_textdomain()
		 */
		public function localization_setup()
		{
		load_plugin_textdomain('payamito-vendor-verification', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}




		/**
		 * Check if the version of PHP is compatible with this addon.
		 *
		 * @since  1.0.0
		 * @return boolean
		 */
		protected function is_php_version_enough()
		{
			/**
			 * No version set, we assume everything is fine.
			 */
			if (empty($this->php_version_required)) {

				return true;
			}

			if (version_compare(phpversion(), $this->php_version_required, '<')) {

				return false;
			}

			return true;
		}
		/**
		 * Save Plugin options .
		 *
		 * Save all options  in external row in data base form payamito options   .
		 *@param 1 param
		 * @since 1.0
		 * @return void
		 */
		public function  option_save($options)
		{
			$this->otp_option_save($options);
		}

		/**
		 * Save OTP options .
		 * Save all otp options in external row in data base form payamito options   .
		 *@param 1 param
		 * @since 1.0
		 * @return void
		 */
		public  function otp_option_save($options)
		{
			$init = [];
			if (isset($options['payamito_vv_otp_active']) && $options['payamito_vv_otp_active'] == '1') {

				$init['active'] = true;

				if (isset($options['payamito_vv_otp_active_p']) && $options['payamito_vv_otp_active_p'] == '1') {

					$init['pattern_active'] = true;

					$init['pattern_id'] = $options['payamito_vv_otp_p'];

					$init['pattern'] = $options['payamito_vv_otp_repeater'];
				} else {

					$init['text'] = $options['payamito_vv_otp_sms'];
				}
			} else {

				$init['active'] = false;
			}
			$init['number_of_code'] = $options['payamito_vv_number_of_code'];
			$init['time_again'] = $options['payamito_vv_again_send_time'];
			update_option('payamito_vv_otp', $init);
		}

		/**
		 * Load the addon.
		 *
		 * Include all necessary files and instantiate the addon.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function include_files()
		{
			require_once PATH_PAYAMITO_VV . 'includes/functions.php';

			require_once PATH_PAYAMITO_VV . 'includes/lib/class-tgm-plugin-activation.php';

			require_once PATH_PAYAMITO_VV . 'includes/class-plugins-required.php';

			require_once PATH_PAYAMITO_VV . 'includes/class-updater.php';

			require_once PATH_PAYAMITO_VV . 'includes/class-functions.php';

			require_once PATH_PAYAMITO_VV . 'includes/gateway/api/class-send.php';

			require_once PATH_PAYAMITO_VV . 'includes/admin/class-settings.php';

			require_once PATH_PAYAMITO_VV . 'includes/class-vendor-verification.php';
		}

		/**
		 * Load the addon.
		 *
		 * Include all necessary files and instantiate the addon.
		 *
		 * @since  1.0.0
		 * @return void
		 */

		public function init_classes()
		{
			add_action('plugins_loaded', [$this, 'load_tgm_object']);
			if (!$this->is_dokan_pro_active()) {
				return;
			}
			$this->load_core();
			$this->functions = new Payamito\VV\Funtions\Functions();

			$this->options = new Payamito\VV\Settings\Settings();

			$this->send = new Payamito\VV\Send\Send();

			$this->vendor = new Payamito\VV\Verification\Vendor_Verification();
		}

		public function load_core()
		{
			require_once payamito_vv_load_core() . '/payamito.php';
			run_payamito();
		}
	}

endif;

function payamito_vv()
{
	return  Payamito_Vendor_Verification::get_instance();
}
payamito_vv();
