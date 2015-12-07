<?php

Namespace Model;

class WebsiteDisplayLinkPipeFeatureAllOS extends Base {

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
		$ff = array("link" => $this->pipeFeatureValues["url"]);
		return $ff ;
	}

	public function getTitle() {
        $ff = array("title" => $this->pipeFeatureValues["title"]);
		return $ff ;
	}

	public function getImage() {
		$this->pipeFeatureValues["pipeline"] ;
		$ff = array("image" => '/Assets/Modules/WebsiteDisplayLink/images/visit_site.png');
		return $ff ;
	}

}
