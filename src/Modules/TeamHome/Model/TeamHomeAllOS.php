<?php

Namespace Model;

class TeamHomeAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function getData() {
        $ret["team"] = $this->getTeam();
        $ret["features"] = $this->getTeamFeatures();
        $ret["is_https"] = $this->isSecure();
        $ret["user"] = $this->getLoggedInUser();
        $ret["current_user_role"] = $this->getCurrentUserRole($ret["user"]);
        $ret = array_merge($ret, $this->getIdentifier()) ;
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
        return $user['role'] ;
    }

    public function deleteData() {
        $ret["team"] = $this->deleteTeam();
        return $ret ;
    }

    protected function getTeam() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        $r = $team->getTeam($this->params["item"]);
        return $r ;
    }


    protected function parseLSTree($output) {
        $files = array() ;
        foreach ($output as $line) {
            $parts = explode(' ', $line) ;
            $further_parts = explode("\t", $parts[2]) ;
            $files[] = $further_parts[1] ; }
        return $files ;
    }

    public function getIdentifier() {
        // @todo get default branch if there is one
        if (!isset($this->params["identifier"])) { $this->params["identifier"] = "master" ; }
        $identifier = array("identifier" => $this->params["identifier"]);
        return $identifier ;
    }

    protected function getTeamFeatures() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        $r = $team->getTeamFeatures($this->params["item"]);
        return $r ;
    }

    protected function isSecure() {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    public function deleteTeam() {
        $teamFactory = new \Model\Team() ;
        $team = $teamFactory->getModel($this->params);
        return $team->deleteTeam($this->params["item"]);
    }

    public function userIsAllowedAccess() {
        $user = $this->getLoggedInUser() ;
        $team = $this->getTeam() ;
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
                if ($team["settings"]["PublicScope"]["enabled"] == "on" &&
                    $team["settings"]["PublicScope"]["public_pages"] == "on") {
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