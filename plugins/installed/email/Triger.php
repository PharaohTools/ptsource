<?php
class Triger {
	
	function __construct() {
		
	}

	public function startTriger($input){
		$to = $input['email_id'];
		$sub = 'alert';
		$msg = 'running steps'.$input['email_id'];
		
		if ( mail($to,$sub,$msg) ) {
			echo "Mail sent successfully!<br>\n";
		        return true;
		} else {
			echo "Mail sending failed <br>\n";
		        return false;
		}
		echo 'hai';
	}
}