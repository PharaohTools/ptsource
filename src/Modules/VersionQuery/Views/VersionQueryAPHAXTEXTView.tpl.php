<?php


//var_dump(count($pageVars["data"])) ;

if (count($pageVars["data"]) === 1) {
    foreach ($pageVars["data"] as $group => $version_info) {
        echo $version_info['version']."\n" ;
    }
} else {
    foreach ($pageVars["data"] as $group => $version_info) {
        echo "$group: " ;
        echo $version_info['version']."\n" ;
    }
}


?>