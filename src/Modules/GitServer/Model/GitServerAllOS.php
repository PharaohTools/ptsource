<?php

Namespace Model;

class GitServerAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function cloneData() {
        $command = "GIT_HTTP_EXPORT_ALL GIT_PROJECT_ROOT=".REPODIR." git /usr/lib/git-core/git-http-backend" ;
        $res ;
        $this->streamExecute($command) ;
//        return $ret ;
    }

    protected function streamExecute($cmd) {
        $proc = proc_open($cmd, [['pipe','r'],['pipe','w'],['pipe','w']], $pipes);
        while(($line = fgets($pipes[1])) !== false) {
            fwrite(STDOUT,$line);
        }
        while(($line = fgets($pipes[2])) !== false) {
            fwrite(STDERR,$line);
        }
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        return proc_close($proc);
    }

    public function getData() {

        var_dump("bum bum bum") ;



        $ret["repository"] = $this->getRepository();
        $ret["features"] = $this->getRepositoryFeatures();
        $ret["history"] = $this->getCommitHistory();
        $ret = array_merge($ret, $this->getIdentifier()) ;
        return $ret ;
    }

}