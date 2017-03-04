#!/usr/bin/env php
<?php
// Read from stdin. First line is the username, second line is the password.
$handle = fopen ("php://stdin","r");
$username = trim(fgets($handle));
$password = trim(fgets($handle));

require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."Constants.php");
require_once(dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."AutoLoad.php");

$autoLoader = new \Core\autoLoader();
$autoLoader->launch();

if (userValid($username, $password)=== true) {
    exit (0) ; }

if (oauthKeyValid($username, $password)=== true) {
    exit (0) ; }

// No methods left to try
//echo "username/password allowed for user $username\n";
exit (1);

function userValid($username, $password) {
    // @todo should check if public scope is enabled first probably before authing anon user
    if ($username=="anon") {
        return true ; }
    $signupFactory = new \Model\Signup() ;
    $signup = $signupFactory->getModel(array(), "Default") ;
    $res = $signup->checkLogin($username, $password, false) ;
    if ($res["status"] === true) {
        // dont just return true here
        return true ; }
    return false ;
}

function oauthKeyValid($username, $password) {
    // @todo should check if public scope is enabled first probably before authing anon user
    if ($username=="anon") {
        return false ; }
    $uoakFactory = new \Model\UserOAuthKey() ;
    $uoak = $uoakFactory->getModel(array(), "AuthenticateKey") ;
    $res = $uoak->authenticateOauth($username, $password, false) ;
    if ($res["status"] === true) {
        // don't just return true here
        return true ; }
    return false ;
}

?>