<?php

$un = $input['Username'];
$pwd = $input['Password'];
$ip = $input['IP Address'];
$lph = $input['Source File'];
$sph = $input['Destination File with Path'];

if (!function_exists("ssh2_connect"))
{
    echo "shh2_connect doesn't exist";
    return false;
}

$con = ssh2_connect("$ip", 22);

if(!($con = ssh2_connect("$ip", 22))){
    echo "unable to establish connection\n";
} else {

    if(!ssh2_auth_password($con, "$un", "$pwd")) {
        echo "unable to authenticate\n";
    } else {

        echo "logged in...\n";


        if (!ssh2_scp_send($con, "$lph", "$sph", 0644)) {
            echo "Unable to send file\n";
        } else {
           echo "File sent\n";
        }
    }
}
?>

