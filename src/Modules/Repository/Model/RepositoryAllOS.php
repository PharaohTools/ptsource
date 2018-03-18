<?php

Namespace Model;

class RepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getRepositories() {
        $repositoryFactory = new Repository();
        $repositoryRepository = $repositoryFactory->getModel($this->params, "RepositoryRepository") ;
        $repositories = $repositoryRepository->getAllRepositories();
        $ret = $repositories ;
        return $ret ;
    }

    public function getRepository($line) {
        $repositoryFactory = new Repository();
        $repositoryCollater = $repositoryFactory->getModel($this->params, "RepositoryCollater") ;
        $repository = $repositoryCollater->getRepository($line);
        $ret = $repository ;
        return $ret ;
    }

    public function saveRepository($line) {
        $repositoryFactory = new Repository();
        $repositorySaver = $repositoryFactory->getModel($this->params, "RepositorySaver") ;
        $repository = $repositorySaver->getRepository($line);
        $ret = $repository ;
        return $ret ;
    }

    public function getRepositoryNames() {
        $repositories = $this->getRepositories() ;
        $names = array_keys($repositories) ;
        return (isset($names) && is_array($names)) ? $names : false ;
    }

    public function getRepositoryFeatures() {
        $repositoryFeatureFactory = new \Model\RepositoryFeature();
        $repositoryFeatureRepository = $repositoryFeatureFactory->getModel($this->params, "RepositoryFeatureRepository") ;
        $names = $repositoryFeatureRepository->getRepositoryFeatureNames();
        $repository = $this->getRepository($this->params["item"]);
        $this->params["repository-settings"] = $repository["settings"];
        $enabledFeatures = array() ;
        $i = 0;
        foreach ($repository["settings"] as $key => $values) {
            if (in_array($key, $names) && array_key_exists("enabled", $values) && $values["enabled"] =="on") {
                $cname = '\Model\\'.$key ;
                $moduleFactory = new $cname();
                $moduleRepositoryFeature = $moduleFactory->getModel($this->params, "RepositoryFeature");
                // @ todo maybe an interface check? is object something?
//                $values=array("default_fieldset" =>array(0 => array($values))) ; }
                if (!isset($values["hash"])) { $values["hash"] = "12345" ; }
                $moduleRepositoryFeature->setValues($values) ;
                $moduleRepositoryFeature->setRepository($repository) ;
                $collated = $moduleRepositoryFeature->collate();
                if (array_key_exists(0, $collated)==true) {
                    foreach ($collated as $one_collated) {
                        $enabledFeatures[$i]["module"] = $key  ;
                        $enabledFeatures[$i]["values"] = $values  ;
                        $enabledFeatures[$i]["model"] = $one_collated ;
                        $i++; } }
                else {
                    $enabledFeatures[$i]["module"] = $key  ;
                    $enabledFeatures[$i]["values"] = $values  ;
                    $enabledFeatures[$i]["model"] = $collated  ;
                    $i++; } } }

        return $enabledFeatures ;
    }

    public function deleteRepository($name) {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory exists at ".REPODIR.DS."{$name}. Attempting removal.", $this->getModuleName()) ;
            $rc = self::executeAndGetReturnCode('rm -rf '.REPODIR.DS.$name);
            return $rc ; }
        else  {
            $logging->log("No directory exists at ".REPODIR.DS."$name to delete", $this->getModuleName()) ;
            return true ; }
    }

    public function createRepository($name, $repo_type = 'git') {
        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        if (file_exists(REPODIR.DS.$name)) {
            $logging->log("Directory already exists at ".REPODIR.DS."{$name}. Exiting with failure.", $this->getModuleName()) ;
            return false ; }
        else  {
            if ($repo_type === 'raw') {

                $logging->log("Attempting to create Raw Repository at directory ".REPODIR.DS."$name ", $this->getModuleName()) ;
                // @todo cross os
                $comms = array (
                    '/bin/mkdir -m 0775 -p '.REPODIR.DS.$name.' ; ' ,
                    'cd '.REPODIR.DS.$name.' ; '
                ) ;

                $results = array() ;
                foreach ($comms as $comm) {
                    $rc = self::executeAndGetReturnCode($comm);
                    $results[] = ($rc["rc"] == 0) ? true : false ;
                    if ($rc["rc"] != 0) {
                        $logging->log("Repository creation command failed ".REPODIR.DS."$name ", $this->getModuleName(), LOG_FAILURE_EXIT_CODE) ;
                        $logging->log("Failed command was {$comm}", $this->getModuleName()) ;
                        return false ; } }
                return (in_array(false, $results)) ? false : true ;



            } else if ($repo_type === 'git') {
                $logging->log("Attempting to create Git Repository at directory ".REPODIR.DS."$name ", $this->getModuleName()) ;
                // @todo cross os
                $comms = array(
                    'sudo -u ptgit "/bin/mkdir -m 0775 -p '.REPODIR.DS.$name . '" ;' ,
                    'cd '.REPODIR.DS.$name.'; git config http.receivepack true ;',
                    'git init --bare '.REPODIR.DS.$name,
                    'sudo -u ptgit "chown -R ptgit:ptsource '.REPODIR.DS.$name . '"' ,) ;
                $results = array() ;
                foreach ($comms as $comm) {
                    $rc = self::executeAndGetReturnCode($comm);
                    $results[] = ($rc["rc"] == 0) ? true : false ;
                    if ($rc["rc"] != 0) {
                        $logging->log("Repository creation command failed ".REPODIR.DS."$name ", $this->getModuleName(), LOG_FAILURE_EXIT_CODE) ;
                        $logging->log("Failed command was {$comm}", $this->getModuleName()) ;
                        return false ; } }
                return (in_array(false, $results)) ? false : true ;
            }
        }
    }

    public function userIsAllowedAccess($public_resource = null) {
        $user = $this->getLoggedInUser() ;
        $repository = $this->getRepository($this->params['item']) ;
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        if (!isset($settings["PublicScope"]["enable_public"]) ||
            ( isset($settings["PublicScope"]["enable_public"]) && $settings["PublicScope"]["enable_public"] != "on" )) {
            // if enable public is set to off
            if ($user == false) {
                // and the user is not logged in
                return false ; }
            // if they are logged in continue on
            return true ; }
        else {
            if (is_null($public_resource)) {
                $public_resource = "public_pages" ;
            }
            // if enable public is set to on
            if ($user == false) {
                // and the user is not logged in
                if ($repository["settings"]["PublicScope"]["enabled"] == "on" &&
                    $repository["settings"]["PublicScope"][$public_resource] == "on") {
                    // if public pages are on
                    return true ; }
                else {
                    // if no public pages are on
                    return false ; } }
            else {
                // and the user is logged in
                // @todo this is where repo specific perms go when ready
                return true ; }
        }
    }


    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        return $signup->getLoggedInUserData() ;
    }

}
