<?php

Namespace Model;

class LDAPLinuxUnix extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "server" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Server Name" ),
            "root DN" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Root DN" ),
            "pass" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Password" ),
           );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "Login",
            ),
        );
        return $ff ;
    }

     public function Login() {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        $defaults = new \ArrayObject(json_decode($defaults));

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $settings = json_decode($settings, true);

        $file = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $tmpfile = file_get_contents($file) ;
        //$tmpfile = json_decode($tmpfile, true);
           
        $pipeline = $this->getPipeline() ;
        //$buildsettings = $pipeline->getData();

        $mn = $this->getModuleName() ;

        $ldaphost = $pipeline["settings"][$mn]["server"];
        $ldapUsername  = $pipeline["settings"][$mn]["root DN"];
        $ldapPassword = $pipeline["settings"][$mn]["pass"];

        $ds = ldap_connect($ldaphost);

        if(!ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)){
           echo "Could not set LDAPv3\r\n";
        }
        else {
        $bth = ldap_bind($ds, $ldapUsername, $ldapPassword) or die("\r\nCould not connect to LDAP server\r\n");
           //echo "connected to LDAP\n";
       }   
 
 	}

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
