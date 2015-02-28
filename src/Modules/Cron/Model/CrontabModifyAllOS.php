<?php

Namespace Model;

class CrontabModifyAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("CrontabModify") ;

    private $path;
    private $handle;
    private $cron_file;

    function __construct() {
        $path_length     = strrpos(__FILE__, "/");
        $this->path      = substr(__FILE__, 0, $path_length) . '/';
        $this->handle    = 'crontab.txt';
        $this->cron_file = "{$this->path}{$this->handle}";

    }

    public function write_to_file($path=NULL, $handle=NULL) {
        if ( ! $this->crontab_file_exists()){
            $this->handle = (is_null($handle)) ? $this->handle : $handle;
            $this->path   = (is_null($path))   ? $this->path   : $path;
            $this->cron_file = "{$this->path}{$this->handle}";
            $init_cron = "crontab -l > {$this->cron_file} && [ -f {$this->cron_file} ] || > {$this->cron_file}";
            self::executeAndOutput($init_cron); }
        return $this;
    }

    public function remove_file() {
        if ($this->crontab_file_exists()) self::executeAndOutput("rm {$this->cron_file}");
        return $this;
    }

    public function append_cronjob($cron_jobs=NULL) {
        if (is_null($cron_jobs)) $this->error_message("Nothing to append!  Please specify a cron job or an array of cron jobs.");
        $append_cronfile = "echo '";
        $append_cronfile .= (is_array($cron_jobs)) ? implode("\n", $cron_jobs) : $cron_jobs;
        $append_cronfile .= "'  >> {$this->cron_file}";
        $install_cron = "crontab {$this->cron_file}";
        $this->write_to_file() ;
        self::executeAndOutput($append_cronfile);
        self::executeAndOutput($install_cron);
        $this->remove_file();
        return $this;
    }

    public function remove_cronjob($cron_jobs=NULL) {
        if (is_null($cron_jobs)) $this->error_message("Nothing to remove!  Please specify a cron job or an array of cron jobs.");
        $this->write_to_file();
        $cron_array = file($this->cron_file, FILE_IGNORE_NEW_LINES);
        if (empty($cron_array)) $this->error_message("Nothing to remove!  The cronTab is already empty.");
        $original_count = count($cron_array);
        if (is_array($cron_jobs)) {
            foreach ($cron_jobs as $cron_regex) $cron_array = preg_grep($cron_regex, $cron_array, PREG_GREP_INVERT); }
        else {
            $cron_array = preg_grep($cron_jobs, $cron_array, PREG_GREP_INVERT); }
        return ($original_count === count($cron_array)) ? $this->remove_file() : $this->remove_crontab()->append_cronjob($cron_array);
    }

    public function remove_crontab() {
        self::executeAndOutput("crontab -r") ;
        $this->remove_file();
        return $this;
    }

    private function crontab_file_exists() {
        return file_exists($this->cron_file);
    }



}