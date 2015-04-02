<?php

Namespace Model;

class OAuthLinuxUnix extends Base {
	// Compatibility
	public $os = array("any");
	public $linuxType = array("any");
	public $distros = array("any");
	public $versions = array("any");
	public $architectures = array("any");

	// Model Group
	public $modelGroup = array("Default");

	public function github_login() {

		$mn = $this -> getModuleName();
		$this -> params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
		$git_client_id = $this -> params["app-settings"]["mod_config"][$mn]["git_client_id"];
		$git_client_secret = $this -> params["app-settings"]["mod_config"][$mn]["git_client_secret"];
		$git_redirect_uri = $this -> params["app-settings"]["mod_config"][$mn]["git_redirect_uri"];

		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'http.php';
		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'oauth_client.php';
		$client = new \oauth_client_class;
		$client -> debug = false;
		$client -> debug_http = true;
		$client -> server = 'github';
		//github redirect uri
		$client -> redirect_uri = $git_redirect_uri;
		/*'http://'.$_SERVER['HTTP_HOST'].
		 dirname(strtok($_SERVER['REQUEST_URI'],'?')).'index.php?control=OAuth&action=githublogin';*/
		//client id
		$client -> client_id = $git_client_id;
		//client secret
		$client -> client_secret = $git_client_secret;
		if (strlen($client -> client_id) == 0 || strlen($client -> client_secret) == 0)
			die('Please go to github applications page ' . 'https://github.com/settings/applications/new in the API access tab, ' . 'create a new client ID, and ' . ' set the client_id to Client ID and client_secret with Client Secret. ' . 'The Callback URL must be ' . $client -> redirect_uri);
		/* API permissions */
		$client -> scope = 'user:email';
		if (($success = $client -> Initialize())) {
			if (($success = $client -> Process())) {
				if (strlen($client -> authorization_error)) {
					$client -> error = $client -> authorization_error;
					$success = false;
				} elseif (strlen($client -> access_token)) {
					$success = $client -> CallAPI('https://api.github.com/user', 'GET', array(), array('FailOnAccessError' => true), $user);
				}
			}
			$success = $client -> Finalize($success);
		}
		if ($client -> exit)
			exit ;
		if ($success) {
			$signupFactory = new \Model\Signup();
			$signup = $signupFactory -> getModel($this -> params);
			$signup -> loginByOAuth($user -> name, $user -> email, $user);
		} else {
			echo HtmlSpecialChars($client -> error);
		}
	}

	//login by google
	public function google_login() {

		$mn = $this -> getModuleName();
		$this -> params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
		$google_client_id = $this -> params["app-settings"]["mod_config"][$mn]["google_client_id"];
		$google_client_secret = $this -> params["app-settings"]["mod_config"][$mn]["google_client_secret"];
		$google_redirect_uri = $this -> params["app-settings"]["mod_config"][$mn]["google_redirect_uri"];

		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'http.php';
		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'oauth_client.php';
		$client = new \oauth_client_class;
		$client -> server = 'Google';
		// set the offline access only if you need to call an API
		// when the user is not present and the token may expire
		$client -> offline = true;
		$client -> debug = false;
		$client -> debug_http = true;
		//redirect uri
		$client -> redirect_uri = $google_redirect_uri;
		/*'http://' . $_SERVER['HTTP_HOST'] . dirname(strtok($_SERVER['REQUEST_URI'], '?')) . 'index.php?control=OAuth&action=googlelogin';*/
		//client id
		$client -> client_id = $google_client_id;
		//client secret
		$client -> client_secret = $google_client_secret;
		if (strlen($client -> client_id) == 0 || strlen($client -> client_secret) == 0)
			die('Please go to Google APIs console page ' . 'http://code.google.com/apis/console in the API access tab, ' . 'create a new client ID, and ' . ' set the client_id to Client ID and client_secret with Client Secret. ' . 'The callback URL must be ' . $client -> redirect_uri . ' but make sure ' . 'the domain is valid and can be resolved by a public DNS.');
		// API permissions
		$client -> scope = 'https://www.googleapis.com/auth/userinfo.email ' . 'https://www.googleapis.com/auth/userinfo.profile';
		if (($success = $client -> Initialize())) {
			if (($success = $client -> Process())) {
				if (strlen($client -> authorization_error)) {
					$client -> error = $client -> authorization_error;
					$success = false;
				} elseif (strlen($client -> access_token)) {
					$success = $client -> CallAPI('https://www.googleapis.com/oauth2/v1/userinfo', 'GET', array(), array('FailOnAccessError' => true), $user);
				}
			}
			$success = $client -> Finalize($success);
		}
		if ($client -> exit)
			exit ;
		if ($success) {
			print_r("entered");
			print_r($user);
			$signupFactory = new \Model\Signup();
			$signup = $signupFactory -> getModel($this -> params);
			$signup -> loginByOAuth($user -> name, $user -> email, $user);
		} else {
			echo HtmlSpecialChars($client -> error);
		}
	}

