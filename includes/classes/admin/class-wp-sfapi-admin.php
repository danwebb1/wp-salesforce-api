<?php
/**
 * This plugin class is used to create pages in the admin dashboard 
 */
class WP_Sfapi_Public_Admin {
	/**
	 * The string used to uniquely identify this plugin
	 * Set in WP_Sfapi_Public
	 * Used here for admin page url slug base
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_name;

	/**
	 * The path to the plugin root directory
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $plugin_path;

	/**
	 *
	 * Set the plugin name for admin page slug base
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $plugin_name, $plugin_path ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_path = $plugin_path;
	}
	/**
	 * Register the actions and filters
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function create_admin() {
		add_action( 'admin_menu', array( $this, 'sfapi_admin_menu' ), 10, 0 );
		add_action( 'admin_init', array( $this, 'sfapi_register_settings') );
	}
	/**
	 * Register Settings for options table
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function sfapi_register_settings() {
		register_setting('sfapi_settings', 'salesforce_credentials');
	}

	/**
	 * Create admin dashboard pages
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function sfapi_admin_menu() {
			
			//set the method for the add_menu_pages and add_submenu_pages  
			$create_page = array($this, 'sfapi_admin_page' );
			
			add_options_page( 'Salesforce', 'Salesforce', 'manage_options', $this->plugin_name, $create_page, '', 6  );
	
	}
	
	/**
	 * function to render admin dashboard pages
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	 public function sfapi_admin_page(){ 
		if ( !current_user_can( 'manage_options' ) )  {//check if user has admin privileges
            		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
       		} ?>
		
		<div class="wrap">
			<img src="/wp-content/plugins/wp-sfapi/assets/images/salesforce.png" style="width:150px;">
			<h3>Salesforce REST API credentials</h3>
				<form method="post" action="options.php">
				<?php settings_fields( 'sfapi_settings' );
                                      $options = get_option( 'salesforce_credentials' ); ?>
					<table class="form-table">
						<tr>
						      <th scope="row">Client ID</th>
							<td>
							    <fieldset>
								<label>
								     <input name="salesforce_credentials[client_id]" type="text" id="salesforce_client_id" value="<?php echo (isset($options['client_id']) && $options['client_id'] != '') ? $options['client_id'] : ''; ?>"/>
								</label>
							    </fieldset>
							</td>
						 </tr>
						<tr>
						      <th scope="row">Client Secret</th>
							<td>
							    <fieldset>
								<label>
								     <input name="salesforce_credentials[client_secret]" type="password" id="salesforce_client_secret" value="<?php echo (isset($options['client_secret']) && $options['client_secret'] != '') ? $options['client_secret'] : ''; ?>"/>
								</label>
							    </fieldset>
							</td>
						 </tr>
						<tr>
						      <th scope="row">Redirect URI</th>
							<td>
							    <fieldset>
								<label>
								     <input name="salesforce_credentials[redirect_uri]" type="text" id="salesforce_redirect_uri" value="<?php echo (isset($options['redirect_uri']) && $options['redirect_uri'] != '') ? $options['redirect_uri'] : ''; ?>"/>
								</label>
							    </fieldset>
							</td>
						 </tr>
						<tr>
						      <th scope="row">Salesforce Username</th>
							<td>
							    <fieldset>
								<label>
								     <input name="salesforce_credentials[sf_user]" type="text" id="salesforce_user" value="<?php echo (isset($options['sf_user']) && $options['sf_user'] != '') ? $options['sf_user'] : ''; ?>"/>
								</label>
							    </fieldset>
							</td>
						 </tr>
						<tr>
						      <th scope="row">Salesforce Password</th>
							<td>
							    <fieldset>
								<label>
								     <input name="salesforce_credentials[sf_pass]" type="password" id="salesforce_sf_pass" value="<?php echo (isset($options['sf_pass']) && $options['sf_pass'] != '') ? $options['sf_pass'] : ''; ?>"/>
								</label>
							    </fieldset>
							</td>
						 </tr>
						<tr>
						      <th scope="row">Mode</th>
							<td>
							    <fieldset>
								<label>
								     <select name="salesforce_credentials[test]" id="salesforce_sf_test">
									<option value="1" <?php if(isset($options['test']) && $options['test'] == '1'){ echo 'selected'; } ?>>Live</option>
									<option value="0" <?php if(isset($options['test']) && $options['test'] == '0'){ echo 'selected'; } ?>>Test - Sandbox</option>
								     </select>
								</label>
							    </fieldset>
							</td>
						 </tr>	
					</table>
                                      <input type="submit" value="Save" />
                                    </form>
		</div>
	<?php
	}
}
