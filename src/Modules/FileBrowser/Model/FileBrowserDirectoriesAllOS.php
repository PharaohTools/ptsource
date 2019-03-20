<?php

Namespace Model ;

class FileBrowserDirectoriesAllOS extends Base {

    public static function performOSFunction($pageVars) {

        $output = '' ;
        if (!isset($pageVars['params']['command'])) {
            $ray = array() ;
            $ray['error'] = 'Command parameter is required' ;
            $output = json_encode($ray) ;
            echo $output ;
            return false ;
        }

        if ($pageVars['params']['command'] == 'find_directories') {
            \js_core::$console->log('find_directories os function') ;
            $path = $pageVars['params']['path'] ;
            # !IMPORTANT, CHECK THIS IS WITHIN CHROOT OF REPODIR
            $all_paths = scandir($path) ;
            $all_dirs = [] ;
            foreach ($all_paths as $one_path) {
                if (in_array($one_path, ['.', '..'])) {
                    continue ;
                }
                $dir_path = $path.DIRECTORY_SEPARATOR.$one_path ;
                if (is_dir($dir_path)) {
                    $all_dirs[] = $dir_path ;
                }
            }
            $output = new \StdClass() ;
            $output->path = $path ;
            $output->directories = $all_dirs ;
            echo json_encode($output, JSON_PRETTY_PRINT);
        }

        return $output ;
    }


}
