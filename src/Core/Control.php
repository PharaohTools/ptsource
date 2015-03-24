<?php

Namespace Core ;

class Control {

    public function executeControl($control, $pageVars) {// print_r($pageVars);


//        $eventRunnerFactory = new \Model\EventRunner() ;
//        $eventRunner = $eventRunnerFactory->getModel($this->params) ;
//        $ev = $eventRunner->eventRunner("prepareBuild") ;
//        if ($ev == false) { return $this->failBuild() ; }

        // @todo use the above code here instead, to just run an event

    	$userPermissionClass = '\\Controller\\UserPermission';
		$userPermissionControlObject = new $userPermissionClass;
		session_start();
		if (!in_array($pageVars['route']['control'], array('Signup', 'OAuth', 'LDAP', 'AssetLoader', 'PipeRunner', 'ScheduledBuild'))) {
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