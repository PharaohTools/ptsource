#!/usr/bin/env php
<?php
// Read from cli. First param is the username, second is the ssh command  run.

$username = $argv[1] ;
$key = (isset($argv[2])) ? $argv[2] : "" ;
$type = (isset($argv[3])) ? $argv[3] : "" ;
$fingerprint = (isset($argv[4])) ? $argv[4] : "" ;


$base = '/opt/ptsource/ptsource/src' ;
require_once($base.DIRECTORY_SEPARATOR."Constants.php");
require_once($base.DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

$key = findUserKeys($username, $key) ;
if ($key === false || count($key)===0) {
    echo "User does not have keys available\n" ;
    exit (1) ; }
//$with_command = 'command="/opt/Scripts/openssh_wrap_git.bash",environment="PTGIT_KEY='.$key.'",no-port-forwarding,no-X11-forwarding,no-pty ' ;
$with_command = 'command="PTGIT_USER=\''.$key["username"].'\' /home/ptgit/ptsource/openssh_wrap_git.bash",no-port-forwarding,no-X11-forwarding,no-pty ' ;
//$with_command = 'command="/Scripts/openssh_wrap_git.bash ",no-port-forwarding,no-X11-forwarding,no-pty ' ;
$new_key = $with_command.$key['key_data'] ;
file_put_contents('/tmp/keyfind', "new key: ".$new_key."\n", FILE_APPEND) ;

echo "$new_key\n" ;
exit (0);


function findUserKeys($username, $key) {
    if ($username === 'ptgit') {
        $uskf = new \Model\UserSSHKey();
        $usk = $uskf->getModel(array()) ;
        $signupF = new \Model\Signup();
        $signup = $signupF->getModel(array()) ;
        $users = $signup->getUsersData() ;
        $new_key = array() ;
        foreach ($users as $user) {
            $res = $usk->getAllKeyDetails($user->username) ;
            foreach ($res as $user_key) {
                $strip_key = stripKey($user_key["key_data"]) ;
                file_put_contents('/tmp/keyfind', $strip_key."\n1 - ".strlen($strip_key)."\n\n".$key."\n2 - ".strlen($key)."\n", FILE_APPEND) ;
                file_put_contents('/tmp/keyfind', "\nvalue - ".($strip_key === $key)."\n", FILE_APPEND) ;
                file_put_contents('/tmp/keyfind', "\nvalue - ".($strip_key == $key)."\n\n\n\n", FILE_APPEND) ;
                if ($strip_key === $key) {
                    file_put_contents('/tmp/keyfind', "\nFound Match - ".$user->username."\n\n", FILE_APPEND) ;
                    $new_key["key_data"] = $user_key["key_data"] ;
                    $new_key["username"] = $user->username ;
                    return $new_key ;
                }
            }
        }
        return array() ;
    } else {
        return array() ;
    }
}

function stripKey($orig) {
    $new = str_replace("ssh-rsa ", "", $orig) ;
    $pos = strpos($new, " ") ;
    $res = substr($new, 0, $pos) ;
    return $res ;
}

?>