<?php

class Ironmq {
	
	function __construct() {
		
	}
	
	public function startTriger($input)
	{
		
	   $tok = $input['Token'];
	   $id = $input['Projectid'];
	   $queue_name = $input["Queuename"];
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
