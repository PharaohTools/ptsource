<?php

Namespace Model;

class MongodbLinuxUnix extends Base {

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
           "Mongodb_enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "Mongodb on Build Completion?"
            ),

            "host" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Host Name" ),
            "dbname" => array(
                "type" => "text",
                "optional" => true,
                "name" => "DB Name" ),
            "collection" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Collection Name" ),
            "path" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Path for Json File" ),
            "title" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Title" ),
         );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                 "uploadDocument",
            ),
        );
        return $ff ;
    }

     public function uploadDocument() {

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
        if (isset($pipeline["settings"][$mn]["Mongodb_enabled"]) && $pipeline["settings"][$mn]["Mongodb_enabled"] == "on") {
            $m = new \MongoClient($pipeline["settings"][$mn]["host"]);
            //$m = new MongoClient(mongodb://$host);
            
            echo "Connection to database successfully \n";
            $db = $m->$pipeline["settings"][$mn]["dbname"];
            echo "Database mydb selected \n";
            $collection = $db->$pipeline["settings"][$mn]["collection"];
            echo "Collection selected succsessfully \n";

            $document = array( 
               "title" => $pipeline["settings"][$mn]["title"],
               "build report" => $tmpfile,
               "json document content" => file_get_contents($pipeline["settings"][$mn]["path"]),
               "time" => date("Y-m-d h:i:sa", time()),
		
            );
               $collection->insert($document);
               echo "Document inserted successfully \n";
}
   else
  {
// @todo this should do something at max level debugging
//echo "Mongodb not run";
       return true ;
}

	}

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
