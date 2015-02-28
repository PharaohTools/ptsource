<?php
require_once __DIR__ . '/vendor/autoload.php';       
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class rabbitmq {
	
	function __construct() {
    
	}
	
	public function startTriger($input)
	{
		
       $que = $input['Queuename'];
	   $portno = $input['Port'];
	   $host = $input['Hostname'];
	   $user = $input['Username'];
	   $pass = $input['Password'];
	   $mes = file_get_contents($input["tmpfile"]);

           
       $connection = new AMQPConnection($host, $portno, $user, $pass);
       $channel = $connection->channel();
       $channel->queue_declare($que, true, true, true, true);
       $msg = new AMQPMessage($mes);
       $channel->basic_publish($msg, '', $que);
       
       echo "Sent $que\n";
       
       $channel->close();
       $connection->close();   

       return true;

	}
}

?>
