<?php

Namespace Info;

class OAuthInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "login using OAuth/Home Page";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "OAuth" => array("githublogin","googlelogin","fblogin","linkedinlogin") );
    }

    public function routeAliases() {
      return array("oauth"=>"OAuth");
    }
	
	public function configuration() {
			
        return array(
        	"git"=> array("type" => "","default" => "", "label" => "Git-hub Oauth Credentials", ),
            "git_client_id"=> array("type" => "text", "default" => "", "label" => "Client ID", ),
            "git_client_secret"=> array("type" => "text", "default" => "", "label" => "Client Secret", ),
            "git_redirect_uri"=> array("type" => "text", "default" => "", "label" => "Redirect URI", ),
            
			"fb"=> array("type" => "","default" => "", "label" => "Facebook Oauth Credentials", ),
            "fb_client_id"=> array("type" => "text", "default" => "", "label" => "Client ID", ),
            "fb_client_secret"=> array("type" => "text", "default" => "", "label" => "Client Secret", ),
            "fb_redirect_uri"=> array("type" => "text", "default" => "", "label" => "Redirect URI", ),
            
            "li"=> array("type" => "","default" => "", "label" => "Linked-In Oauth Credentials", ),
            "li_client_id"=> array("type" => "text", "default" => "", "label" => "Client ID", ),
            "li_client_secret"=> array("type" => "text", "default" => "", "label" => "Client Secret", ),
            "li_redirect_uri"=> array("type" => "text", "default" => "", "label" => "Redirect URI", ),
        );
    }
	
    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command is part of Core - its the default route and only used for help and as an Intro really...
HELPDATA;
      return $help ;
    }

}
