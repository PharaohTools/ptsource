<?php

Namespace Model;

class DockerLinuxUnix extends Base {

	// Compatibility
	public $os = array("any");
	public $linuxType = array("any");
	public $distros = array("any");
	public $versions = array("any");
	public $architectures = array("any");

	// Model Group
	public $modelGroup = array("Default");

	public function getSettingTypes() {
		return array_keys($this -> getSettingFormFields());
	}

	public function getSettingFormFields() {
		$ff = array(
				"docker" => 
					array(
						"type" => "boolean", 
						"optional" => true, 
						"name" => "Enable Docker"), 
				"repository" => 
					array(
						"type" => "text", 
						"name" => "Repository", 
						"slug" => "repository"), 
				"commandToRun" => 
					array(
						"type" => "text", 
						"name" => "Command to Run", 
						"slug" => "commandToRun") 
				);
		return $ff;
	}

	public function getEventNames() {
		return array_keys($this->getEvents());
	}

	public function getEvents() {
		$ff = array("beforeBuildComplete" => array("pullFile"));
		return $ff;
	}

	public function pullFile() 
	{
		$loggingFactory = new \Model\Logging();
		$this->params["echo-log"] = true;
		$logging = $loggingFactory->getModel($this->params);
		$mn = $this->getModuleName();
		if (!isset($pipeline["settings"][$mn]["docker"]) ||
            (isset($pipeline["settings"][$mn]["docker"]) && $this->params["build-settings"][$mn]["docker"] != "on") ){
//			$logging->log("Docker Not enabled for build, ignoring...");
			return TRUE;
		}
		if (!$this->ensureInstalled() == false)
		{
//			$logging->log("Docker Not installed", $this->getModuleName());
			return false;
		}
		else {
			$logging->log("Running Docker ".$this->params["build-settings"][$mn]["repository"]. ' container');
			 if ($this->executeAndGetReturnCode('docker start '.$this->params["build-settings"][$mn]["repository"].' &') > 0) {
				$logging->log("Pulling image from Docker repo", $this->getModuleName());
				$this->executeAndOutput('docker pull '.$this->params["build-settings"][$mn]["repository"]); }
			$this->executeAndGetReturnCode('docker start '.$this->params["build-settings"][$mn]["repository"].' &');
			sleep(10);
			$container_id = $this->executeAndLoad("docker ps | grep ".$this->params["build-settings"][$mn]["repository"]." | awk '{print $1}'");
			echo $container_id;
			$logging->log("Running command inside ".$this->params["build-settings"][$mn]["repository"]. ' container');
			$container_id = str_replace(PHP_EOL, '', $container_id);
			$this->executeAndGetReturnCode('docker exec '.$container_id.' '.$this->params["build-settings"][$mn]["commandToRun"]);
			
			$logging->log('Stopping container');
			$rc = $this->executeAndGetReturnCode('docker stop '.$container_id);
			return ($rc["rc"]==0) ? true : false ;
		}
	}
	
	protected function ensureInstalled() {
        $rc = $this->executeAndGetReturnCode('sudo docker version') ;
		if ($rc["rc"] === 0)
			return true ;
		else {
			return false ; }
	}
}
