#!/usr/bin/env php
<?php
// Read from cli. First param is the username, second is the ssh command  run.

$username = $argv[1] ;
$ssh_command = $argv[2] ;

require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."Constants.php");
require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

if (userRepoPermissionsValid($username, $ssh_command) === false) {
    echo "User does not have permission for this request\n" ;
    exit (1) ; }
echo "OK\n" ;
exit (0);


function userRepoPermissionsValid($username, $ssh_command) {
    $ray = array("ssh_command" => $ssh_command) ;
    $gsf = new \Model\GitServer();
    $gs = $gsf->getModel($ray, 'ServerSSHFunctions') ;
    $res = $gs->sshUserIsAllowed($username, $ssh_command) ;
    return $res ;
}

?>