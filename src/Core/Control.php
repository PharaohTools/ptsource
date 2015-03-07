<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {// print_r($pageVars);
    	$userPermissionClass = '\\Controller\\UserPermission';
		$userPermissionControlObject = new $userPermissionClass;
		if ($userPermissionControlObject->execute($pageVars) == false)
		{
			$control = 'index';
			$pageVars['route']['control'] = 'index';
			$pageVars['route']['action'] = 'index';
		}
		$className = '\\Controller\\'.ucfirst($control);
    	$controlObject = new $className;
		return $controlObject->execute($pageVars);
		
    }

}