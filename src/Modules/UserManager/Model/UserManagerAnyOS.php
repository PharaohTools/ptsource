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
        $myfile = fopen(__DIR__."/../../Signup/Data/users.txt", "r") or die("Unable to open file!");
        $oldData='';
        while(!feof($myfile))
        $oldData.=fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);
      return $oldData;
   }

}
