<?php

Namespace Model;

class RepositoryCommitsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("RepositoryCommits") ;

    public function getCommits($repository=null, $amount=null, $page=null, $identifier=null) {
        if ($repository != null) { $this->params["item"] = $repository ; }
        if ($amount != null) { $this->params["amount"] = $amount ; }
        if ($page != null) { $this->params["page"] = $page ; }
        if ($identifier != null) { $this->params["identifier"] = $identifier ; }
        $r = $this->collate();
        return $r ;
    }

    private function collate() {
        $collated = array() ;
        $collated = array_merge($collated, $this->getItem()) ;
        $collated = array_merge($collated, $this->getAmount()) ;
        $collated = array_merge($collated, $this->getPage()) ;
        $collated = array_merge($collated, $this->getIdentifier()) ;
        $collated = array_merge($collated, $this->getCommitsData()) ;
        return $collated ;
    }

    public function getItem() {
        $item = array("item" => $this->params["item"]);
        return $item ;
    }

    public function getAmount() {
        if (!isset($this->params["amount"])) { $this->params["amount"] = 100 ; }
        $amount = array("amount" => $this->params["amount"]);
        return $amount ;
    }

    public function getPage() {
        if (!isset($this->params["page"])) { $this->params["page"] = 0 ; }
        $page = array("page" => $this->params["page"]);
        return $page ;
    }

    public function getIdentifier() {
        // @todo get default branch if there is one
        if (!isset($this->params["identifier"])) { $this->params["identifier"] = "master" ; }
        $identifier = array("identifier" => $this->params["identifier"]);
        return $identifier ;
    }

    private function getCommitsData() {
        $skip_num = $this->params["page"] * $this->params["amount"] ;
        $command  = "cd '".REPODIR.DS.$this->params["item"].DS."' && git log {$this->params["identifier"]} " ;
        $command .= "-n {$this->params["amount"]} " ;
        $command .= "--skip={$skip_num} " ;
        $command .= "--pretty=format:'{%n  \"commit\": \"%H\",%n  \"author\": \"%an <%ae>\",%n  \"date\": \"%ad\",%n  \"message\": \"%f\"%n},' " ;
        $command .= "$@ | perl -pe 'BEGIN{print \"[\"}; END{print \"]\\n\"}' | perl -pe 's/},]/}]/' " ;
        $commits = $this->executeAndLoad($command) ;
        $dirs_json = json_decode($commits, TRUE) ;
        return array("commits" => $dirs_json) ;
    }

}
