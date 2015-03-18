<?php

echo "Executing Scheduled Builds\n" ;

if (count($pageVars["data"]["scheduled"])>0) {
    foreach ($pageVars["data"]["scheduled"] as $pipe) {
        echo $pipe["project-name"]."\n" ; } }
else {
    echo "No Builds scheduled to run now\n" ; }