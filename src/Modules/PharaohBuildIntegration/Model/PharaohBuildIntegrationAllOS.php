<?php

Namespace Model;

class PharaohBuildIntegrationAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getSettingTypes() {
        return array_keys($this->getSettingFormFields());
    }

    public function getSettingFormFields() {
        $ff = array(
            "enabled" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Enable Integrating with Pharaoh Build job/s?"
            ),

            "fieldsets" => array(
                "build_jobs" => array(
                    "instance_url" =>
                        array(
                            "type" => "text",
                            "name" => "Build Server URL",
                            "slug" => "instance_url"),
                    "job_slug" =>
                        array(
                            "type" => "text",
                            "name" => "Build Job Slug",
                            "slug" => "job_slug"),
                    "criteria" =>
                        array(
                            "type" => "textarea",
                            "name" => "Build Run Search Criteria",
                            "slug" => "criteria"),
//                    "title" =>
//                        array(
//                            "type" => "text",
//                            "name" => "Job Title",
//                            "slug" => "jobtitle"),
                )
            ),

        );
        return $ff ;
    }

    public function findJobStatus($build_job, $repository) {
        $apif = new \Model\PharaohAPI();
        $params = $this->params ;
        $params['api_module'] = 'PublishStatus' ;
        $params['api_function'] = 'get_status' ;
        $params['api_instance_url'] = $build_job['instance_url'] ;
        $params['api_key'] = $this->findInstanceKey($build_job['instance_url']) ;
        $params['api_param_slug'] = $build_job['job_slug'] ;
        $params['api_param_criteria'] = $build_job['criteria'] ;
        $api_request = $apif->getModel($params, 'Request') ;
        $result = $api_request->performAPIRequest() ;
        return $result;

    }

    public function findJobReports($build_job) {
        $apif = new \Model\PharaohAPI();
        $params = $this->params ;
        $params['api_module'] = 'PublishReports' ;
        $params['api_function'] = 'get_reports' ;
        $params['slug'] = $build_job['job_slug'] ;
        $params['api_instance_url'] = $build_job['instance_url'] ;
        $params['api_key'] = $this->findInstanceKey($build_job['instance_url']) ;
        $params['api_param_slug'] = $build_job['job_slug'] ;
        $api_request = $apif->getModel($params, 'Request') ;
        $result = $api_request->performAPIRequest() ;
        return $result;
    }

    public function findJobReleases($build_job) {
        $apif = new \Model\PharaohAPI();
        $params = $this->params ;
        $params['api_module'] = 'PublishReleases' ;
        $params['api_function'] = 'get_releases' ;
        $params['slug'] = $build_job['job_slug'] ;
        $params['api_instance_url'] = $build_job['instance_url'] ;
        $params['api_key'] = $this->findInstanceKey($build_job['instance_url']) ;
        $params['api_param_slug'] = $build_job['job_slug'] ;
        $api_request = $apif->getModel($params, 'Request') ;
        $result = $api_request->performAPIRequest() ;
        return $result;
    }

    public function findInstanceKey($instance_url) {
        $instance_url = $this->ensureTrailingSlash($instance_url) ;
        $settings = $this->getSettings() ;
        $instance_key = false ;
        if ($settings['PharaohBuildIntegration']['enabled'] === 'on') {
            for ($i=0; $i<5; $i++) {
                if (isset($settings['PharaohBuildIntegration']['build_instance_url_'.$i])) {
                    $url = $settings['PharaohBuildIntegration']['build_instance_url_'.$i] ;
                    $url_with_slash = $this->ensureTrailingSlash($url) ;
                    if ($url_with_slash === $instance_url) {
                        $instance_key = $settings['PharaohBuildIntegration']['build_instance_key_'.$i] ;
                    }
                }
            }
        }
        else {
            // Build Integration is not enabled
            return false ;
        }
        return $instance_key ;

    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

}