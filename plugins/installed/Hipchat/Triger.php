<?php

require __DIR__ . '/vendor/autoload.php';
use GorkaLaucirica\HipchatAPIv2Client\Auth\OAuth2;
use GorkaLaucirica\HipchatAPIv2Client\Client;
use GorkaLaucirica\HipchatAPIv2Client\API\RoomAPI;
use GorkaLaucirica\HipchatAPIv2Client\Model\Message;


class Hipchat {

	function __construct() {

	}

	public function startTriger($input) {

		$auth = new OAuth2($input['Token']);
		$client = new Client($auth);
		$roomAPI = new RoomAPI($client);
		$msg['id'] = $input['Room Id or Name'];
		$msg['message'] = "Pipe Name: ".$input['pipeName']."\n Satus: ";
		$msg['from'] = $input['From'];
		$msg['date'] = time();
		$msg['message_format'] = "text";
		$msg['notify'] = false;
		$msg['color'] = 'random';
		$message = new Message($msg);
		$roomAPI->sendRoomNotification($input['Room Id or Name'], $message );
	}

}