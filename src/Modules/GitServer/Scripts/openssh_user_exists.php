#!/usr/bin/env php
<?php

// Read from cli. First param is the username, second is the ssh command  run.
$username = $argv[1] ;
require_once( dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "Constants.php" );
require_once( dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "AutoLoad.php" );

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

$exists = findUser($username) ;
if ($exists === true) {
    exit (0) ; }
echo "User not found\n" ;
exit (1) ;

function findUser($username) {
    $sf = new \Model\Signup();
    $s = $sf->getModel(array()) ;
    $res = $s->userNameExist($username) ;
    return $res ;
}

?>