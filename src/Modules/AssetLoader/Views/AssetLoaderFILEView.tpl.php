<?php

    if (isset($pageVars["data"]["mime-type"]) && strlen($pageVars["data"]["mime-type"])>0) {
        header('Content-type:'.$pageVars["data"]["mime-type"], true);
        header('Content-Disposition: inline; '.$pageVars["data"]["asset-filename"]) ;
    }

    echo $pageVars["data"]["asset"] ;