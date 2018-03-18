#!/usr/bin/env php
<?php
// Read from cli. First param is the username, second is the ssh command  run.
file_put_contents('/tmp/keyfind', "\nRunning: ".__FILE__."\n\n", FILE_APPEND) ;


$username = $argv[1] ;
$hash = (isset($argv[2])) ? $argv[2] : "" ;
$type = (isset($argv[3])) ? $argv[3] : "" ;
$fingerprint = (isset($argv[4])) ? $argv[4] : "" ;


$base = '/opt/ptsource/ptsource/src' ;
require_once($base.DIRECTORY_SEPARATOR."Constants.php");
require_once($base.DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

$hash = findUserKeys($username, $hash) ;
if ($hash === false || count($hash)===0) {
    echo "User does not have keys available\n" ;
    exit (1) ; }
// PTGIT_USER='.$hash["username"].'
$with_command = 'command="PTGIT_USER='.$hash["username"].' /home/ptbinary/ptsource/openssh_wrap_binary.bash",no-port-forwarding,no-X11-forwarding,no-pty ' ;
$new_key = $with_command.$hash['key_data'] ;
//file_put_contents('/tmp/keyfind', "new key: ".$new_key."\n", FILE_APPEND) ;

echo "$new_key\n" ;
exit (0);

function findUserKeys($username, $hash) {
    if ($username === 'ptbinary') {
        $uskf = new \Model\UserSSHKey();
        $usk = $uskf->getModel(array()) ;
        $userAccountF = new \Model\UserAccount();
        $userAccount = $userAccountF->getModel(array()) ;
        $users = $userAccount->getUsersData() ;
        $new_key = array() ;
        foreach ($users as $user) {
            $res = $usk->getAllKeyDetails($user['username']) ;
            foreach ($res as $user_key) {
//                file_put_contents('/tmp/keyfind', "\nvalue - ".$user_key["fingerprint"]."\n", FILE_APPEND) ;
//                file_put_contents('/tmp/keyfind', "\nvalue - ".$hash."\n\n\n\n", FILE_APPEND) ;
                if ($user_key["fingerprint"] === $hash) {
//                    file_put_contents('/tmp/keyfind', "\nFound Match".$user['username']."\n\n", FILE_APPEND) ;
                    $new_key['key_data'] = $user_key['key_data'] ;
                    $new_key["username"] = $user['username'] ;
                    return $new_key ;
                }
            }
        }
        return array() ;
    } else {
        return array() ;
    }
}

function findFinger() {

    $finger_command = '#!/bin/bash '."\n".'ssh-keygen -lf /dev/stdin <<<"'.$this->params["new_ssh_key"].'"' ;
    ob_start() ;
    $this->executeAsShell($finger_command) ;
    $finger_str = ob_get_clean() ;

    $finger_parts = explode(' ', $finger_str) ;
    $finger = $finger_parts[1] ;
    return $finger ;
}

function stripKey($orig) {
    $new = str_replace("ssh-rsa ", "", $orig) ;
    $pos = strpos($new, " ") ;
    $res = substr($new, 0, $pos) ;
    return $res ;
}

?>