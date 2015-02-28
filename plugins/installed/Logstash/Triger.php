<?php
class Logstash {
	
	function __construct() {
		
	}

	public function startTriger($input){
		$errno  = 0;
		$tmpfile = $input["tmpfile"];
		$errstr = file_get_contents($tmpfile);
		$fp = stream_socket_client("tcp://".$input['Host (TCP)'].":".$input['Port No'], $errno, $errstr, 30);
		if (!$fp) {
		    echo "Faild: Push to logstash\n";
		}
		{
			echo "Success: Pushed in to logstash\n";
		}
	}
}