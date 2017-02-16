<?php

Namespace Model;

class PullRequestAllOS extends Base {

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
        $ret["features"] = $this->getRepositoryFeatures();
        $ret["user"] = $this->getLoggedInUser();
        $ret["current_user_role"] = $this->getCurrentUserRole($ret["user"]);
        $ret["pull_request"] = $this->getPullRequest();
        $ret["pull_request_comments"] = $this->getPullRequestComments($ret["pull_request"]);
        $ret["pharaoh_build_integration"] = $this->getPharaohBuildIntegration($ret["features"]);
        return $ret ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function getCurrentUserRole($user = null) {
        if ($user === null) {
            $user = $this->getLoggedInUser(); }
        if ($user === false) {
            return false ; }
        return $user->role ;
    }

    protected function getLibraries() {
        $libDir = dirname(dirname(__DIR__)).DS."RepositoryCharts".DS."Libraries".DS ;
        require_once $libDir."gitter".DS."vendor".DS."autoload.php" ;
        foreach (glob("{$libDir}GitPrettyStats".DS."Charts".DS."*.php") as $filename) {
            require_once $filename; }
        foreach (glob("{$libDir}GitPrettyStats".DS."Providers".DS."*.php") as $filename) {
            require_once $filename; }
        foreach (glob("{$libDir}GitPrettyStats".DS."*.php") as $filename) {
            require_once $filename; }
    }

    public function getRepository() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepository($this->params["item"]);
        return $r ;
    }

    public function getPullRequest() {
        $datastoreFactory = new \Model\Datastore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $parsed_filters = array() ;
        $parsed_filters[] = array("where", "repo_pr_id", '=', $this->params["item"] ) ;
        $parsed_filters[] = array("where", "pr_id", '=', $this->params["pr_id"] ) ;
        $pr = $datastore->findOne('pull_requests', $parsed_filters) ;
        return $pr ;
    }

    public function getPullRequestComments($pr) {
        $prFactory = new \Model\PullRequest() ;
        $prob = $prFactory->getModel($this->params, 'Comments') ;
        $prc = $prob->getPullRequestComments($pr) ;
        return $prc ;
    }

    public function getRepositoryFeatures() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $r = $repository->getRepositoryFeatures($this->params["item"]);
        return $r ;
    }

    protected function getPharaohBuildIntegration($features) {
        $use_integration = false ;
        foreach ($features as $feature) {
            if ( ($feature["module"]==='StandardFeatures') &&
                 ($feature['values']['ptbuild_enabled'] === 'on')) {
                $use_integration = true ;
            }
        }

        if ($use_integration === true) {
            $res = array(
                'status' => true,
                'success_results' => array(
                    array(
                        'slug' => 'build_status',
                        'name' => 'Pharaoh Build Status',
                        'result' => 'passed',
                        'exitcode' => 0,
                        'message' => 'The Pharaoh Build job has Passed. This will check things like installation are working, and creating the resources for a newly released version.'
                    ),
                    array(
                        'slug' => 'behat',
                        'name' => 'Behat Tests',
                        'result' => 'passed',
                        'exitcode' => 0,
                        'message' => 'The Behat functional tests have Passed. These are the main tests for the Application, and will check that individual pieces of functionality within the application are working as expected.'
                    ),
                ),
                'failure_results' => array(),
            ) ;
            $pbi = $res ;
        }
        else {
            $pbi = false ;
        }
        return $pbi ;
    }

    public function userIsAllowedAccess() {
        $user = $this->getLoggedInUser() ;
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
            if ($user != false) {
                // and the user is  logged in
                return true ; }
            else {
                // and the user is not logged in
                return true ; } }
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}