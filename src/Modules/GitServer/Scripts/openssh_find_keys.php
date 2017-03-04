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
$with_command = 'command="PTGIT_USER='.$hash["username"].' /home/ptgit/ptsource/openssh_wrap_git.bash",no-port-forwarding,no-X11-forwarding,no-pty ' ;
$new_key = $with_command.$hash['key_data'] ;
file_put_contents('/tmp/keyfind', "new key: ".$new_key."\n", FILE_APPEND) ;

echo "$new_key\n" ;
exit (0);


//function findUserKeys($username, $hash) {
//    if ($username === 'ptgit') {
//
////        require_once ('/opt/ptsource/ptsource/src/Modules/DatastoreSQLLite/Libraries/Medoo/medoo.php') ;
//
////        $uskf = new \Model\UserSSHKey();
////        $usk = $uskf->getModel(array()) ;
////        $userAccountF = new \Model\UserAccount();
////        $userAccount = $userAccountF->getModel(array()) ;
////        $users = $userAccount->getUsersData() ;
//
//
//        $dbf = new \Model\Datastore();
//        $db = $dbf->getModel(array()) ;
//
////        $query = 'SELECT * FROM user_ssh_keys WHERE key_data == ""' ;
////
////        $database = new \medoo([
////            'database_type' => 'sqlite',
////            'database_file' => '/opt/ptsource/data/database.db',
////            'charset' => 'utf8'
////        ]);
//
////        $strip_key = stripKey($user_key["key_data"]) ;
//        $req_hash = md5($hash) ;
//
//        $filters = array('user_ssh_keys', array(array('where', 'key_hash', '=', $req_hash))) ;
////        $found = $database->select($filters);
//
//        $found = $db->findOne('user_ssh_keys', $filters) ;
//
//        ob_start();
//        var_dump($found) ;
//        $found_str = ob_get_clean() ;
//
////        var_dump($found) ;
//        file_put_contents('/tmp/keyfind', "\nkey Find {$found["key_hash"]} {$found["key_data"]}"."\n", FILE_APPEND) ;
//        file_put_contents('/tmp/keyfind', "\nDB Find {$found_str}"."\n", FILE_APPEND) ;
//
//        $new_key = array ();
//        $new_key["key_data"] = $found["key_data"] ;
//        $new_key["username"] = $found["user_id"] ;
//        return $new_key ;
//
//    } else {
//        return array() ;
//    }
//}

// original
//
function findUserKeys($username, $hash) {
    if ($username === 'ptgit') {
        $uskf = new \Model\UserSSHKey();
        $usk = $uskf->getModel(array()) ;
        $userAccountF = new \Model\UserAccount();
        $userAccount = $userAccountF->getModel(array()) ;
        $users = $userAccount->getUsersData() ;
        $new_key = array() ;
        foreach ($users as $user) {
            $res = $usk->getAllKeyDetails($user['username']) ;
            foreach ($res as $user_key) {
//                $strip_key = stripKey($user_key["fingerprint"]) ;
//                $strip_key_hash = "" ;
//                file_put_contents('/tmp/keyfind', $strip_key."\n1 - ".strlen($strip_key)."\n\n".$hash."\n2 - ".strlen($hash)."\n", FILE_APPEND) ;
                file_put_contents('/tmp/keyfind', "\nvalue - ".$user_key["fingerprint"]."\n", FILE_APPEND) ;
                file_put_contents('/tmp/keyfind', "\nvalue - ".$hash."\n\n\n\n", FILE_APPEND) ;
                if ($user_key["fingerprint"] === $hash) {
                    file_put_contents('/tmp/keyfind', "\nFound Match".$user['username']."\n\n", FILE_APPEND) ;
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