<?php

Namespace Model;

class SignupAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;


    public function getlogin() {
        $ret="get Login";
        return $ret ;
    }

    //check login
    public function checkLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $this->checkLoginInfo($username, $password);
    }

    //check login status
    public function checkLoginStatus() {
        $url = $_POST['url'];
        $this->checkLoginStatusInfo($url);
    }


    // @todo need to check login credential from datastore or PAM/LDAP
    public function checkLoginInfo($usr, $pass) {
    	$file = __DIR__."/../Data/users.txt";
    	$accountsJson = file_get_contents($file);
    	$accounts = json_decode($accountsJson);
		$verified = FALSE;
		foreach($accounts as $index=>$account) {
			if ($account->username == $usr && $account->password == md5($this->salt.$pass) && $account->removestatus == 0) {
				$verified = TRUE;
			}
		}
		if ($verified === TRUE) {
			$_SESSION["login-status"]=TRUE;
            $_SESSION["username"] = $usr;
		    echo json_encode(array("status" => TRUE));
            return;
        }
		else {
			echo json_encode(array("status" => FALSE, "msg" => "Sorry!! Wrong User name Or Password"));
            return;
		}
    }

    public function checkLoginStatusInfo($url) {
        // login status check
        $url_split = explode("?", $url);
        if(isset($url_split[1])){
            $url_spl = explode("&", $url_split[1]);
            if(isset($url_spl[0])){
                $url_sp = explode("=", $url_spl[0]);
                if(isset($url_sp[1]) && $url_sp[1] =="Signup" || $url_sp[1] == "ldap"){
                    $url_s = explode("=", $url_spl[1]);
                    if(isset($url_s[1]) && ($url_s[1] =="login" || $url_s[1] =="logout" || $url_s[1] =="login-submit" || $url_s[1] =="registration" || $url_s[1] =="registration-submit" || $url_s[1] =="ldaplogin")){
                        echo json_encode(array("status" => TRUE));
                        return;
                    }
                    else
                        $this->checkLoginSession();

                }
                else
                    $this->checkLoginSession();
            }
            else
                $this->checkLoginSession();

        }
        else
            $this->checkLoginSession();

    }
    //@todo we can do autoload.php file before load a controller
    public function checkLoginSession() {
        if(isset($_SESSION["login-status"]) && $_SESSION["login-status"] == TRUE){
            echo json_encode(array("status" => TRUE));
            return;
        }
        else{
            echo json_encode(array("status" => FALSE));
            return;
        }
    }

    public function registrationSubmit(){

        $registrationData=array('username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>md5($this->salt.$_POST['password']),'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'),'status'=> 0,'role'=>3);
        if ($myfile = fopen(__DIR__."/../Data/users.txt", "r")) {
        }
        else {
            echo json_encode(array("status" => FALSE, "id"=>"registration_error_msg", "msg" => "Unable to read users datastore. Contact Administrator."));
            return ;
        }
        $oldData='';
        while(!feof($myfile))
            $oldData.=fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);

        foreach($oldData as $data)
        {
            if($data->username==$_POST['username'])
            {
                echo json_encode(array("status" => FALSE,"id"=>"login_username_alert", "msg" => "User Name Already Exist!!!"));
                return;
            }

            if($data->email==$_POST['email'])
            {
                echo json_encode(array("status" => FALSE,"id"=>"login_email_alert", "msg" => "Email Already Exist!!!"));
                return;
            }

        }

        if ($myfile = fopen(__DIR__."/../Data/users.txt", "w")) { }
        else {
            echo json_encode(array("status" => FALSE, "id"=>"registration_error_msg", "msg" => "Unable to write to users datastore. Contact Administrator."));
            return ; }
        if($oldData==null) { fwrite($myfile, json_encode(array($registrationData))); }
        else{
            fwrite($myfile, json_encode(array_merge($oldData, array($registrationData))));
            // @todo dont hardcode url?
			$message = 'Hi <br /> <a href="/index.php?control=Signup&action=verify&verificationCode=verify">Click here to activate account</a>';
			mail($_POST['email'], 'Verifiation mail from PTBuild', $message); }
       // print_r(array_merge($oldData, array($registrationData)));
        fclose($myfile);
        // @todo dont output from model?
        echo json_encode(array("status" => TRUE, "id"=>"registration_error_msg", "msg" => "Registration Successful!!"));
		return;
    }

    public function allLoginInfoDestroy() {
        session_destroy();
        // return array ("type"=>"control", "control"=>"Signup");
        //return array ("type"=>"control", "control"=>"Signup", "action"=>"login");
         //return array( "Signup" => array("login") );
        header("Location: /index.php?control=Signup&action=login");
    }
    
   public function mailVerification() {
    	$file = __DIR__."/../Data/users.txt";
    	$accountsJson = file_get_contents($file);
    	$accounts = json_decode($accountsJson);
		$verified = FALSE;
		foreach($accounts as $index=>$account) {
			if ($account->verificationcode == $this->params['verificationCode']) {
				$verified = TRUE;
				$accounts[$index][$account->status] = 1;
			}
		}
		if ($verified === TRUE) {
			$accountsJson = json_encode($accounts);
			file_put_contents($file, $accountsJson);
		}
    }
	
	public function loginByOAuth($name, $email, $user){
		$_SESSION["login-status"] = TRUE;
        $_SESSION["username"] = $email;
		$oldData = $this->getUsersData();
		if ($this->userExist($email) == TRUE) {
			$_SESSION["userrole"] = $this->getUserRole($email);
			header("Location: /index.php?control=Index&action=index");
			return;
		}
		else {
			$newUser = array('name' => $name, 'username'=>$email, 'email'=>$email, 'password'=>md5($this->salt.mt_rand(5, 15)), 'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'), 'data'=>$user,'role'=>3,'status'=> 1);
			$this->createNewUser($newUser);
			$_SESSION["userrole"] = 3;
		}
		header("Location: /index.php?control=Index&action=index");
    }
	public function loginByLDAP($name, $email, $user){
		$_SESSION["login-status"] = TRUE;
        $_SESSION["username"] = $email;
		$oldData = $this->getUsersData();
		if ($this->userExist($email) == TRUE) {
			$_SESSION["userrole"] = $this->getUserRole($email);
			header("Location: /index.php?control=Index&action=index");
			return;
		}
		else {
			$newUser = array('name' => $name, 'username'=>$email, 'email'=>$email, 'password'=>md5($this->salt.mt_rand(5, 15)), 'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'), 'data'=>$user,'role'=>3,'status'=> 1);
			$this->createNewUser($newUser);
			$_SESSION["userrole"] = 3;
		}
	}
	
	public function getUsersData()
	{
        if ($myfile = fopen(__DIR__."/../Data/users.txt", "r")) {
        }
        else {
            echo json_encode(array("status" => FALSE, "id"=>"registration_error_msg", "msg" => "Unable to read users datastore. Contact Administrator."));

        }
        $oldData='';
        while(!feof($myfile))
        $oldData.=fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);
		return $oldData;
	}
    
	public function createNewUser($newUser)
	{
		if (!$this->userExist($newUser['email'])) {
			$oldData=$this->getUsersData();
            if ($myfile = fopen(__DIR__."/../Data/users.txt", "w")) {
            }
            else {
                echo json_encode(array("status" => FALSE, "id"=>"registration_error_msg", "msg" => "Unable to write to users datastore. Contact Administrator."));

            }
	        if($oldData==null) {
	            fwrite($myfile, json_encode(array($newUser)));//@todo change format of saved data.
	        }
	        else{
	            fwrite($myfile, json_encode(array_merge($oldData, array($newUser))));//@todo change the format of saved data.
	        }
		}
	}
    
    public function userExist($email)
    {
    	$users = $this->getUsersData();
		foreach ($users as $user) {
			if ($user->email== $email)
				return TRUE;
		}
		return FALSE;
    }
    
    public function getUserRole($email) {
		   	if ($this->userExist($email)) {
			$users = $this->getUsersData();
			foreach ($users as $user) {
				if ($user->email== $email)
					return $user->role;
			}
		}
		return 3;
    }
	
	public function putUsersData($data = null)
	{
		if ($data != NULL) {
		    if (!$myfile = fopen(__DIR__."/../../Signup/Data/users.txt", "w")) return FALSE;
			fwrite($myfile, json_encode($data));
		    fclose($myfile);
		}
	}
    
	
}
