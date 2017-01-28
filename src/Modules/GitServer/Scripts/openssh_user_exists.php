#!/usr/bin/env php
<?php
// Read from cli. First param is the username, second is the ssh command  run.

$username = $argv[1] ;

require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."Constants.php");
require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

$keys = findUserKeys($username) ;
if ($keys === false || count($keys)===0) {
    echo "User does not have keys available\n" ;
    exit (1) ; }


    foreach ($keys as $key) {
        $with_command = 'command="/opt/davewrap.php",no-port-forwarding,no-X11-forwarding,no-pty ' ;
        $new_key = $with_command.$key['key_data'] ;
        echo "$new_key\n" ;
    }
//var_dump($keys);
exit (0);


function findUserKeys($username) {
//    $ray = array("ssh_command" => $ssh_command) ;
    $uskf = new \Model\UserSSHKey();
    $usk = $uskf->getModel(array()) ;
    $res = $usk->getAllKeyDetails($username) ;
    return $res ;
}

?>