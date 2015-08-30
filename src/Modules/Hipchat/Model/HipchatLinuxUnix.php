<?php

Namespace Model;

/*require __DIR__ . '/../vendor/autoload.php';
use GorkaLaucirica\HipchatAPIv2Client\Auth\OAuth2;
use GorkaLaucirica\HipchatAPIv2Client\Client;
use GorkaLaucirica\HipchatAPIv2Client\API\RoomAPI;
use GorkaLaucirica\HipchatAPIv2Client\Model\Message;*/

class HipchatLinuxUnix extends Base {

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
           "hipchat_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "hipchat on Build Completion?"
            ),
            "Token" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Token" ),
            "Room Id or Name" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Room Id or Name" ),
            "From" => array(
                "type" => "text",
                "optional" => true,
                "name" => "From" ),
        );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "sendNotify",
            ),
        );
        return $ff ;
    }
    public function sendNotify() {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $run = $this->params["run-id"];
        $file = PIPEDIR.DS.$this->params["item"].DS.'defaults';
        $defaults = file_get_contents($file) ;
        //$appdefaults = json_decode($defaults, true);
        $defaults = new \ArrayObject(json_decode($defaults));

        $file = PIPEDIR.DS.$this->params["item"].DS.'settings';
        $settings = file_get_contents($file) ;
        $appsettings = json_decode($settings, true);

        $file = PIPEDIR.DS.$this->params["item"].DS.'tmpfile';
        $tmpfile = file_get_contents($file) ;

        $pipeline = $this->getPipeline() ;
        //$buildsettings = $pipeline->getData();

        $mn = $this->getModuleName() ;
 if (isset($pipeline["settings"][$mn]["hipchat_enabled"]) && $pipeline["settings"][$mn]["hipchat_enabled"] == "on") {
        //require_once dirname(dirname(__FILE__)).DS.'vendor'.DS.'autoload.php';
        //require_once dirname(dirname(__FILE__)).DS.'vendor'.DS.'gorkalaucirica/hipchat-v2-api-client/GorkaLaucirica/HipchatAPIv2Client/Auth/OAuth2.
        require __DIR__ . '/../Libraries/vendor/autoload.php';
        require __DIR__ . '/../Libraries/vendor/gorkalaucirica/hipchat-v2-api-client/GorkaLaucirica/HipchatAPIv2Client/Auth/OAuth2.php';
        require __DIR__ . '/../Libraries/vendor/gorkalaucirica/hipchat-v2-api-client/GorkaLaucirica/HipchatAPIv2Client/Client.php';
        require __DIR__ . '/../Libraries/vendor/gorkalaucirica/hipchat-v2-api-client/GorkaLaucirica/HipchatAPIv2Client/API/RoomAPI.php';
        require __DIR__ . '/../Libraries/vendor/gorkalaucirica/hipchat-v2-api-client/GorkaLaucirica/HipchatAPIv2Client/Model/Message.php';
		$auth = new \GorkaLaucirica\HipchatAPIv2Client\Auth\OAuth2($pipeline["settings"][$mn]["Token"]);
		$client = new \GorkaLaucirica\HipchatAPIv2Client\Client($auth);
		$roomAPI = new \GorkaLaucirica\HipchatAPIv2Client\API\RoomAPI($client);
		$msg['id'] = $pipeline["settings"][$mn]["Room Id or Name"];
        $findme   = 'FAILED EXECUTION';
        $pos = strpos($tmpfile, $findme);
        if ($pos !== false) {
           echo "The string '$findme' was found in the execution steps";
           $status = "execution is faild";
} else {
          $status = "execution is success";
}		$msg['message'] = "Pipe Name: ".$this->params["item"]."\n Status: ".$status;
		$msg['from'] = $pipeline["settings"][$mn]["From"];
		$msg['date'] = time();
		$msg['message_format'] = "text";
		$msg['notify'] = false;
		$msg['color'] = 'random';
		$message = new \GorkaLaucirica\HipchatAPIv2Client\Model\Message($msg);
		$roomAPI->sendRoomNotification($pipeline["settings"][$mn]["Room Id or Name"], $message );
}
   else
  {
// @todo this should do something at max level debugging
//echo "hipchat not run";
       return true ;
}

}
    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
