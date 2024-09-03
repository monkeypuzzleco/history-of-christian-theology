<?php
/*
  Plugin Name:Cool Timeline Pro
  Plugin URI:http://coolplugins.net/
  Description:Cool Timeline Pro, #1 WordPress timeline plugin to showcase your life story or your company history in a vertical or horizontal timeline format. You can also create a content timeline using your blog-posts or any post-type.
  Version:4.8.4
  Author:Cool Plugins
  Author URI:http://coolplugins.net/
  License:GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain:cool-timeline
 */
/** Configuration * */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'CTLPV' ) ) {
	define( 'CTLPV', '4.8.4' );
}
/*
 Defined constant for later use
 */
define( 'CTP_FILE', __FILE__ );
define( 'CTP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CTP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CTP_DEMO_URL', 'https://cooltimeline.com/demo/?utm_source=ctp_plugin&utm_medium=inside&utm_campaign=demo' );

if ( ! class_exists( 'CoolTimelinePro' ) ) {

	final class CoolTimelinePro {

		/**
		 * The unique instance of the plugin.
		 */
		private static $instance;

		/**
		 * Gets an instance of our plugin.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		 /**
		  * Construct the plugin objects
		  */
		private function __construct() {}

		public function registers() {
			$thisIns = self::$instance;
			// contain common function for plugin
			require_once CTP_PLUGIN_DIR . 'includes/shortcodes/class-ctl-helpers.php';

			if ( is_admin() ) {
				add_action( 'plugins_loaded', array( $thisIns, 'ctl_admin_files' ) );
				$thisIns->admin_registers();
			}

			// included all files
			add_action( 'plugins_loaded', array( $thisIns, 'ctl_frontend_files' ) );

			// Hooked plugin translation function
			add_action( 'plugins_loaded', array( $thisIns, 'ctl_load_textdomain' ) );

			/*
			@since version 2.8
			*/
			  // registering custom route for categories
			 add_action( 'rest_api_init', array( 'CTL_Helpers', 'ctl_register_routes' ) );
			  // flush_rewrite rules
			 add_action( 'init', array( $thisIns, 'clt_flush_rewrite_rules_after_activation' ) );

			// add_action( 'init', array( $thisIns,'clt_load_settings' ) );
			 add_action( 'admin_menu', array( $thisIns, 'ctl_add_new_item' ) );

			 $thisIns->includesOnInit();

		}
		public function ctl_add_new_item() {
			add_submenu_page( 'cool-plugins-timeline-addon', 'Add New Story', 'Add New Story', 'manage_options', 'post-new.php?post_type=cool_timeline', false, 15 );
			add_submenu_page( 'cool-plugins-timeline-addon', 'Categories', 'Categories', 'manage_options', 'edit-tags.php?taxonomy=ctl-stories&post_type=cool_timeline', false, 15 );
		}

		public function ctl_admin_files() {
			 require_once CTP_PLUGIN_DIR . 'admin/registration/registration-settings.php';
			require_once CTP_PLUGIN_DIR . 'admin/registration/init-api.php';
			require_once CTP_PLUGIN_DIR . 'admin/class-migration.php';
			/* Plugin Settings panel */
			$current_page = CTL_Helpers::ctl_get_ctp();
			// if($current_page!="cool_timeline" ){
			require_once CTP_PLUGIN_DIR . 'admin/ctl-framework/ctl-framework.php';
			// }

			require_once CTP_PLUGIN_DIR . 'admin/ctl-shortcode-generator.php';

			// including plugin settings panel class
			require_once CTP_PLUGIN_DIR . 'admin/ctl-admin-settings.php';
			// including timeline stories meta boxes class
			require_once CTP_PLUGIN_DIR . 'admin/ctl-meta-fields.php';
			// Vc addon for timeline shortcode
			require_once CTP_PLUGIN_DIR . 'admin/class-cool-vc-addon.php';

			/*** Plugin review notice file */
			require_once CTP_PLUGIN_DIR . '/admin/notices/admin-notices.php';
			require_once CTP_PLUGIN_DIR . 'admin/notices/plugin-upgrade-notice.php';
			 new CoolVCAddon();
			 require_once __DIR__ . '/admin/timeline-addon-page/timeline-addon-page.php';
			cool_plugins_timeline_addons_settings_page( 'timeline', 'cool-plugins-timeline-addon', 'Timeline Addons', ' Timeline Addons', CTP_PLUGIN_URL . 'assets/images/cool-timeline-icon.svg' );
		}

		// includes files on plugin loaded hook
		public function ctl_frontend_files() {

			// Register cooltimeline post type for timeline
			require_once CTP_PLUGIN_DIR . 'admin/class-cool-timeline-posttype.php';
			new CoolTimelinePosttype();

			// initilize shortcodes
			require_once CTP_PLUGIN_DIR . 'includes/shortcodes/class-ctl-shortcode.php';
			require_once CTP_PLUGIN_DIR . 'includes/shortcodes/class-ctl-post-shortcode.php';
			require_once CTP_PLUGIN_DIR . 'includes/shortcodes/class-ctl-settings.php';
			require_once CTP_PLUGIN_DIR . 'includes/shortcodes/class-ctl-ajax-handler.php';
			$settingsObj = new CTL_Settings();
			CTL_Shortcode::get_instance( $settingsObj );
			CTL_Post_Shortcode::get_instance( $settingsObj );
			CTL_Ajax_Handler::get_instance( $settingsObj );
		}

		public function includesOnInit() {
			 // check if elementor is installed
			if ( file_exists( plugin_dir_path( __DIR__ ) . 'elementor/elementor.php' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
				// Check if elementor is in the list of active plugins?
			}
			 require_once CTP_PLUGIN_DIR . 'includes/shortcode-block/ctl-block.php';

			 // integrated gutenberg instant timeline builder
			 require CTP_PLUGIN_DIR . 'includes/deprecated-gutenberg-instant-builder/cooltimeline-instant-builder.php';
			 require CTP_PLUGIN_DIR . 'includes/cool-timeline-block/src/init.php';
			 CoolTimelineProInstantBuilder::get_instance();

		}

		public function admin_registers() {
			$thisIns = self::$instance;
			// Installation and uninstallation hooks
			register_activation_hook( __FILE__, array( $thisIns, 'ctp_activation_before' ) );

			// update attribute migration meta key.
			add_action( 'init', array( $thisIns, 'ctl_plugin_update' ) );

			// Adding plugin settings link
			$plugin_path = plugin_basename( __FILE__ );
			add_filter( "plugin_action_links_$plugin_path", array( $thisIns, 'plugin_settings_link' ) );
			// Fixed bridge theme confliction using this action hook
			add_action( 'wp_print_scripts', array( $thisIns, 'ctl_deregister_javascript' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $thisIns, 'ctl_custom_order_js' ) );

			// add a tinymce button that generates our shortcode for the user
			add_action( 'after_setup_theme', array( $thisIns, 'ctl_add_tinymce' ) );

			add_action( 'admin_init', array( $thisIns, 'onInit' ) );
			add_action( 'wp_loaded', array( $this, 'ctl_plugin_demo_page' ) );
		}

		public function onInit() {
			/*** Plugin review notice file */
			ctl_create_admin_notice(
				array(
					'id'              => 'ctl_review_box',  // required and must be unique
					'slug'            => 'ctl',      // required in case of review box
					'review'          => true,     // required and set to be true for review box
					'review_url'      => esc_url( 'https://codecanyon.net/item/cool-timeline-pro-wordpress-timeline-plugin/reviews/17046256?utf8=%E2%9C%93&reviews_controls%5Bsort%5D=ratings_descending' ), // required
					'plugin_name'     => 'Cool Timeline PRO',    // required
					'logo'            => CTP_PLUGIN_URL . 'assets/images/cool-timeline-logo.png',    // optional: it will display logo
					'review_interval' => 3,        // optional: this will display review notice
						 // after 5 days from the installation_time
					 // default is 3
				)
			);
		}

		// flushed rewrite rules after plugin activations
		function clt_flush_rewrite_rules_after_activation() {
			 // flush rewrite rules after activation
			if ( get_option( 'ctl_flush_rewrite_rules_flag' ) ) {
				flush_rewrite_rules();
				delete_option( 'ctl_flush_rewrite_rules_flag' );
			}
		}

		function ctl_custom_order_js( $hook ) {
			$current_page = CTL_Helpers::ctl_get_ctp();
			if ( $current_page != 'cool_timeline' ) {
				return;
			}
			wp_enqueue_script( 'ctl-admin-js', CTP_PLUGIN_URL . 'assets/js/ctl_admin.js', array( 'jquery' ) );
			wp_localize_script(
				'ctl-admin-js',
				'ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
			);
		}



		/*
		Perform some actions on plugin activation time
		*/
		public function ctp_activation_before() {
			if ( file_exists( plugin_dir_path( __DIR__ ) . 'cool-timeline/cooltimeline.php' ) ) {
				 include_once ABSPATH . 'wp-admin/includes/plugin.php';
				if ( is_plugin_active( 'cool-timeline/cooltimeline.php' ) ) {
					deactivate_plugins( 'cool-timeline/cooltimeline.php' );
				}
			}

			$this->ctl_plugin_update();

			// for rating notice
			update_option( 'cool-timelne-pro-installDate', date( 'Y-m-d h:i:s' ) );
			add_option( 'cool-timeline-pro-already-rated', 'no' );
			update_option( 'ctl_flush_rewrite_rules_flag', true );
			update_option( 'cool-timelne-pro-v', CTLPV );
			update_option( 'cool-timelne-plugin-type', 'PRO' );
			update_option( 'ctl_demo_page', true );
			$ctl_settings = get_option( 'cool_timeline_options' );

			if ( is_array( $ctl_settings ) && ! empty( $ctl_settings ) ) {
				if ( isset( $ctl_settings['enable_navigation'] ) && in_array( 'enable_navigation', $ctl_settings ) ) {
					update_option( 'ctl-can-migrate', 'no' );
				} else {
					update_option( 'ctl-can-migrate', 'yes' );
				}
			} else {
				update_option( 'ctl-can-migrate', 'yes' );
			}
		}


		/**
		 * Update data after update the plugin
		 */
		public function ctl_plugin_update() {
			$ctl_version        = get_option( 'cool-timelne-pro-v', false );
			$ctl_attr_migration = get_option( 'ctl-migration-free', false );
			$ctl_free_version   = get_option( 'cool-free-timeline-v', false );

			if ( ! $ctl_version && $ctl_free_version ) {
				update_option( 'ctl-migration-free', true );
			};
			if ( ( version_compare( $ctl_version, '4.5', '<' ) || ( ! $ctl_version && $ctl_free_version ) ) && ! $ctl_attr_migration ) {
				update_option( 'ctl-attribute-migration', true );
			};
		}

		/*
			Loading translation files of plugin
		 */

		function ctl_load_textdomain() {
			 $rs = load_plugin_textdomain( 'cool-timeline', false, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		// Add the settings link to the plugins page
		function plugin_settings_link( $links ) {
			  $settings_link = '<a href="admin.php?page=cool_timeline_settings">Settings</a>';
			  array_unshift( $links, $settings_link );
			  return $links;
		}

		function ctl_plugin_demo_page() {
			$show_demo_page = get_option( 'ctl_demo_page', false );
			if ( $show_demo_page ) {
				update_option( 'ctl_demo_page', false );
				$timeline_demo_page = 'admin.php?page=cool_timeline_settings#tab=get-started';
				wp_safe_redirect( $timeline_demo_page );
			}
		}

		/*
		* Fixed Bridge theme confliction
		*/
		function ctl_deregister_javascript() {

			if ( is_admin() ) {
				global $post;
				if ( function_exists( 'get_current_screen' ) ) {
					$screen = get_current_screen();
					if ( $screen != null && $screen->base == 'toplevel_page_cool_timeline_page' ) {
						wp_deregister_script( 'bridge-admin-default' );
						wp_deregister_script( 'default' );
						wp_deregister_script( 'subway-admin-default' );
						wp_deregister_script( 'strata-admin-default' );
						wp_deregister_script( 'stockholm-admin-default' );// for Stockholm Theme
					}
				}
				if ( isset( $post ) && isset( $post->post_type ) && $post->post_type == 'cool_timeline' ) {
					wp_deregister_script( 'acf-timepicker' );
					wp_deregister_script( 'acf-input' ); // datepicker translaton issue
					wp_deregister_script( 'acf' ); // datepicker translaton issue
					// wp_deregister_script('lvca-timepicker-addon'); // datepicker confict Livemesh Addons for WPBakery Page Builder plugin
					// wp_deregister_style('lvca-timepicker-addon-css');// datepicker confict Livemesh Addons for WPBakery Page Builder plugin
					wp_deregister_script( 'thrive-admin-datetime-picker' ); // datepicker conflict with Rise theme
					wp_deregister_script( 'et_bfb_admin_date_addon_js' ); // datepicker conflict with Divi theme
					wp_deregister_script( 'zeen-engine-admin-vendors-js' ); // datepicker conflict with zeen engine plugin
				}
			}
		}

		/*
			Adding shortcode generator in TinyMCE editor
		 */
		public function ctl_add_tinymce() {
			global $typenow;
			$thisIns = self::$instance;
			if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
				  return;
			}
		}
	}//end class
}

// instantiate the plugin class

$ctl = CoolTimelinePro::get_instance();
$ctl->registers();
/*** THANKS - CoolPlugins.net ) */

