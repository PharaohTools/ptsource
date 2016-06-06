<?php

Namespace Model;

class SCMPublishOnSaveAllOS extends Base {

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
            "enabled" =>
            	array(
                	"type" => "boolean",
                	"optional" => true,
                	"name" => "Copy configuration on Pipeline save?" ),
		    "target_repository" =>
				array("type" => "text",
					 "name" => "Target Repository",
					 "slug" => "target_repository") ,
//		    "Index_Page" =>
//				array("type" => "text",
//					 "name" => "Index Page",
//					 "slug" => "indexpage"),
//			"Report_Title" =>
//				array("type" => "text",
//					 "name" => "Report Title",
//					 "slug" => "reporttitle")
        );
          return $ff ;
    }
   
    public function getEventNames() {
        return array_keys($this->getEvents());
    }

	public function getEvents() {
		$ff = array("afterPipelineSave" => array("scmPublishOnSave"));
		return $ff ;
    }

	public function scmPublishOnSave() {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params);

        $this->pipeline = $this->getPipeline();
        $this->params["build-settings"] = $this->pipeline["settings"];
        $this->params["app-settings"]["app_config"] = \Model\AppConfig::getAppVariable("app_config");
        $this->params["app-settings"]["mod_config"] = \Model\AppConfig::getAppVariable("mod_config");

        $files_to_copy = array("settings", "steps", "defaults");
        $mn = $this->getModuleName() ;

        if (isset($this->params["build-settings"][$mn]["enabled"]) && $this->params["build-settings"][$mn]["enabled"] == "on") {
            $logging->log("SCM Publish On Save enabled for pipeline...", $this->getModuleName());
            $dir = $this->params["build-settings"][$mn]["target_directory"] ;
            if ($dir == "") {
                $logging->log("SCM Publish On Save enabled, but no directory has been specified.", $this->getModuleName());
                return false ; }
            if (substr($dir, -1) != DS) { $dir = $dir . DS ; }
            $pipeline_path = PIPEDIR.DS.$this->params["item"].DS ;
            $full_dir = $dir.DS.$this->params["item"].DS ;
            if (!file_exists($full_dir)) {
                $logging->log("Creating target directory {$full_dir}", $this->getModuleName());
                $copy_command = "mkdir -p {$full_dir}" ;
                $rc = $this->executeAndGetReturnCode($copy_command, true, true) ;
                if ($rc["rc"] !== 0) {
                    $logging->log("Creating target directory {$full_dir} unsuccessful", $this->getModuleName());
                    return false ; } }
            foreach ($files_to_copy as $file_to_copy) {
                $source = $pipeline_path.$file_to_copy ;
                $target = $dir.$this->params["item"].DS.$file_to_copy ;
                $logging->log("Copying {$source} to {$target}", $this->getModuleName());
                $copy_command = "cp -r {$source} {$target}" ;
                $rc = $this->executeAndGetReturnCode($copy_command, true, true) ;
                if ($rc["rc"] !== 0) {
                    $logging->log("SCM Publish unsuccessful", $this->getModuleName());
                    return false ; } }
            return true ; }
    }

    private function getPipeline() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
        return $pipeline->getPipeline($this->params["item"]);
    }

}
