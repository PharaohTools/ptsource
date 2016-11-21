<?php

Namespace Model;

class WebsiteDisplayLinkRepositoryFeatureAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryFeature") ;

	public $repositoryFeatureValues;
	public $repository;

	public function collate() {
		$collated = array() ;
		$collated = array_merge($collated, $this->getLink()) ;
		$collated = array_merge($collated, $this->getTitle()) ;
		$collated = array_merge($collated, $this->getImage()) ;
		return array($collated );
	}

	public function setValues($vals) {
		$this->repositoryFeatureValues = $vals ;
	}

	public function setRepository($repository) {
		$this->repository = $repository ;
	}

	public function getLink() {
		$ff = array("link" => $this->repositoryFeatureValues["url"]);
		return $ff ;
	}

	public function getTitle() {
        $ff = array("title" => $this->repositoryFeatureValues["title"]);
		return $ff ;
	}

	public function getImage() {
		$this->repositoryFeatureValues["repository"] ;
		$ff = array("image" => '/Assets/Modules/WebsiteDisplayLink/images/visit_site.png');
		return $ff ;
	}

}
