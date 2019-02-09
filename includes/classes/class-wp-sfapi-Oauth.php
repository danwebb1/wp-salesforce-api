<?php

/**
* This is the class so connect with the Salesforce REST API using OAuth 
*/

class WP_Sfapi_Oauth{

	 /**
	 * Client ID for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $client_id;

	/**
	 * Client Secret for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $client_secret;
	

	/**
	 * Redirect URI for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $redirect_uri;

	/**
	 * Login URI for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $login_uri;

	/**
	 * Username for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $salesforce_user;

	/**
	 * Password for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	public $salesforce_pass;

	/**
	 * Instance URL for Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	protected $instance_url;

	/**
	 * Salesforce Access Token
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	protected $access_token;

	/**
	 * Salesforce Access Token and Instance URL
	 *
	 * @since 1.0.0
	 * @access public
	 * @var array
	 */
	public $tokens = array();

	/**
	 *
	 * Set the Salesforce API OAuth credentials
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function __construct( $client_id, $client_secret, $redirect_uri, $login_uri, $salesforce_user, $salesforce_pass  ) {

		$this->client_id 	 	 = $client_id;
		$this->client_secret     = $client_secret;
		$this->redirect_uri 	 = $redirect_uri;
		$this->login_uri 	 	 = $login_uri;
		$this->salesforce_user   = $salesforce_user;
		$this->salesforce_pass   = $salesforce_pass;
	}

	
	/**
	 *
	 * Login to Salesforce
	 *
	 * @since 1.0.0
	 * @access public
	 */
	
	public function get_tokens(){

		$params  = array(
			'grant_type' 	=> 'password',
			'client_id'  	=> $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $this->salesforce_user,
			'password'      => $this->salesforce_pass
		);

		$headers = array(
        		'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8'
    		);
	
		$token_url      = $this->login_uri . '/services/oauth2/token';

    	$curl = curl_init($token_url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);	    		
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    	curl_setopt($curl, CURLOPT_POST, true);
	    	curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
	    $json_response = curl_exec($curl);
	    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
		if ( $status != 200 ) {
			$args = array(
				'response' => $json_response, 
				'content'  => $status
			);
	    }
	    curl_close($curl);
			
	    
		$token = json_decode($json_response, true);

		//set instance URL
		$this->instance_url = $token['instance_url'];
		//set access token
		$this->access_token = $token['access_token'];

		if($this->instance_url && $this->access_token){
			array_push($this->tokens, $this->instance_url);
			array_push($this->tokens, $this->access_token);

			return $this->tokens;
		}else{
			return false;
		}
	}
}
	  



	
