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
        $this->loadLibraries() ;
    }

    public function getData() {
        $ret["repository"] = $this->getRepository();
        $ret["features"] = $this->getRepositoryFeatures();
        $ret["user"] = $this->getLoggedInUser();
        $ret["current_user_role"] = $this->getCurrentUserRole($ret["user"]);
        $ret["pull_request"] = $this->getPullRequest();
        $ret["commit_difference"] = $this->countCommitDifference();
        $ret["pull_request_comments"] = $this->getPullRequestComments($ret["pull_request"]);
        $ret["pharaoh_build_integration"] = $this->getPharaohBuildIntegration($ret["features"], $ret["repository"]);
        return $ret ;
    }

    public function updatePullRequestStatus() {

        $user = $this->getLoggedInUser();
        $can_update = false ;
        $pull_request = $this->getPullRequest();
        $gsf = new \Model\GitServer();
        $gs = $gsf->getModel($this->params) ;
        if ( ($pull_request['requestor'] == $user['username']) ||
             ($user['role'] == 1)  ||
             ($gs->authUserToWrite($user['username'], $this->params["item"]))) {
            // if user is the requestor they can close it
            // if user is an admin they can close it
            $can_update = true ;
        }
        if ($can_update === true) {
            $datastoreFactory = new \Model\Datastore() ;
            $datastore = $datastoreFactory->getModel($this->params) ;
            if (in_array($this->params["update_status"], array('closed', 'rejected', 'accepted'))) {
                $pull_request['status'] = $this->params["update_status"] ;
                $pull_request['last_changed'] = time() ;
                if ($this->params["update_status"] == 'rejected') {
                    $pull_request['rejected_by'] = $user['username'] ;
                }
                if ($this->params["update_status"] == 'accepted') {
                    $accept_result = $this->acceptPullRequest() ;
                    if ($accept_result['status'] === false) {
                        $ret = $accept_result ;
                        return $ret ;
                    }
                    $pull_request['accepted_by'] = $user['username'] ;
                }
            }
            $clause = array(
                'pr_id' => $this->params["pr_id"],
                'repo_pr_id' => $this->params["item"],
            ) ;
            $res = $datastore->update('pull_requests', $clause, $pull_request) ;
            if ($res === false) {
                $ret["status"] = false ;
                $ret["message"] = 'Unable to update this pull request' ;
            }
            else {
                $ret["status"] = true ;
                $ret["message"] = 'Pull Request Status updated to Closed' ;
            }
        }
        else {
            $ret["status"] = false ;
            $ret["message"] = 'You do not have sufficient permission to change this pull request' ;
        }
        return $ret ;
    }

    protected function acceptPullRequest() {

        $pull_request = $this->getPullRequest();

        $rd = REPODIR.DS.$this->params["item"].DS ;

        // @todo this might not be the best temp dir creator
        $GIT_WORK_TREE = self::executeAndLoad("mktemp -d") ;

        $commmand ="cd $GIT_WORK_TREE \n " ;
        $commmand.="git clone {$rd} . \n " ;
//        $commmand.="git remote show \n " ;
        $commmand.="GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git reset --hard HEAD \n " ;
        $commmand.="GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git checkout {$pull_request['target_branch']} \n " ;
//        $commmand.=" ( GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git merge --ff-only -m \"Merging {$pull_request['source_branch']} into {$pull_request['target_branch']}\" origin/{$pull_request['source_branch']} || git reset --hard HEAD ) \n " ;
        $commmand.=" ( GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git merge --ff-only -m \"Merging {$pull_request['source_branch']} into {$pull_request['target_branch']}\" origin/{$pull_request['source_branch']} ) \n " ;
        $commmand.="GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git checkout master \n " ;
//        $commmand.="GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git remote add origin {$rd} \n " ;
        $commmand.="GIT_DIR={$rd} GIT_WORK_TREE={$GIT_WORK_TREE} git push -u origin master \n " ;
        $commmand.="cd {$rd} \n " ;
        $commmand.="rm -rf $GIT_WORK_TREE " ;

//        ob_start() ;
        $res = self::executeAsShell($commmand) ;
//        $out = ob_get_clean() ;
//        var_dump('<pre>',$commmand,  $res, '</pre>') ;

        if ($res === 0) {
            $ret["status"] = true ;
            $ret["message"] = 'Pull Request Status updated to Closed' ;
            return $ret ;
        } else {
            $ret["status"] = false ;
            $ret["message"] = 'Server Error' ;
            return $ret ;
        }
    }

    protected function countCommitDifference() {
        $pull_request = $this->getPullRequest();
        $rd = REPODIR.DS.$this->params["item"].DS ;
        $commmand =
            "cd {$rd} && git log --oneline {$pull_request['source_branch']} " .
            "^{$pull_request['target_branch']} | wc -l" ;
        $res = self::executeAndLoad($commmand) ;
        return $res ;
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
        return $user['role'] ;
    }

    protected function loadLibraries() {
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

    protected function getPharaohBuildIntegration($features, $repository) {
        $pbi = false ;
        foreach ($features as $feature) {
            if ( ($feature["module"]==='PharaohBuildIntegration') &&
                 ($feature['values']['enabled'] === 'on')) {
                $res = $this->getBuildReports($feature, $repository) ;
                $pbi = $res ;
            }
        }
        return $pbi ;
    }

    protected function getBuildReports($feature, $repository) {
        $results = array() ;
        foreach ($feature['values']['build_jobs'] as $build_job) {
            $results[] = $this->calculateBuildJob($build_job, $repository) ;
        }
        return $results ;
    }

    protected function calculateBuildJob($build_job, $repository) {
        $pbif = new \Model\PharaohBuildIntegration() ;
        $pbi = $pbif->getModel($this->params) ;
        $job_status = $pbi->findJobStatus($build_job, $repository) ;
//        $job_reports = $pbi->findJobReports($build_job, $repository) ;
        $bjr = array(
            'build_status' => $job_status,
//            'results' => $job_reports
        ) ;
        return $bjr ;
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