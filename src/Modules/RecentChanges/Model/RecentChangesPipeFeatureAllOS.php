<?php

Namespace Model;

class RecentChangesPipeFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipeFeature") ;

	public $pipeFeatureValues;
	public $pipeline;

	public function collate() {
		$collated = array() ;
		$collated = array_merge($collated, $this->getLink()) ;
		$collated = array_merge($collated, $this->getTitle()) ;
		$collated = array_merge($collated, $this->getImage()) ;
		return $collated ;
	}

	public function setValues($vals) {
		$this->pipeFeatureValues = $vals ;
	}

	public function setPipeline($pipe) {
		$this->pipeline = $pipe ;
	}

	public function getLink() {
		$link = 'index.php?control=RecentChanges&action=report&item='.$this->pipeline["project-slug"];
		$ff = array("link" => "$link");
		return $ff ;
	}

	public function getTitle() {
		$ff = array("title" => $this->pipeFeatureValues["Report_Title"]);
		return $ff ;
	}

	public function getImage() {
		$this->pipeFeatureValues["pipeline"] ;
		$ff = array("image" => 'http://www.pharaohtools.com/images/logo-pharaoh.png');
		return $ff ;
	}

}
