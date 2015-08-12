<?php

Namespace Model;

class PublishHTMLreportsPipeFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("PipeFeature") ;

	public $pipeFeatureValues;

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

	public function getLink() {
		$this->pipeFeatureValues["pipeline"] ;
		$ff = array("link" => "http://www.google.com");
		return $ff ;
	}

	public function getTitle() {
		$this->pipeFeatureValues["pipeline"] ;
		$ff = array("title" => $this->pipeFeatureValues["Report_Title"]);
		return $ff ;
	}

	public function getImage() {
		$this->pipeFeatureValues["pipeline"] ;
		$ff = array("image" => 'http://www.pharaohtools.com/images/logo-pharaoh.png');
		return $ff ;
	}

}
