<?php

//class Triger {
	
//	function __construct() {
    
//	}
	
//	public function startTriger($input)
//	{
		
           $que = $input['queuename'];
	   $mes = file_get_contents($input["tmpfile"]);

           require_once __DIR__ . '/vendor/autoload.php';
           
           use PhpAmqpLib\Connection\AMQPConnection;
           use PhpAmqpLib\Message\AMQPMessage;

           $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
           $channel = $connection->channel();
           $channel->queue_declare($que, true, true, true, true);
           $msg = new AMQPMessage($mes);
           $channel->basic_publish($msg, '', $que);
           
           echo "Sent $que\n";
           
           $channel->close();
           $connection->close();   

           return;

//	}
//}

?>
