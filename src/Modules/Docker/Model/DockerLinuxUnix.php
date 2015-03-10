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
		if ($this->params["build-settings"][$mn]["docker"] != "on"){
			$logging->log("Docker Not enabled for build, ignoring...");
			return TRUE;
		}
		if (!$this->ensureInstalled() == 'not installed')
		{
			$logging->log("Docker Not installed", $this->getModuleName());
			return false;
		}
		else {
			//$auth = new Docker\Manager\ContainerManager;
	        /*require __DIR__ . '/../Libraries/vendor/autoload.php';
			$client = new \Docker\Http\DockerClient();//array(), 'tcp://127.0.0.1'
			$docker = new \Docker\Docker($client);
			$container = new \Docker\Container();//array('Image' => $this->params["build-settings"][$mn]["repository"].':precise')
			$docker->getContainerManager()->run($container);
			*/
			//$this->executeAndGetReturnCode('docker pull '.$this->params["build-settings"][$mn]["repository"]);
			
			$logging->log("Pulling image from Docker repo", $this->getModuleName());
			//$this->executeAndOutput('docker pull '.$this->params["build-settings"][$mn]["repository"]);
			
			$logging->log("Running Docker ".$this->params["build-settings"][$mn]["repository"]. ' container');
			$this->executeAndGetReturnCode('docker run -i -t '.$this->params["build-settings"][$mn]["repository"].' &');// /bin/bash
			
			
			$logging->log("Running command inside ".$this->params["build-settings"][$mn]["repository"]. ' container');
			///tmp/execWorks
			$this->executeAndGetReturnCode('docker exec -d '.$this->params["build-settings"][$mn]["repository"].' '.$this->params["build-settings"][$mn]["commandToRun"]);
			
			$logging->log('Stoping container');
			$this->executeAndGetReturnCode('docker stop '.$this->params["build-settings"][$mn]["repository"]);
			return TRUE;
		}
	}
	
	protected function ensureInstalled()
	{
		if ($this->executeAndGetReturnCode('sudo docker version') == 0 )
			return 'installed';
		else{
			return 'not installed';	
		}
	}
}
