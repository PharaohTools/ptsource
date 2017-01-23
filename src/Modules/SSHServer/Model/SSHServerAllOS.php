<?php

Namespace Model;

class ApplicationInstanceAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    public function getEvents() {
        $ff = array(
            "afterApplicationConfigurationSave" => array(
                "createDefaultConfigurations",
            ),
        );
        return $ff ;
    }


    public function createDefaultConfigurations() {

        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);
        $mod_config = \Model\AppConfig::getAppVariable("mod_config") ;
        $full_options = array(
            "instance_id" => $this->getNewInstanceID(),
            "instance_title" => "Pharaoh Build Node",
            "organisation" => "A Pharaoh Tools Organization");
        $option_titles = array_keys($full_options);

        foreach ($option_titles as $option_title) {
            $opt = $mod_config["ApplicationInstance"][$option_title] ;
            if (!isset($opt) || $opt == "") {
                $mod_config["ApplicationInstance"][$option_title] = $full_options[$option_title] ;
                $logging->log("Creating default configuration for Application Instance {$option_title} ...", $this->getModuleName());
            }
        }

        $orig_config = \Model\AppConfig::getAppVariable("mod_config") ;
        if ($mod_config==$orig_config) {
            return true ;
        }
        $logging->log("Writing new default values", $this->getModuleName());
        \Model\AppConfig::setAppVariable("mod_config", $mod_config ) ;

        return true ;
    }

    protected function getNewInstanceID($length=16) {
        $uid = "" ;
        for ($i=0; $i<$length; $i++) {
            $avail_chars  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" ;
            $avail_chars .= "abcdefghijklmnopqrstuvwxyz" ;
            $avail_chars .= "0123456789" ;
//            $avail_chars .= "!£%^&*(){}+=_-<>" ;
            $char = rand(0,strlen($avail_chars)) ;
            $cur = substr($avail_chars, $char, 1) ;
            $uid .= $cur ; }
        return $uid ;
    }

}