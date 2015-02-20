<?php
class Triger {
	
	function __construct() {
		
	}
	
	public function startTriger($input)
	{
            $db1 = $input['dbname'];
            $tit = $input['title'];
            $tmpfile = $input["tmpfile"];
            $m = new MongoClient();
            echo "Connection to database successfully \n";
            $db = $m->$db1;
            echo "Database mydb selected \n";
            $collection = $db->mycol;
            echo "Collection selected succsessfully \n";

            $document = array( 
               "title" => "$tit",
               "build report" => file_get_contents($tmpfile),
               "time" => date("Y-m-d h:i:sa", time()),
		
            );
               $collection->insert($document);
               echo "Document inserted successfully \n";

    }

}



