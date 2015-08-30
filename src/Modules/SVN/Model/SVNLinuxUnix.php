<?php

Namespace Model;

class SVNLinuxUnix extends Base {

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
		$ff = array("SVN_enabled" => array("type" => "boolean", "optional" => true, "name" => "SVN on Build Completion?"), "With_UNPWD" => array("type" => "boolean", "optional" => true, "name" => "With Credential?"), "Repository" => array("type" => "text", "optional" => true, "name" => "Repository"), "TargetPath" => array("type" => "text", "optional" => true, "name" => "TargetPath"), "Without_UNPWD" => array("type" => "boolean", "optional" => true, "name" => "Skip Credential"), "Username" => array("type" => "text", "optional" => true, "name" => "Username"), "Password" => array("type" => "text", "optional" => true, "name" => "Password"), );

		return $ff;
	}

	public function getEventNames() {
		return array_keys($this -> getEvents());
	}

	public function getEvents() {
		$ff = array("afterBuildComplete" => array("Checkout", ), );
		return $ff;
	}

	public function Checkout() {

		$loggingFactory = new \Model\Logging();
		$this -> params["echo-log"] = true;
		$logging = $loggingFactory -> getModel($this -> params);

		$run = $this -> params["run-id"];
		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'defaults';
		$defaults = file_get_contents($file);
		$defaults = new \ArrayObject(json_decode($defaults));

		$file = PIPEDIR . DS . $this -> params["item"] . DS . 'settings';
		$settings = file_get_contents($file);
		$settings = json_decode($settings, true);

		$pipeline = $this -> getPipeline();
		//$buildsettings = $pipeline->getData();

		$mn = $this -> getModuleName();

		if (isset($pipeline["settings"][$mn]["SVN_enabled"]) && $pipeline["settings"][$mn]["SVN_enabled"] == "on") {
			if ($pipeline["settings"][$mn]["With_UNPWD"] == "on") {
				$cmd = "svn checkout " . $pipeline["settings"][$mn]["Repository"] . " --username=" . $pipeline["settings"][$mn]["Username"] . " --password=" . $pipeline["settings"][$mn]["Password"] . "";
				$svn = shell_exec($cmd);
				$logging -> log(" $svn ", $this -> getModuleName());
				$cmd1 = "svn add " . $pipeline["settings"][$mn]["TargetPath"] . "";
				$svn1 = shell_exec($cmd1);
				$logging -> log($svn1, $this -> getModuleName());
				;
				$logging -> log(" File is added ", $this -> getModuleName() . '\n');
				$cmd2 = "svn commit -m --force-log --username=" . $pipeline["settings"][$mn]["Username"] . " --password=" . $pipeline["settings"][$mn]["Password"] . " --non-interactive " . $pipeline["settings"][$mn]["TargetPath"] . "";
				$svn2 = shell_exec($cmd2);
				$logging -> log(" $svn2 file is commited", $this -> getModuleName() . '\n');
				$cmd3 = "svn update " . $pipeline["settings"][$mn]["TargetPath"] . "";
				$svn3 = shell_exec($cmd3);
				$logging -> log(" $svn3 File is Updated", $this -> getModuleName() . '\n');
			} else {
				$cmd = "svn checkout " . $pipeline["settings"][$mn]["Repository"] . "";
				$svn = shell_exec($cmd);
				$logging -> log($svn, $this -> getModuleName());
			}
		} else {
            // @todo this should do something at max level debugging
            //$logging -> log("SVN not run", $this -> getModuleName());
            return true ;
		}

	}

	private function getPipeline() {
		$pipelineFactory = new \Model\Pipeline();
		$pipeline = $pipelineFactory -> getModel($this -> params);
		return $pipeline -> getPipeline($this -> params["item"]);
	}

}
