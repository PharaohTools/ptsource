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
			$logging->log("Pulling files from Docker repo", $this->getModuleName());
			//$auth = new Docker\Manager\ContainerManager;
	        require __DIR__ . '/../Libraries/vendor/autoload.php';
			$client = new \Docker\Http\DockerClient();//array(), 'tcp://127.0.0.1'
			$docker = new \Docker\Docker($client);
			$container = new \Docker\Container();//array('Image' => $this->params["build-settings"][$mn]["repository"].':precise')
			$docker->getContainerManager()->run($container);
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
