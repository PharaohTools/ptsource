<?php

Namespace Model;

class SVNLinuxUnix extends Base {

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
           "SVN_enabled" =>
            	array(
                "type" => "boolean",
                "optional" => true,
                "name" => "SVN on Build Completion?"
            ),
            "Repository" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Repository" ),
            "Username" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Username" ),
            "Password" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Password" ),
            "Destination" => array(
                "type" => "text",
                "optional" => true,
                "name" => "Destination" ),
        );

        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterBuildComplete" => array(
                "Checkout",
            ),
        );
        return $ff ;
    }
    public function Checkout() {

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
            if ($pipeline["settings"][$mn]["SVN_enabled"] == "on") {
                $cmd="svn checkout http://google-api-php-client.googlecode.com/svn/trunk/ google-api-php-client";
                $svn = shell_exec($cmd);
                echo $svn;
                $checkout = "svn export –force –username ".$pipeline["settings"][$mn]["Username"]." –password ".$pipeline["settings"][$mn]["Password"].
                    " ".$pipeline["settings"][$mn]["Repository"]." ".$pipeline["settings"][$mn]["Destination"];
                $result = _exec($checkout); }
           else {
                echo "SVN not run"; }

    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

    function _exec($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B ". $cmd, "r")); }
        else {
            exec($cmd . " > /dev/null &"); }
    }

}
