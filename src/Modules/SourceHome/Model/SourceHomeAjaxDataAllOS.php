<?php

Namespace Model;

class QuickLinksAjaxDataAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("AjaxData") ;


    public function getData($type) {
        $ret = "" ;
        if ($type=="all") {
            $ret = $this->getAllIssueCounts();
        }
        else if ($type=="watching") {
            $ret = $this->getMyIssueCount("watching");

        }
        else if ($type=="submitted") {
            $ret = $this->getMyIssueCount("submitted");

        }
        else if ($type=="assigned") {
            $ret = $this->getMyIssueCount("assigned");

        }

        return $ret ;
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

}