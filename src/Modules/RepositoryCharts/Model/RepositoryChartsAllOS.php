<?php

Namespace Model;

class RepositoryChartsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params) ;
        $this->getLibraries() ;
    }

    public function getData() {
        $ret["repository"] = $this->getRepository();
        $ret["repository_charts"] = $this->getRepositoryCharts($ret["repository"]);
        $ret["history"] = $this->getCommitHistory();
        $ret["user"] = $this->getLoggedInUser();
        $ret["current_user_role"] = $this->getCurrentUserRole($ret["user"]);
        return $ret ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function getCurrentUserRole($user = null) {
        if ($user == null) { $user = $this->getLoggedInUser(); }
        if ($user == false) { return false ; }
        return $user->role ;
    }

    public function deleteData() {
        $ret["repository"] = $this->deleteRepository();
        return $ret ;
    }

    protected function getLibraries() {
        $libDir = dirname(__DIR__).DS."Libraries".DS ;
        require_once $libDir."gitter".DS."vendor".DS."autoload.php" ;
        foreach (glob("{$libDir}GitPrettyStats".DS."Charts".DS."*.php") as $filename) {
            require_once $filename; }
        foreach (glob("{$libDir}GitPrettyStats".DS."Providers".DS."*.php") as $filename) {
            require_once $filename; }
        foreach (glob("{$libDir}GitPrettyStats".DS."*.php") as $filename) {
            require_once $filename; }
    }

    protected function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    protected function getRepositoryCharts($repo) {

        $client = new \Gitter\Client;

        $loc = REPODIR.DS.$this->params["item"] ;
        $repository = $client->getRepository($loc);
//        $gpc = new \GitPrettyStats\Repository($loc, $client) ;

//        var_dump($gpc) ;

        $repository->addStatistics(array(
            new \Gitter\Statistics\Contributors,
            new \Gitter\Statistics\Date,
            new \Gitter\Statistics\Day,
            new \Gitter\Statistics\Hour
        ));
//        print_r($gpc->getStatistics());
//        $stats = $repository->getStatistics() ;
        $stats2 = $repository->statistics() ;
//
//        ob_start();
//        var_dump( $stats2) ;
//        $res = ob_get_clean() ;
//
//        file_put_contents("/tmp/log", $res) ;
        $fc = $repository->getFirstCommitDate();
        return $stats2 ;
    }

    protected function getCommitHistory() {
        $repositoryFactory = new \Model\Repository() ;
        $commitParams = $this->params ;
        $commitParams["amount"] = 10 ;
        $repository = $repositoryFactory->getModel($commitParams, "RepositoryCommits");
        return $repository->getCommits();
    }

    public function userIsAllowedAccess() {
        $user = $this->getLoggedInUser() ;
        $repository = $this->getRepository() ;
        $settings = $this->getSettings() ;
        if (!isset($settings["PublicScope"]["enable_public"]) ||
            ( isset($settings["PublicScope"]["enable_public"]) && $settings["PublicScope"]["enable_public"] != "on" )) {
            // if enable public is set to off
            if ($user == false) {
                // and the user is not logged in
                return false ; }
            // if they are logged in continue on
            return true ; }
        else {
            // if enable public is set to on
            if ($user == false) {
                // and the user is not logged in
                if ($repository["settings"]["PublicScope"]["enabled"] == "on" &&
                    $repository["settings"]["PublicScope"]["public_pages"] == "on") {
                    // if public pages are on
                    return true ; }
                else {
                    // if no public pages are on
                    return false ; } }
            else {
                // and the user is logged in
                // @todo this is where repo specific perms go when ready
                return true ;
            }
        }
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}