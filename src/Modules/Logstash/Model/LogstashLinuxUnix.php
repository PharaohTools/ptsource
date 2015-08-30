<?php

Namespace Model;

class LogstashLinuxUnix extends Base {

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
           "logstash_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "logstash on Build Completion?"
            ),
            "ipaddress" => array(
                "type" => "text",
                "optional" => false,
                "name" => "Host Ip Address" ),
            "port" => array(
                "type" => "text",
                "optional" => false,
                "name" => "Port" ),
        );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "sendLog",
            )
        );
        return $ff ;
    }

     public function sendLog() {

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
        
        $mn = $this->getModuleName() ;
	    if (isset($pipeline["settings"][$mn]["logstash_enabled"]) && $pipeline["settings"][$mn]["logstash_enabled"] == "on") {
		$errno  = 0;
		$tmpfile = PIPEDIR.DS.$this->params["item"].DS."tmpfile";
		$str = array( "log" => file_get_contents($tmpfile),
						 "run-id" => $run,
						 "run-status" => $this->params["run-status"] );
		$str = json_encode($str);
		$fp = stream_socket_client("tcp://".$pipeline["settings"][$mn]["ipaddress"].":".$pipeline["settings"][$mn]["port"], $errno, $str, 30);
		if (!$fp) {
		    $logging->log ("Failed: Push to logstash", $this->getModuleName() ) ;
			return FALSE;
		}
		{
			$logging->log ("Success: Pushed in to logstash", $this->getModuleName() ) ;
			return TRUE;
		}
}
   else
  {
// @todo this should do something at max level debugging
//echo "logstash not run";
       return true;
}
    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }
}
