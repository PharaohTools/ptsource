<?php

Namespace Model;

class OAuthLinuxUnix extends Base {
    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function github_login(){	
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'http.php' ;
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'oauth_client.php' ;
	$client = new \oauth_client_class; 
	$client->debug = false;
	$client->debug_http = true;
	$client->server = 'github';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'index.php?control=OAuth&action=githublogin';//github redirect uri
	$client->client_id = '89afa4ffab6f492d5efc'; $application_line = __LINE__;//client id
	$client->client_secret = 'fc107e4a10532c61e3646846a2efc530c9f434c4';//client secret
	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to github applications page '.
			'https://github.com/settings/applications/new in the API access tab, '.
			'create a new client ID, and in the line '.$application_line.
			' set the client_id to Client ID and client_secret with Client Secret. '.
			'The Callback URL must be '.$client->redirect_uri);
	/* API permissions */ 
	$client->scope = 'user:email';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->authorization_error))
			{
				$client->error = $client->authorization_error;
				$success = false;
			}
			elseif(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://api.github.com/user',
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
	$signupFactory = new \Model\Signup() ;
    $signup = $signupFactory->getModel($this->params);
    $signup->loginByOAuth($user->name,$user->email,$user);
	}
	else
	{
	echo HtmlSpecialChars($client->error);
	}
}

/*   
  //login by google	
   public function google_login(){
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'http.php' ;
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'oauth_client.php' ;
	$client = new \oauth_client_class;
	$client->server = 'Google';
	// set the offline access only if you need to call an API
	// when the user is not present and the token may expire
	$client->offline = true;
	$client->debug = false;
	$client->debug_http = true;
	$client->redirect_uri = 'http://localhost/Git.php';//redirect uri
	$client->client_id = '818560188109-23t9hl1qrcj65k33biihhar98kpmmkbc.apps.googleusercontent.com'; //client id
	$application_line = __LINE__;
	$client->client_secret = 'X_7SsuUCglKyBJwEd7JTVCfh';//client secret
	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Google APIs console page '.
			'http://code.google.com/apis/console in the API access tab, '.
			'create a new client ID, and in the line '.$application_line.
			' set the client_id to Client ID and client_secret with Client Secret. '.
			'The callback URL must be '.$client->redirect_uri.' but make sure '.
			'the domain is valid and can be resolved by a public DNS.');
	// API permissions 
	$client->scope = 'https://www.googleapis.com/auth/userinfo.email '.
		'https://www.googleapis.com/auth/userinfo.profile';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->authorization_error))
			{
				$client->error = $client->authorization_error;
				$success = false;
			}
			elseif(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://www.googleapis.com/oauth2/v1/userinfo',
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
	$signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $signup->loginByOAuth($user->name,$user->email,$user);
	}
	else
	{
	echo HtmlSpecialChars($client->error);
	}
}
*/
   // login by facebook
   public function fb_login(){	
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'http.php' ;
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'oauth_client.php' ;
	$client = new \oauth_client_class;
	$client->debug = false;
	$client->debug_http = true;
	$client->server = 'Facebook';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'index.php?control=OAuth&action=fblogin';//redirect uri
	$client->client_id = '1579663978944722'; $application_line = __LINE__;//client id
	$client->client_secret = '4e12f5088ac2027eb7ed7f8d156b8926';//client secret
	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Facebook Apps page https://developers.facebook.com/apps , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to App ID/API Key and client_secret with App Secret');
	/* API permissions */
	$client->scope = 'email';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://graph.facebook.com/me', 
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
	$signupFactory = new \Model\Signup() ;
    $signup = $signupFactory->getModel($this->params);
    $signup->loginByOAuth($user->name,$user->email,$user);
	}
	else
	{
	echo HtmlSpecialChars($client->error);
	}
  }

  public function linkedin_login(){
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'http.php' ;
	require_once dirname(dirname(__FILE__)).DS.'Libraries'.DS.'oauth_client.php' ;
		$client = new \oauth_client_class;
        $client->debug = false;
        $client->debug_http = true;
        $client->server = 'LinkedIn';
        $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
                dirname(strtok($_SERVER['REQUEST_URI'],'?')).'index.php?control=OAuth&action=linkedinlogin';

        /*
         * Was this script included defining the pin the
         * user entered to authorize the API access?
         */
        if(defined('OAUTH_PIN'))
                $client->pin = OAUTH_PIN;

        $client->client_id = '75z4gtl00tiu80'; $application_line = __LINE__;
        $client->client_secret = 'yGEvyr4wEaoBLwOv';

        /*  API permission scopes
         *  Separate scopes with a space, not with +
         */
        $client->scope = 'r_fullprofile r_emailaddress';

        if(strlen($client->client_id) == 0
        || strlen($client->client_secret) == 0)
                die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
                        'create an application, and in the line '.$application_line.
                        ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                        'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.'necessary permissions to execute the API calls your application needs.';
		if(($success = $client->Initialize()))
        {
                if(($success = $client->Process()))
                {
                        if(strlen($client->access_token))
                        {
                                $success = $client->CallAPI(
                                        'https://api.linkedin.com/v1/people/~',
                                        'GET', array(
                                                'format'=>'json'
                                        ), array('FailOnAccessError'=>true), $user);
								$success = $client->CallAPI(
                                        'https://api.linkedin.com/v1/people/~/email-address', 
                                        'GET', array(
                                                'format'=>'json'
                                        ), array('FailOnAccessError'=>true), $email);
                        }
                }
                $success = $client->Finalize($success);
        }
        if($client->exit)
                exit;
        if(strlen($client->authorization_error))
        {
                $client->error = $client->authorization_error;
                $success = false;
        }
        if($success)
		{
		$signupFactory = new \Model\Signup() ;
		$signup = $signupFactory->getModel($this->params);
		$signup->loginByOAuth($user->firstName,$email,$user);     
        }
        else
        {
		echo HtmlSpecialChars($client->error);
        }

	}

}
