<?php

Namespace Model;

class StandardFeaturesDisplayLinkAllOS extends Base {

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
        foreach ($this->getEnabledStandardFeatures() as $oneStandardFeature) {
            $collated_one = array_merge($collated_one, $this->getLink($oneStandardFeature)) ;
            $collated_one = array_merge($collated_one, $this->getTitle($oneStandardFeature)) ;
            $collated_one = array_merge($collated_one, $this->getImage($oneStandardFeature)) ;
            $collated[] = $collated_one ;
            $collated_one = array() ; }
		return $collated ;
	}

	public function setValues($vals) {
		$this->repositoryFeatureValues = $vals ;
	}

	public function setRepository($repository) {
		$this->repository = $repository ;
	}

    protected function getAllStandardFeatures() {
        $sf = array(
            "php_enabled","html_enabled","ptvirtualize_enabled",
            "ptconfigure_enabled", "pttest_enabled",  "pttrack_enabled",
            "ptbuild_enabled", "ptdeploy_enabled", "ptmanage_enabled" ) ;
        return $sf ;
    }

    protected function getEnabledStandardFeatures() {
        $sf = $this->getAllStandardFeatures();
        $esf = array() ;
        foreach ($sf as $one_sf) {
            if (array_key_exists($one_sf, $this->repositoryFeatureValues) && $this->repositoryFeatureValues[$one_sf] == "on") {
                $esf[] = $one_sf ; } }
        return $esf ;
    }

    public function getLink($oneStandardFeature) {
        if ($oneStandardFeature== "php_enabled") {
            $ff = array("link" => "http://www.php.net"); }
        else if ($oneStandardFeature== "html_enabled") {
            $ff = array("link" => "http://www.w3techs.org"); }
        else if ($oneStandardFeature== "ptvirtualize_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/virtualize"); }
        else if ($oneStandardFeature== "ptconfigure_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/configure"); }
        else if ($oneStandardFeature== "ptsource_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/source"); }
        else if ($oneStandardFeature== "pttest_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/test"); }
        else if ($oneStandardFeature== "pttrack_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/track"); }
        else if ($oneStandardFeature== "ptbuild_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/build"); }
        else if ($oneStandardFeature== "ptdeploy_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/deploy"); }
        else if ($oneStandardFeature== "ptmanage_enabled") {
            $ff = array("link" => "http://www.pharaohtools.com/manage"); }
        else {
            $ff = array("link" => "http://www.pharaohtools.com"); }
        return $ff ;
    }

	public function getTitle($oneStandardFeature) {
        if ($oneStandardFeature== "php_enabled") {
            $ff = array("title" => "PHP"); }
        else if ($oneStandardFeature== "html_enabled") {
            $ff = array("title" => "HTML"); }
        else if ($oneStandardFeature== "ptvirtualize_enabled") {
            $ff = array("title" => "Pharaoh Virtualize"); }
        else if ($oneStandardFeature== "ptconfigure_enabled") {
            $ff = array("title" => "Pharaoh Configure"); }
        else if ($oneStandardFeature== "ptsource_enabled") {
            $ff = array("title" => "Pharaoh Source"); }
        else if ($oneStandardFeature== "pttest_enabled") {
            $ff = array("title" => "Pharaoh Test"); }
        else if ($oneStandardFeature== "pttrack_enabled") {
            $ff = array("title" => "Pharaoh Track"); }
        else if ($oneStandardFeature== "ptbuild_enabled") {
            $ff = array("title" => "Pharaoh Build"); }
        else if ($oneStandardFeature== "ptdeploy_enabled") {
            $ff = array("title" => "Pharaoh Deploy"); }
        else if ($oneStandardFeature== "ptmanage_enabled") {
            $ff = array("title" => "Pharaoh Manage"); }
        else {
            $ff = array("title" => "Unknown Feature"); }
		return $ff ;
	}

	public function getImage($oneStandardFeature) {
        $prefix = '/Assets/Modules/StandardFeatures/images/' ;
        if ($oneStandardFeature== "php_enabled") {
            $ff = array("image" => "{$prefix}php-logo.gif"); }
        else if ($oneStandardFeature== "html_enabled") {
            $ff = array("image" => "{$prefix}html-logo.png"); }
        else if ($oneStandardFeature== "ptvirtualize_enabled") {
            $ff = array("image" => "{$prefix}virtualize-logo.png"); }
        else if ($oneStandardFeature== "ptconfigure_enabled") {
            $ff = array("image" => "{$prefix}configure-logo.png"); }
        else if ($oneStandardFeature== "ptsource_enabled") {
            $ff = array("image" => "{$prefix}source-logo.png"); }
        else if ($oneStandardFeature== "pttest_enabled") {
            $ff = array("image" => "{$prefix}test-logo.png"); }
        else if ($oneStandardFeature== "pttrack_enabled") {
            $ff = array("image" => "{$prefix}track-logo.png"); }
        else if ($oneStandardFeature== "ptbuild_enabled") {
            $ff = array("image" => "{$prefix}build-logo.png"); }
        else if ($oneStandardFeature== "ptdeploy_enabled") {
            $ff = array("image" => "{$prefix}deploy-logo.png"); }
        else if ($oneStandardFeature== "ptmanage_enabled") {
            $ff = array("image" => "{$prefix}manage-logo.png"); }
        else {
            $ff = array("image" => "Unknown Feature"); }
		return $ff ;
	}

}
