<?php

Namespace Model;

class SSHLinuxUnix extends Base {

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
           "ssh_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "ssh on Build Completion?"
            ),
            "username" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Username" ),
            "password" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Password" ),
            "ipaddress" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Ip Address" ),
            "sourcefilepath" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Source File Path" ),
            "destinationfilepath" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Destination File Path" ),
        );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "sendFile",
            ),
        );
        return $ff ;
    }

     public function sendFile() {

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
	    if (isset($pipeline["settings"][$mn]["ssh_enabled"]) && $pipeline["settings"][$mn]["ssh_enabled"] == "on") {
    
       if (!function_exists("ssh2_connect"))
		{
		    echo "ssh2_connect doesn't exist";
		    return false;
		}
		
		$con = ssh2_connect($pipeline["settings"][$mn]["ipaddress"], 22);
		
		if(!($con = ssh2_connect($pipeline["settings"][$mn]["ipaddress"], 22))){
		    echo "unable to establish connection\n";
		} 
		else {
		
		    if(!ssh2_auth_password($con, $pipeline["settings"][$mn]["username"], $pipeline["settings"][$mn]["password"])) {
		        echo "unable to authenticate\n";
		    } 
		    else {
		
		        echo "logged in...\n";
		
				if (!ssh2_scp_send($con, $pipeline["settings"][$mn]["sourcefilepath"], $pipeline["settings"][$mn]["destinationfilepath"], 0644)) {
		            echo "Unable to send file\n";
		        } 
		        else {
		            echo "File sent\n";
					return true;
		        }
		    }
		}
}
   else
  {
// @todo this should do something at max level debugging
//      echo "ssh not run";
      return true ;
}
	
  }
    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }


}
