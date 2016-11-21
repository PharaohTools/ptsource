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
        $collated_one = array() ;
        foreach ($this->getWebsites() as $oneStandardFeature => $details) {
            $collated_one = array_merge($collated_one, $this->getLink($details)) ;
            $collated_one = array_merge($collated_one, $this->getTitle($details)) ;
            $collated_one = array_merge($collated_one, $this->getImage()) ;
            $collated[] = $collated_one ;
            $collated_one = array() ; }
		return $collated;
	}

	public function setValues($vals) {
		$this->repositoryFeatureValues = $vals ;
	}

	public function setRepository($repository) {
		$this->repository = $repository ;
	}

    protected function getWebsites() {
        return $this->repositoryFeatureValues["websites"] ;
    }

	public function getLink($details) {
		$ff = array("link" => $details["url"]);
		return $ff ;
	}

	public function getTitle($details) {
        $ff = array("title" => $details["title"]);
		return $ff ;
	}

	public function getImage() {
		$ff = array("image" => '/Assets/Modules/WebsiteDisplayLink/images/visit_site.png');
		return $ff ;
	}

}
