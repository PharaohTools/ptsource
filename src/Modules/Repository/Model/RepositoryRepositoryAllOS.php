<?php

Namespace Model;

class RepositoryRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryRepository") ;

    public function getAllRepositories() {
        $repositories = array();
        $names = $this->getRepositoryNames() ;
        $repositoryFactory = new \Model\Repository() ;
        $repository = $repositoryFactory->getModel($this->params);
        foreach ($names as $name) {
            $user = $this->getLoggedInUser() ;
            $repo = $repository->getRepository($name);
            $hidden = (isset($repo["settings"]["HiddenScope"]["enabled"]) &&
                $repo["settings"]["HiddenScope"]["enabled"]=="on") ? true : false ;
            $hidden_from_members = (isset($repo["settings"]["HiddenScope"]["hidden_from_members"]) &&
                $repo["settings"]["HiddenScope"]["hidden_from_members"]=="on") ? true : false ;
            if ($hidden == true) {
                // @todo here
                // if logged in user is owner
                if ($user !== false && $user['role']==1) {
                    $repositories[$name] = $repo ;
                    continue ; }
                if ($user !== false && $user['username']==$repo["project-owner"]) {
//                    var_dump("one") ;
//                    die() ;
                    $repositories[$name] = $repo ;
                    continue ; }
                // if settings say hide from members return false
                if ($hidden_from_members==true) {
//                    var_dump("two") ;
//                    die() ;
                    continue ; }
                // if logged in user is member return true
                $pm = explode(",", $repo["project-members"]) ;
                if ($user !== false && in_array($user['username'], $pm)) {
//                    var_dump("three") ;
//                    die() ;
                    $repositories[$name] = $repo ;
                    continue ; } }
            else {
//                var_dump("four") ;
//                die() ;
                $repositories[$name] = $repo ; } }
        return $repositories ;
    }

    public function getRepositoryNames() {
        $repositories = scandir(REPODIR) ;
        for ($i=0; $i<count($repositories); $i++) {
            if (!in_array($repositories[$i], array(".", "..", "tmpfile"))){
                if(is_dir(REPODIR.DS.$repositories[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    $names[] = $repositories[$i] ; } } }
        return (isset($names) && is_array($names)) ? $names : array() ;
    }

    protected function getLoggedInUser() {
        $signupFactory = new \Model\Signup() ;
        $signup = $signupFactory->getModel($this->params);
        $this->params["user"] = $signup->getLoggedInUserData() ;
        return $this->params["user"] ;
    }

}