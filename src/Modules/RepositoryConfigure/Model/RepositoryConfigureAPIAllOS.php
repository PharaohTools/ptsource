<?php

Namespace Model;

class PublishStatusAPIAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("API") ;

    public function allowedFunctions() {
        return array('get_status') ;
    }

    public function get_status() {

        // load repo
        $this->params['item'] = $this->params['slug'] ;
        $pbsf = new \Model\PublishStatus() ;
        $pbs = $pbsf->getModel($this->params) ;
        $pipeline = $pbs->getPipeline() ;

        $matching_run_id = false ;
        $criteria = $this->calculateCriteria($this->params['criteria']) ;
        foreach ($pipeline['history_index'] as $run_id => $historical_build) {

            $matched_crits = array() ;
            foreach ($criteria as $criterion) {
                if ($criterion["type"] === "param") {
                    if ($pipeline['history_index'][$run_id]['params'][$criterion["key"]] == $criterion["value"]) {
                        $matched_crits[] = $criterion ;
                    } else {
                        continue 1 ;
                    }
                } else if ($criterion["type"] === "meta") {
                    if ($pipeline['history_index'][$run_id]['meta'][$criterion["key"]] == $criterion["value"]) {
                        $matched_crits[] = $criterion ;
                    } else {
                        continue 1 ;
                    }
                }
            }
            if (count($matched_crits) == count($criteria)) {
                $matching_run_id = $run_id ;
                break 1 ;
            }
        }

        if ($matching_run_id === false) {
            return false ;
        }

        $status_string = $pipeline['history_index'][intval($matching_run_id)]['status'] ;
        $run_id = $matching_run_id ;
        $run_time = $pipeline['history_index'][intval($matching_run_id)]['start'] ;

        $ret = array(
            'status' => $status_string,
            'run_id' => $run_id,
            'build_job_title' => $pipeline['project-name'],
            'build_job_link' => 'http://'.$_SERVER["SERVER_NAME"].'/index.php?control=BuildHome&action=show&item='.$this->params['slug'],
            'build_run_link' => 'http://'.$_SERVER["SERVER_NAME"].'/index.php?control=PipeRunner&action=summary&item='.$this->params['slug'].'&run-id='.$run_id,
            'build_run_time' => $run_time,
        ) ;

        return $ret ;

    }

    public function calculateCriteria($criteria) {
        $criteriaLines = explode("\n", $criteria) ;
        $all_criteria = array() ;
        foreach ($criteriaLines as $criteriaLine) {
            $criteriaParts = explode(":::", $criteriaLine) ;
            $one_criteria["type"] = $criteriaParts[0] ;
            $one_criteria["key"] = $criteriaParts[1] ;
            $criteriaParts[2] = rtrim($criteriaParts[2], "\n\r\t");
            $one_criteria["value"] = $criteriaParts[2] ;
            $all_criteria[] = $one_criteria ;
        }
        return $all_criteria ;
    }

}
