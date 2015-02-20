<?php

class Triger {
	
	function __construct() {
		
	}
	
	public function startTriger($input)
	{
		
	   $tok = $input['token'];
	   $id = $input['projectid'];
	   $queue_name = $input["queuename"];
	   $mes = file_get_contents($input["tmpfile"]);

		   
		require __DIR__ . '/vendor/autoload.php';
		
		//require 'src/HttpException.php';
		//require 'src/IronCore.php';
		//require 'src/IronMQ.php';
		//require 'src/IronMQException.php';
		//require 'src/IronMQMessage.php';
		//require 'src/JsonException.php';
		
		$ironmq = new \IronMQ\IronMQ(array(
		    "token" => $tok,
		    "project_id" => $id
		));
		$ironmq->postMessage($queue_name, $mes);
	}
}
