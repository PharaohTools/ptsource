#!/usr/bin/php5
<?php
// Read from stdin. First line is the username, second line is the password.
$handle = fopen ("php://stdin","r");
$username = trim(fgets($handle));
$password = trim(fgets($handle));

// Check the username/password. Below is a very simple example, write your own!
// Probably you want to create a query to some database, add salts, etc.
if($username != 'dave' || $password != '1234'){
    # Output to stdout/stderr will be included in the Apache log for debugging purposes
    echo "wrong username or password for user $username\n";
    # In case of a failure, sleep a few seconds to slowdown bruteforce attacks.
    sleep (3);
    exit (1);
} else {
    echo "username/password allowed for user $username\n";
    exit (0);
}
?>