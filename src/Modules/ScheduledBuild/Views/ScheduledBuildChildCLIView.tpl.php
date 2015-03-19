<?php

echo "Executing Scheduled Builds\n" ;

if (count($pageVars["data"]["scheduled"])>0) {
    foreach ($pageVars["data"]["scheduled"] as $pipe) {
        // echo $pipe["project-name"]."\n" ;
    }
    foreach ($pageVars["data"]["executions"] as $pipeTailSlug => $pipeTailDetails) {
        echo "Slug: ".$pipeTailSlug.", Name: ".$pipeTailDetails["name"].", Run ID ".$pipeTailDetails["result"]."\n" ; } }
else {
    echo "No Builds scheduled to run now\n" ; }