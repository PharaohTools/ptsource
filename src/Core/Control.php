<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {// print_r($pageVars);
    	$userPermissionClass = '\\Controller\\UserPermission';
		$userPermissionControlObject = new $userPermissionClass;
		session_start();
		if (!in_array($pageVars['route']['control'], array('Signup', 'OAuth', 'LDAP', 'AssetLoader'))) {
			if ($_SESSION["login-status"] === TRUE) {
				if ($userPermissionControlObject->execute($pageVars) == false) {
					$control = 'index';
					$pageVars['route']['control'] = 'index';
					$pageVars['route']['action'] = 'index';
				}
			}
			else {
				$control = 'Signup';
				$pageVars['route']['control'] = 'Signup';
				$pageVars['route']['action'] = 'login';
			}
		}
		$className = '\\Controller\\'.ucfirst($control);
    	$controlObject = new $className;
		return $controlObject->execute($pageVars);
		
    }

}