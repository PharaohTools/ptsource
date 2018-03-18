#!/usr/bin/env php
<?php
// Read from cli. First param is the username, second is the ssh command  run.

$username = $argv[1] ;
$repo_name = $argv[2] ;
//$ssh_original_command = $_ENV['SSH_ORIGINAL_COMMAND'] ;
//file_put_contents('/tmp/authlog', 'auth log '.exec('whoami')."\n", FILE_APPEND) ;
//file_put_contents('/tmp/authlog', "\nvalue - ".$username."\n", FILE_APPEND) ;
//file_put_contents('/tmp/authlog', "\norig param - ".$repo_name."\n\n\n\n", FILE_APPEND) ;

$base = '/opt/ptsource/ptsource/src' ;
require_once($base.DIRECTORY_SEPARATOR."Constants.php");
require_once($base.DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

$new_username = userRepoPermissionsValid($username, $repo_name) ;
if ($new_username === false) {
    echo "User does not have permission for this request\n" ;
    exit (1) ; }
echo "OK\n" ;
exit (0);


function userRepoPermissionsValid($username, $repo_name) {
    $ray = array("ssh_command" => $repo_name) ;
    $gsf = new \Model\BinaryServer();
    $gs = $gsf->getModel($ray, 'ServerSSHFunctions') ;
    $res = $gs->sshUserIsAllowed($username, $repo_name) ;
    return $res ;
}

?>