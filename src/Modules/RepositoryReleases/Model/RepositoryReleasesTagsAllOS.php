<?php

Namespace Model;

class RepositoryReleasesTagsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Tags") ;

    public function getAvailableTags() {
        $rrf = new \Model\RepositoryReleases() ;
        $rr = $rrf->getModel($this->params, 'Default') ;
        $filebrowserDir = $rr->repoRootDir() ;
        $command = "cd {$filebrowserDir} && git show --tags" ;
        $all_tags_string = $this->executeAndLoad($command) ;
        $all_tags_ray = $this->transformTagStringToArray($all_tags_string) ;
        $all_tags_ray = array_reverse($all_tags_ray) ;
        return $all_tags_ray ;
    }

    public function getTagCount() {
        $all_tags_ray = $this->getAvailableTags() ;
        $count = count($all_tags_ray) ;
        return $count;
    }

    protected function transformTagStringToArray($all_tags_string) {
        $all_lines_ray = explode("\n", $all_tags_string) ;
        $all_lines_ray = array_diff($all_lines_ray, array("")) ;
        $all_tags = array() ;
        while (count($all_lines_ray)>0) {
            if (count($all_lines_ray)>0) {
                $result_ray = $this->loadNextArray($all_lines_ray) ;
                if (is_array($result_ray[1])) {
                    $all_lines_ray = $result_ray[0] ;
                    $all_tags[] = $result_ray[1] ;
                } else {
                    break ;
                }
            } else {
                break ;
            }
        }
        return $all_tags ;
    }


    protected function loadNextArray($remaining_lines) {

        $tag_ray = array() ;
        if (strpos($remaining_lines[0], 'tag ')===0) {
            $tag_ray['tag'] = substr($remaining_lines[0], 4) ;
        }

        if (strpos($remaining_lines[1], 'Tagger: ')===0) {
            $tag_ray['tagger'] = substr($remaining_lines[1], 8) ;
        }

        if (strpos($remaining_lines[2], 'Date:   ')===0) {
            $tag_ray['date'] = substr($remaining_lines[2], 8) ;
        }

        if (strpos($remaining_lines[4], 'tag ')===0) {
            $remaining = array_slice($remaining_lines, 4 ) ;
            if (array_key_exists('tag', $tag_ray)) {
                return array($remaining, $tag_ray) ;
            }
            else {
                return false ;
            }
        }

        if (isset($remaining_lines[4]) && $remaining_lines[4] !== '') {
            $tag_ray['message'] = $remaining_lines[4] ;
        }

        $cur_line = 5 ;
//        for ($i=5; $i<250; $i++) {
//            $cur_line = $i ;
//            if (!isset($remaining_lines[$i]) || ( isset($remaining_lines[$i]) && $remaining_lines[$i] === "\n") ) {
//                break ;
//            } else {
//                var_dump('abxx:' ,$remaining_lines[$i] ) ;
//                $tag_ray['message'] .= $remaining_lines[$i] ;
//            }
//        }
//
        $cur_line ++ ;

        if (strpos($remaining_lines[$cur_line], 'tag ')===0) {
            $remaining = array_slice($remaining_lines, $cur_line+1 ) ;
            if (array_key_exists('tag', $tag_ray)) {
                return array($remaining, $tag_ray) ;
            }
            else {
                return false ;
            }
        }


        if (strpos($remaining_lines[$cur_line], 'commit ')===0) {
            $remaining = array_slice($remaining_lines, $cur_line+5 ) ;
            $tag_ray['commit'] = substr($remaining_lines[$cur_line], 8) ;
            if (array_key_exists('tag', $tag_ray)) {
                return array($remaining, $tag_ray) ;
            }
            else {
                return false ;
            }
        }

        if (array_key_exists('tag', $tag_ray)) {
            return array(array(), $tag_ray) ;
        }
        else {
            return false ;
        }

    }

}