	// login by facebook
	public function fb_login() {

		$mn = $this -> getModuleName();
		$this -> params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
		$fb_client_id = $this -> params["app-settings"]["mod_config"][$mn]["fb_client_id"];
		$fb_client_secret = $this -> params["app-settings"]["mod_config"][$mn]["fb_client_secret"];
		$fb_redirect_uri = $this -> params["app-settings"]["mod_config"][$mn]["fb_redirect_uri"];

		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'http.php';
		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'oauth_client.php';
		$client = new \oauth_client_class;
		$client -> debug = false;
		$client -> debug_http = true;
		$client -> server = 'Facebook';
		//redirect uri
		$client -> redirect_uri = $fb_redirect_uri;
		/*'http://' . $_SERVER['HTTP_HOST'] . dirname(strtok($_SERVER['REQUEST_URI'], '?')) . 'index.php?control=OAuth&action=fblogin';*/
		//client id
		$client -> client_id = $fb_client_id;
		//client secret
		$client -> client_secret = $fb_client_secret;
		if (strlen($client -> client_id) == 0 || strlen($client -> client_secret) == 0)
			die('Please go to Facebook Apps page https://developers.facebook.com/apps , ' . 'create an application, and ' . ' set the client_id to App ID/API Key and client_secret with App Secret');
		/* API permissions */
		$client -> scope = 'email';
		if (($success = $client -> Initialize())) {
			if (($success = $client -> Process())) {
				if (strlen($client -> access_token)) {
					$success = $client -> CallAPI('https://graph.facebook.com/me', 'GET', array(), array('FailOnAccessError' => true), $user);
				}
			}
			$success = $client -> Finalize($success);
		}
		if ($client -> exit)
			exit ;
		if ($success) {
			$signupFactory = new \Model\Signup();
			$signup = $signupFactory -> getModel($this -> params);
			$signup -> loginByOAuth($user -> name, $user -> email, $user);
		} else {
			echo HtmlSpecialChars($client -> error);
		}
	}

	public function linkedin_login() {

		$mn = $this -> getModuleName();
		$this -> params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");
		$li_client_id = $this -> params["app-settings"]["mod_config"][$mn]["li_client_id"];
		$li_client_secret = $this -> params["app-settings"]["mod_config"][$mn]["li_client_secret"];
		$li_redirect_uri = $this -> params["app-settings"]["mod_config"][$mn]["li_redirect_uri"];

		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'http.php';
		require_once dirname(dirname(__FILE__)) . DS . 'Libraries' . DS . 'oauth_client.php';
		$client = new \oauth_client_class;
		$client -> debug = false;
		$client -> debug_http = true;
		$client -> server = 'LinkedIn';
		//redirect uri
		$client -> redirect_uri = $li_redirect_uri;
		/*'http://' . $_SERVER['HTTP_HOST'] . dirname(strtok($_SERVER['REQUEST_URI'], '?')) . 'index.php?control=OAuth&action=linkedinlogin';*/

		/*
		 * Was this script included defining the pin the
		 * user entered to authorize the API access?
		 */
		if (defined('OAUTH_PIN'))
			$client -> pin = OAUTH_PIN;

		//client id
		$client -> client_id = $li_client_id;
		//client secret
		$client -> client_secret = $li_client_secret;

		/*  API permission scopes
		 *  Separate scopes with a space, not with +
		 */
		$client -> scope = 'r_fullprofile r_emailaddress';

		if (strlen($client -> client_id) == 0 || strlen($client -> client_secret) == 0)
			die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , ' . 'create an application, and ' . ' set the client_id to Consumer key and client_secret with Consumer secret. ' . 'The Callback URL must be ' . $client -> redirect_uri) . ' Make sure you enable the ' . 'necessary permissions to execute the API calls your application needs.';
		if (($success = $client -> Initialize())) {
			if (($success = $client -> Process())) {
				if (strlen($client -> access_token)) {
					$success = $client -> CallAPI('https://api.linkedin.com/v1/people/~', 'GET', array('format' => 'json'), array('FailOnAccessError' => true), $user);
					$success = $client -> CallAPI('https://api.linkedin.com/v1/people/~/email-address', 'GET', array('format' => 'json'), array('FailOnAccessError' => true), $email);
				}
			}
			$success = $client -> Finalize($success);
		}
		if ($client -> exit)
			exit ;
		if (strlen($client -> authorization_error)) {
			$client -> error = $client -> authorization_error;
			$success = false;
		}
		if ($success) {
			$signupFactory = new \Model\Signup();
			$signup = $signupFactory -> getModel($this -> params);
			$signup -> loginByOAuth($user -> firstName, $email, $user);
		} else {
			echo HtmlSpecialChars($client -> error);
		}

	}

}
