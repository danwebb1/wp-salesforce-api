<?php
/**
* This is the core plugin class that is used to initialize and set admin specific hooks
*/

class WP_Sfapi_Public {
	/**
	 * The string used to uniquely identify this plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_name;

	/**
	 * The plugin_url
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_url;

	/**
	 * The plugin_path
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_path;

	/**
	 * Current version of the plugin
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name, url, path and plugin version that can be used throughout the plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $plugin_root ) {
		$this->plugin_name = 'sf-api';
		$this->plugin_url = plugin_dir_url( $plugin_root );
		$this->plugin_path = plugin_dir_path( $plugin_root );
		$this->version = '1.0.0';
	}

	/**
	 * Register the actions and filters
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function run() {

		// include dependencies
		add_action( 'after_setup_theme', array( $this, 'setup_dependencies' ), 20, 0 );

	}


	/**
	 * Include dependencies
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function setup_dependencies() {

		if ( is_admin() ) {

			require(WP_SF_API_ABSPATH . 'includes/classes/admin/class-wp-sfapi-admin.php');
			//Create Wordpress admin options page
			$admin = new WP_Sfapi_Public_Admin($this->plugin_name, $this->plugin_path);
			$admin->create_admin();
		}


	}
}