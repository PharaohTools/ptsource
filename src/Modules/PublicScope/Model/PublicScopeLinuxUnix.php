<?php

Namespace Model;

class PublicScopeLinuxUnix extends Base {

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
                "name" => "Enable Public Scope for Repositories?"
            ),
            "public_pages" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Make Repository Pages Public?"
            ),
            "public_read" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Allow Public Code Reads?"
            ),
            "public_write" =>
            array(
                "type" => "boolean",
                "optional" => true,
                "name" => "Allow Public Code Writes?"
            ),
        );
        return $ff ;
    }

    public function getEventNames() {
        return array_keys($this->getEvents());
    }

    // @todo need thee cron execution event to do this
    public function getEvents() {
        $ff = array(
            "getPublicLinks" => array(
                "getPublicRepositories",
            ),
        );
        return $ff ;
    }

    public function getPublicRepositories() {
        $this->params["echo-log"] = true ;
        $this->params["php-log"] = true ;
        $repositories = $this->getRepositories() ;
        $public_repositories = array() ;
        foreach ($repositories as $repository) {
            if ($repository['settings']["PublicScope"]["enabled"] === 'on') {
                if ($repository['settings']["PublicScope"]["public_pages"] === 'on') {
                    $public_repositories[] = $repository ; } } }
        $public_repositories_html = $this->getHTMLFromRepositories($public_repositories) ;
        \Model\RegistryStore::setValue('public_links', $public_repositories_html) ;
        return $public_repositories ;
    }

    public function getRepositories() {
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        $repos = $repository->getRepositories();
        return $repos ;
    }

    public function getHTMLFromRepositories($public_repositories) {
        $html = "" ;
        if (count($public_repositories)>0) {
            $html .= "<h3><strong>Public Repositories:</strong></h3>" ;
            foreach ($public_repositories as $public_repository) {
                $html .= "<div>" ;
                $html .= "    <a target='_blank' href='index.php?control=RepositoryHome&action=show&item={$public_repository["project-slug"]}' > " ;
                $html .= "        {$public_repository["project-name"]} " ;
                $html .= "    </a>" ;
                $html .= "</div>" ; } }
        return $html ;
    }

}