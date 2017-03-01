<?php

Namespace Model;

class IntegrationsWebAnyOS extends BasePHPApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Web") ;

    public function getData() {
        $ret["enabled_integrations"] = $this->getEnabledIntegrations();
        $ret["installed_integrations"] = $this->getAvailableIntegrations();
        $ret["available_integrations"] = $this->getAllIntegrations();
        return $ret ;
    }

    private function getEnabledIntegrations() {
        $settings = $this->getSettings() ;
        $all = $this->getAllIntegrations() ;
        $enabled = array() ;
        foreach (array('Track', 'Source', 'Build', 'Manage') as $tool) {
            if ($settings['Pharaoh'.$tool.'Integration']['enabled'] === 'on') {
                $enabled['Pharaoh'.$tool] = $all['Pharaoh'.$tool] ;
            }
        }
        return $enabled ;
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

    protected function getAvailableIntegrations() {
        $ray = $this->getAllIntegrations() ;
        $ignore_keys = array_keys($this->getEnabledIntegrations()) ;
        $new_ray = array() ;
        foreach ($ray as $ray_title => $ray_entry) {
            if (!in_array($ray_title, $ignore_keys)) {
                $new_ray[$ray_title] = $ray_entry ;
            }
        }
        return $new_ray ;
    }

    private function getAllIntegrations() {
        $ray = array(
            "PharaohBuild" => array(
                "repo_url" => "http://www.github.com/PharaohTools/build.git",
                "description" =>
                    "This is the Pharaoh Build integration. This will allow you to integrate your repositories " .
                    "with your build processes and results published by one or more Pharaoh Build Servers. " ,
                "name" => "Pharaoh Build",
                "image" => "/Assets/Modules/DefaultSkin/image/build-logo.png",
                "manage_link" => "/index.php?control=ApplicationConfigure&action=show",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "PharaohTrack" => array(
                "repo_url" => "http://www.github.com/PharaohTools/track.git",
                "description" =>
                    "This is the Pharaoh Track integration. This will allow you to integrate your repositories " .
                    "with your issues, jobs, milestones and more that are published by one or more Pharaoh Track Servers. " ,
                "name" => "Pharaoh Track",
                "image" => "/Assets/Modules/DefaultSkin/image/track-logo.png",
                "manage_link" => "Pharaoh Track",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
            "PharaohManage" => array(
                "repo_url" => "http://www.github.com/PharaohTools/manage.git",
                "description" =>
                    "This is the Pharaoh Build integration. This will allow you to integrate your repositories " .
                    "with your build processes and results published by one or more Pharaoh Build Servers. " ,
                "name" => "Pharaoh Manage",
                "image" => "/Assets/Modules/DefaultSkin/image/manage-logo.png",
                "manage_link" => "/index.php?control=ApplicationConfigure&action=show#gitserver",
                "group" => "pharaoh_tools",
                "dependencies" => array("Logging", "SendEmail"),
            ),
        );
        return $ray ;
    }

}