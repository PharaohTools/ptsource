<?php

Namespace Model;

class UserPermissionAllOS extends Base {

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
			"authenticate" => array(
				"authenticateUser",
			),
		);
		return $ff ;
	}
	
	public function checkForAccess($route) {
		$control = $route['control'];
		$action = $route['action'];
		// 1 is top prority admin
        // @todo change bigboss.
		$userInGroup = array('bigboss' => 1);
		
		$groupCannotAccess[2] = array( 'UserManager' => array('show') );
		$groupCannotAccess[3] = array( 'BuildConfigure' => array('new','save'),
									   'PipeRunner'     => array('start') );
		$status = isset($_SESSION['login-status']) ? $_SESSION['login-status'] : "";
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
		if ($status == TRUE) {
			if ($userInGroup[$username] == 1) {
				return TRUE; }
            else {
				if ( isset($groupCannotAccess[$userInGroup[$username]][$control]) )
					return $this->checkForActionAccess($groupCannotAccess[$userInGroup[$username]][$control], $action); } }
		return TRUE;
	}

	private function checkForActionAccess($actions, $action) {
		foreach ($actions as $value) {
			if (strtolower($value) == strtolower($action)) {
				return FALSE; } }
		return TRUE;
	}

	public function authenticateUser() {
        $signupFactory = new \Model\Signup();
        $signup = $signupFactory->getModel($this->params) ;
        $loginstatus = $signup->checkLoginSession() ;
		return $loginstatus["status"];
	}

}