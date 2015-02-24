<?php
class Triger {
	
	function __construct() {
		
	}
	
	public function startTriger($input)
	{
         // $user = $input['username'];
        //  $pass = $input['password'];
            $host = $input['hostname'];
            $db1 = $input['dbname'];
            $tit = $input['title'];
            $col = $input['collection'];
            $tmpfile = $input['tmpfile'];
            $path1 = $input['path'];
            $m = new MongoClient($host);
            //$m = new MongoClient(mongodb://$host);
            
            echo "Connection to database successfully \n";
            $db = $m->$db1;
            echo "Database mydb selected \n";
            $collection = $db->$col;
            echo "Collection selected succsessfully \n";

            $document = array( 
               "title" => "$tit",
               "build report" => file_get_contents($tmpfile),
               "output" => file_get_contents($path1),
               "time" => date("Y-m-d h:i:sa", time()),
		
            );
               $collection->insert($document);
               echo "Document inserted successfully \n";

    }

}



