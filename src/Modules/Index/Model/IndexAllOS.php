<?php

Namespace Model;

class IndexAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function pipesDetail() {
        $pipelineFactory = new \Model\Pipeline() ;
        $pipeline = $pipelineFactory->getModel($this->params);
		$buildMonitorClass = new \Model\BuildMonitor() ;
        $total = $success = $fail = $unstable = 0;
		$buildHistory = array();
        foreach ($pipeline->getPipelines() as $key => $value) {
        	$this->params['item'] = $key;
        	$buildMonitor = $buildMonitorClass->getModel($this->params);
			$newPipeDetail = $buildMonitor->getPipelinesDetails();
			if ( isset($newPipeDetail['history']) ) {
				$newPipeDetailHistory = $newPipeDetail['history'];
				foreach ($newPipeDetailHistory as &$status)
					foreach ($status as $key => $value)
						$buildHistory[] = $status; }
			$total++;
            if ($value=="FAIL") { $fail++; }
            else { $success++; }
//            if ($value['last_status']) $success++;
//			else if ($value['last_fail']) $fail++;
        }
		return array( 'total' => $total, 'success' => $success, 'fail' => $fail, 'unstable' => 'N/A', 'buildHistory' => $buildHistory );
    }
    
    public function findModuleNames($params) {
        if (isset($this->params["compatible-only"]) && $this->params["compatible-only"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        if (isset($this->params["only-compatible"]) && $this->params["only-compatible"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        return $this->findAllModuleNames() ;
    }

    private function findAllModuleNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $moduleNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = (isset($array_keys[0])) ? $array_keys[0] : null ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $moduleNames[] = $miniRay ; }
        return $moduleNames;
    }

    private function findOnlyCompatibleModuleNames($params) {
        $allModules = $this->findAllModuleNames() ;
        $controllerBase = new \Controller\Base();
        $errors = $controllerBase->checkForRegisteredModels($params, $allModules) ;
        $compatibleModules = array();
        foreach($allModules as $oneModule) {
            if (!in_array($oneModule["command"], $errors)) {
                $compatibleModules[] = $oneModule ; } }
        return $compatibleModules;
    }

}