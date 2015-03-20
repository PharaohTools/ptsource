<?php

Namespace Model;

class UserManagerAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
        $this->autopilotDefiner = "UserManager";
        $this->programNameMachine = "usermanager"; // command and app dir name
        $this->programNameFriendly = " UserManager "; // 12 chars
        $this->programNameInstaller = "UserManager";
        $this->initialize();
	}

    public function getUserDetails() {
		$signupFactory = new \Model\Signup();
		$signup = $signupFactory->getModel($this->params);
		$oldData=$signup->getUsersData();
        return $oldData;
	}
   
   public function changeRole(){
		$oldData=$this->getUserDetails();
		foreach($oldData as $key => $data){
			if($data->username==$_GET["username"] && $data->email==$_GET["email"]){
				$data->username=$_GET["username"];
				$data->email=$_GET["email"];
				$data->role=$_GET["role"];
				$oldData[$key] = $data;
			}
		}
		$myfile = fopen(__DIR__."/../../Signup/Data/users.txt", "w") or die("Unable to open file!");
		fwrite($myfile, json_encode($oldData));
	    fclose($myfile);
    }
    
    public function checkRole(){
		$oldData=$this->getUserDetails();
		foreach($oldData as $data){
			if($data->username==$_SESSION["username"]){
				if($data->role=1)
				return TRUE;
		     }
		}
	}
	
	public function removeUser(){
		$oldData=$this->getUserDetails();
		foreach($oldData as $key => $data){
			if($data->username==$_GET["username"] && $data->email==$_GET["email"]){
			$data->restrict=1;
				$oldData[$key] = $data;
			}
		}
		$myfile = fopen(__DIR__."/../../Signup/Data/users.txt", "w") or die("Unable to open file!");
		fwrite($myfile, json_encode($oldData));
	    fclose($myfile);
	}
	
	public function addUser(){
		$oldData=$this->getUserDetails();
		foreach($oldData as $key => $data){
			if($data->username==$_GET["username"] && $data->email==$_GET["email"]){
			$data->restrict=0;
				$oldData[$key] = $data;
			}
		}
		$myfile = fopen(__DIR__."/../../Signup/Data/users.txt", "w") or die("Unable to open file!");
		fwrite($myfile, json_encode($oldData));
	    fclose($myfile);
	}
}
