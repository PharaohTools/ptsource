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
            "enable" => array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable LDAP" ),
            "server" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Server Name" ),
            "base DN" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Base DN" ),
            "cn" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Common Name (cn)" ),
            "user" => array(
                "type" => "text",
                "optional" => true,
                "name" => "User" ),
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
      
        $pipeline = $this->getPipeline() ;
        //$buildsettings = $pipeline->getData();

        $mn = $this->getModuleName() ;
      
      if ($pipeline["settings"][$mn]["enable"] == "on") {

        $ldap_host = $pipeline["settings"][$mn]["server"];
        $base_dn = $pipeline["settings"][$mn]["base DN"];
        $filter = "(cn=".$pipeline["settings"][$mn]["cn"].")";
        $ldap_user  = $pipeline["settings"][$mn]["user"];
        $ldap_pass = $pipeline["settings"][$mn]["pass"];
        $connect = ldap_connect($ldap_host)
                      or exit("Could not connect to LDAP server");
        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
        $bind = ldap_bind($connect, $ldap_user, $ldap_pass)
                      or exit("Could not bind to $ldap_host");
        $read = ldap_search($connect, $base_dn, $filter)
                      or exit("Unable to search ldap server");
        $info = ldap_get_entries($connect, $read);
           echo $info["count"]." entries returned \n";
         $ii=0;
         for ($i=0; $ii<$info[$i]["count"]; $ii++){
             $data = $info[$i][$ii];
             echo $data.":".$info[$i][$data][0]."\n";
         }
       ldap_close($connect);
   }
   
   else {
       
       echo "LDAP not run\n Enable LDAP\n" ;
  	}

}
    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
