<?php

Namespace Model;

class BuildMoniterAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret = $this->getPipelinesDetails();
        return $ret ;
    }

    public function getPipelinesDetails() {
        $historyIndexFile = PIPEDIR . DS . $this -> params["item"] . DS . 'historyIndex';
		$historyIndexJson = file_get_contents($historyIndexFile);
		$historyIndex = json_decode($historyIndexJson);
		$success = $fail = $running = 0;
		foreach ($historyIndex as $value) {
			if (!isset($value->status))
				$running++;
			elseif ($value->status == "SUCCESS")
				$success++;
			elseif ($value->status == "FAIL")
				$fail++;
		}
        return array('item' => $this->params["item"], 'success' => $success, 'fail' => $fail, 'running' => $running, 'history' => $historyIndex ) ;
    }

}