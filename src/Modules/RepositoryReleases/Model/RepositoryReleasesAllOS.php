<?php

Namespace Model;

class RepositoryReleasesAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret = $this->getReleaseHistory();
        $ret["repository"] = $this->getRepository();
        $ret["tags"] = $this->getAvailableTags();
        $ret["tag_count"] = $this->getTagCount();
        $ret['release_packages'] = $this->getReleasePackages();
        $ret['enabled_default_release_packages'] =  $this->getEnabledDefaultReleasePackages($ret["repository"]);
        $ret['standard_release_enabled'] =  $this->standardReleaseEnabled($ret["repository"]);
        $ret['pharaoh_build_release_enabled'] =  $this->pharaohBuildReleaseEnabled($ret["repository"]);
        return $ret ;
    }

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "stdrel_enabled" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Enable Publishing Standard Releases?"
                ),
            "stdrel_zip_enabled" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Enable Publishing Zip Archive?"
                ),
            "stdrel_tar_enabled" =>
                array(
                    "type" => "boolean",
                    "optional" => true,
                    "name" => "Enable Publishing Tar Archive?"
                ),
        );
        return $ff ;
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getReleaseHistory() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params, "RepositoryCommits");
        return $repository->getCommits();
    }

    public function getAvailableTags() {
        $repositoryReleasesFactory = new \Model\RepositoryReleases() ;
        $repositoryReleasesTags = $repositoryReleasesFactory->getModel($this->params, "Tags");
        return $repositoryReleasesTags->getAvailableTags() ;
    }

    public function getTagCount() {
        $repositoryReleasesFactory = new \Model\RepositoryReleases() ;
        $repositoryReleasesTags = $repositoryReleasesFactory->getModel($this->params, "Tags");
        return $repositoryReleasesTags->getTagCount() ;
    }

    public function getReleasePackages() {
        $r = $this->getDefaultReleasePackages() ;
        $r = array_merge($r, $this->getPharaohBuildIntegrationPackages()) ;
        return $r ;
    }

    protected function getPharaohBuildIntegrationPackages() {
        $r = array(
            'pharaoh_build_integration' => array(
                'windows' => array('url' => 'http://google.com', 'title' => 'Windows Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/windows-logo.png'),
                'linux' => array('url' => 'http://google.com', 'title' => 'Linux Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/linux-logo.png'),
                'osx' => array('url' => 'http://google.com', 'title' => 'OSx Installer', 'image' => 'http://source.pharaoh.tld/Assets/Modules/RepositoryReleases/images/apple-logo.png'),
            ),
        ) ;
        return $r ;
    }

    protected function getDefaultReleasePackages() {
        $r = array(
            'default' => array(
                'git' => array('url' => 'http://google.com', 'title' => 'Git Clone', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                'zip' => array('url' => 'http://google.com', 'title' => 'Zip Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
                'tar' => array('url' => 'http://google.com', 'title' => 'Tar Archive', 'image' => 'http://source.pharaoh.tld/Assets/Modules/DefaultSkin/image/source-logo.png'),
            ),
        ) ;
        return $r ;
    }

    protected function standardReleaseEnabled($repo) {
        $mn = $this->getModuleName() ;
        if ($repo['settings'][$mn]['stdrel_enabled']) {
            return true ;
        }
        return false ;
    }

    protected function pharaohBuildReleaseEnabled($repo) {
        if ($repo['settings']['PharaohBuildIntegration']['enabled'] === 'on') {
            return true ;
        }
        return false ;
    }

    public function getEnabledDefaultReleasePackages($repo) {
        $mn = $this->getModuleName() ;
        if (!isset($repo['settings'][$mn])) {
            return array() ;
        }
        $r = array() ;
        if ($repo['settings'][$mn]['stdrel_enabled']) {
            $r[] = 'git' ;
            if ($repo['settings'][$mn]['stdrel_zip_enabled']) {
                $r[] = 'zip' ;
            }
            if ($repo['settings'][$mn]['stdrel_zip_enabled']) {
                $r[] = 'tar' ;
            }
        }
        return $r ;
    }

    public function repoRootDir() {
        return REPODIR.DS.$this->params["item"].DS;
    }


    protected function getPharaohBuildIntegration($features, $repository) {
        $pbi = false ;
        foreach ($features as $feature) {
            if ( ($feature["module"] === 'PharaohBuildIntegration') &&
                ($feature['values']['enabled'] === 'on')) {
                $res = $this->getBuildReleases($feature, $repository) ;
                $pbi = $res ;
            }
        }
        return $pbi ;
    }

    protected function getBuildReleases($feature, $repository) {
        $results = array() ;
        foreach ($feature['values']['build_jobs'] as $build_job) {
            $results[] = $this->calculateBuildJob($build_job, $repository) ;
        }
        return $results ;
    }

    protected function calculateBuildJob($build_job, $repository) {
        $pbif = new \Model\PharaohBuildIntegration() ;
        $pbi = $pbif->getModel($this->params) ;
        $job_releases = $pbi->findJobReleases($build_job, $repository) ;
//        $bjr = array(
//            'releases' => $job_releases,
//        ) ;
//        return $bjr ;
        return $job_releases ;
    }

}