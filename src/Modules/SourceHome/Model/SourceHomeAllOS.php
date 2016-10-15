<?php

Namespace Model;

class QuickLinksAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getData() {
//        $ret["issues"] = $this->getIssues();
//        $ret["all-issue-counts"] = $this->getAllIssueCounts();
        $ret["all-issue-counts"] = 10 ;
//        $ret["my-issue-watching-count"] = $this->getMyIssueCount("watching");
//        $ret["my-issue-submitted-count"] = $this->getMyIssueCount("submitted");
//        $ret["my-issue-assigned-count"] = $this->getMyIssueCount("assigned");
        // jobs
        $ret["job_count"] = $this->getJobCount();  // adds 0.5 secs, can stay
        $ret["my_job_created_count"] = $this->getJobCreatedCount();
        $ret["my_job_member_count"] = $this->getJobMemberCount();
        // user
        $ret["user"] = $this->getLoggedInUser();
        return $ret ;
    }

    public function getIssues() {
        $issueFactory = new \Model\Issue() ;
        $issueParams = $this->params ;
//        $issueParams["page"] = 1 ;
        $issueRepository = $issueFactory->getModel($issueParams, "IssueRepository");
        $issuesRay = $issueRepository->getIssues();
        return $issuesRay["issues"] ;
    }

    public function getAllIssueCounts() {
//        $loggingFactory = new \Model\Logging();
//        $logging = $loggingFactory->getModel($this->params);
        $issueFactory = new \Model\Issue() ;
        $jobFactory = new \Model\Job() ;
        $jobRepository = $jobFactory->getModel($this->params, "JobRepository");
        $allJobs = $jobRepository->getAllJobs();
//            ob_start();
//            var_dump("all jobs:", $allJobs) ;
//            $res3 = ob_get_clean() ;
//            $logging->log("aj {$res3}", $this->getModuleName()) ;
        $allCounts = 0 ;
        foreach ($allJobs as $oneJob) {
            $tempParams["item"] = $oneJob["job_slug"] ;
            $issueRepository = $issueFactory->getModel($tempParams, "IssueRepository");
            $issueCountRay = $issueRepository->getIssueCount();
            $allCounts += $issueCountRay["issue_count"]; }
        return $allCounts ;
    }

    private function getAllJobs() {
        $jobFactory = new \Model\Job() ;
        $jobRepository = $jobFactory->getModel($this->params, "JobRepository");
        $allJobs = $jobRepository->getAllJobs();
        return $allJobs ;
    }

    public function getMyIssueCount ($type) {
            $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
        $this->getLoggedInUser() ;
        $types = array(
            "assigned" => "issue_assignee",
            "submitted" => "issue_submitter",
            "watching" => "issue_watchers[~]" ) ;
        $issueFactory = new \Model\Issue() ;
        $allCounts = 0 ;
        $allJobs = $this->getAllJobs() ;
        $username = (isset($this->params["user"]->username)) ? $this->params["user"]->username : "" ;
        foreach ($allJobs as $oneJob) {
            $filters = array($types[$type].'::'.$username) ;

//        ob_start();
//        var_dump("issue count filter string:", $types[$type].'::'.$username) ;
//        $res3 = ob_get_clean() ;
//        $logging->log("cr {$res3}", $this->getModuleName()) ;

            $tempParams["filters"] = $filters ;
            $tempParams["item"] = $oneJob["job_slug"] ;
            $issueRepository = $issueFactory->getModel($tempParams, "IssueRepository");
            $issueCountRay = $issueRepository->getFilteredIssuesCount();
            $allCounts += count($issueCountRay["issues"]); }
        return $allCounts ;
    }

    public function getJobCount() {
        $jobFactory = new \Model\Job() ;
        $jobRepository = $jobFactory->getModel($this->params, "JobRepository");
        $jobCountRay = $jobRepository->getJobCount();
        return $jobCountRay["job_count"] ;
    }

    public function getJobCreatedCount() {
        $this->getLoggedInUser() ;
        $jobFactory = new \Model\Job() ;
        $username = (isset($this->params["user"]->username)) ? $this->params["user"]->username : "" ;
        $filters = array('job_creator::'.$username) ;
        $tempParams = $this->params ;
        $tempParams["filters"] = $filters ;
        $jobRepository = $jobFactory->getModel($tempParams, "JobRepository");
        $jobCountRay = $jobRepository->getFilteredJobsCount();

        $loggingFactory = new \Model\Logging();
        $logging = $loggingFactory->getModel($this->params);
//        ob_start();
//        var_dump("created jobs:", $jobCountRay) ;
//        $res3 = ob_get_clean() ;
//        $logging->log("cr {$res3}", $this->getModuleName()) ;
        return $jobCountRay["jobs"] ;
    }

    public function getJobMemberCount() {
        $this->getLoggedInUser() ;
        $jobFactory = new \Model\Job() ;
        $username = (isset($this->params["user"]->username)) ? $this->params["user"]->username : "" ;
        $filters = array('job_members[~]::'.$username) ;
        $tempParams = $this->params ;
        $tempParams["filters"] = $filters ;
        $jobRepository = $jobFactory->getModel($tempParams, "JobRepository");
        $jobCountRay = $jobRepository->getFilteredJobsCount();
        return $jobCountRay["jobs"] ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

    public function findModuleNames($params) {
        if (isset($this->params["compatible-only"]) && $this->params["compatible-only"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        if (isset($this->params["only-compatible"]) && $this->params["only-compatible"]=="true") {
            return $this->findOnlyCompatibleModuleNames($params); }
        return $this->findAllModuleNames() ;
    }

    private function findAllModuleNames() {
        $allInfoObjects = \Core\AutoLoader::getInfoObjects() ;
        $moduleNames = array() ;
        foreach ($allInfoObjects as $infoObject) {
            $array_keys = array_keys($infoObject->routesAvailable()) ;
            $miniRay = array() ;
            $miniRay["command"] = $array_keys[0] ;
            $miniRay["name"] = $infoObject->name ;
            $miniRay["hidden"] = $infoObject->hidden ;
            $moduleNames[] = $miniRay ; }
        return $moduleNames;
    }

    private function findOnlyCompatibleModuleNames($params) {
        $allModules = $this->findAllModuleNames() ;
        $controllerBase = new \Controller\Base();
        $errors = $controllerBase->checkForRegisteredModels($params, $allModules) ;
        $compatibleModules = array();
        foreach($allModules as $oneModule) {
            if (!in_array($oneModule["command"], $errors)) {
                $compatibleModules[] = $oneModule ; } }
        return $compatibleModules;
    }

}