<?php
/**
 * @since 1.0.0
 *
 * Plugin Name: Wordpress Salesforce API Starter
 * Description: Basic Salesforce API plugin. Save and manage your Salesforce API credentials using Wordpress admin interface. Connect to the Salesforce API and start coding based on your individual Salesforce build
 * Version: 1.0
 * Author: Dan Webb
 */

//Wordpress security measure
defined( 'ABSPATH' ) OR exit;

//Plugin path
define( 'WP_SF_API_ABSPATH', dirname( __FILE__ ) . '/' );

/**
* This is the core plugin class that is used to initialize and set admin specific hooks
*/
require(WP_SF_API_ABSPATH . 'includes/classes/class-wp-sfapi-public.php');

/**
* This is the Salesforce login class that is used to initialize integration with Salesforce
*/
require(WP_SF_API_ABSPATH . 'includes/classes/class-wp-sfapi-Oauth.php');


/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function run_wp_sfapi_public() {

	$plugin = new WP_Sfapi_Public( __FILE__ );
	$plugin->run();

}
run_wp_sfapi_public();

/**
* Connect to Salesforce API
*
* @since 1.0.0
* @access public
* @return array
*/
function salesforce_connect() {
	
	//get Salesforce API credentials 
	$options = get_option( 'salesforce_credentials' );

	if($options['test'] == 1)
		$login_url = 'https://login.salesforce.com';
	else	
		$login_url = 'https://test.salesforce.com';
		
	
	//connect to SalesForce
	$salesforce_instance = new WP_Sfapi_Oauth($options['client_id'],$options['client_secret'],$options['redirect_uri'],$login_url,$options['sf_user'],$options['sf_pass']);
	$tokens = $salesforce_instance->get_tokens();
	return $tokens;

}

/*
*
*	README: THIS IS AN EXAMPLE SALESFORCE API CALL TO SHOW ALL THE INSTANCES OF A CUSTOM OBJECT IN YOUR SALESFORCE ACCOUNT
*			ONCE YOU HAVE CONNECTED TO THE SALESFORCE API VIA THE salesforce_connect() FUNCTION AND RETURNED YOUR ACCESS TOKEN 
*			AND INSTANCE URL. YOU CAN BEGIN MAKING CALLS TO THE API USING FUNCTIONS LIKE THIS. YOU MAY ALSO SUBSTITUTE cURL FOR 
*			ANOTHER HTTP CLIENT LIKE GUZZLE (http://docs.guzzlephp.org/en/stable/)
*
*			SEE SALESFORCE API DOCS FOR MORE INFORMATION (https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/intro_what_is_rest_api.htm)
*
*
*	function show_[Salesforce Object]($instance_url, $access_token, $url = NULL) {
*
*		$query = "SELECT Id from [Salesforce Object] where [Object Property] = 'value' Order By [propery] DESC";
*
*		if( !isset($url) )
*			$url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
*
*		$curl = curl_init($url);
*		curl_setopt($curl, CURLOPT_HEADER, false);
*		curl_setopt($curl, CURLOPT_HTTPHEADER,
*				array("Authorization: OAuth $access_token"));
*
*		$json_response = curl_exec($curl);
*		curl_close($curl);
*
*		$response = json_decode($json_response, true);
*		return $response;
*
*	}
*
*
*/







