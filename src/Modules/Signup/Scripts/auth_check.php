#!/usr/bin/php5
<?php
// Read from stdin. First line is the username, second line is the password.
$handle = fopen ("php://stdin","r");
$username = trim(fgets($handle));
$password = trim(fgets($handle));


require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."Constants.php");
require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."AutoLoad.php");


$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

if (userValid($username, $password)==false) {
    exit (1) ; }

echo "username/password allowed for user $username\n";
exit (0);

function userValid($username, $password) {
    $signupFactory = new \Model\Signup() ;
    $signup = $signupFactory->getModel(array(), "Default") ;
    $res = $signup->checkLogin($username, $password, false) ;
    if ($res["status"] == true) { return true ; }
    return false ;
}




?>