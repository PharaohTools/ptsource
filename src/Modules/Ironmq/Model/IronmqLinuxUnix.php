<?php

Namespace Model;

class IronmqLinuxUnix extends Base {

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
           "ironmq_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "ironmq on Build Completion?"
            ),
            "token" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Token" ),
            "projectid" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Project Id" ),
            "queuename" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Queue Name" ),
         );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "sendMessage",
            ),
        );
        return $ff ;
    }

     public function sendMessage() {

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
	    if (isset($pipeline["settings"][$mn]["ironmq_enabled"]) && $pipeline["settings"][$mn]["ironmq_enabled"] == "on") {
              
        require __DIR__ . '/../Libraries/vendor/autoload.php';
		
		//require 'src/HttpException.php';
		//require 'src/IronCore.php';
		//require 'src/IronMQ.php';
		//require 'src/IronMQException.php';
		//require 'src/IronMQMessage.php';
		//require 'src/JsonException.php';
		
		$ironmq = new \IronMQ\IronMQ(array(
		    "token" => $pipeline["settings"][$mn]["token"],
		    "project_id" => $pipeline["settings"][$mn]["projectid"]
		));
		$ironmq->postMessage($pipeline["settings"][$mn]["queuename"], $tmpfile);
}
   else
  {
// @todo this should do something at max level debugging
//echo "ironmq not run";
       return true ;
}

	}

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
