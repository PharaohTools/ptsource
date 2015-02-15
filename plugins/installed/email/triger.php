<?php

$to = $inputjson['email_id'];
$sub = 'alert';
$msg = 'running steps';

if ( mail($to,$sub,$msg) ) {
	echo "Mail sent successfully!<br>\n";
} else {
	echo "Mail sending failed <br>\n";
}