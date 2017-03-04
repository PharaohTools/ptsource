<?php

Namespace Model;

class SignupRegistrationAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Registration") ;

    public function registrationSubmit() {
        $registrationData = array('username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>md5($this->getSalt().$_POST['password']),'verificationcode'=> hash('sha512', 'aDv@4gtm%7rfeEg4!gsFe'),'status'=> 0,'role'=>3);
        if ($myfile = fopen($this->getUserFileLocation(), "r")) { }
        else {
            return array("status" => false, "id"=>"registration_error_msg", "msg" => "Unable to read users datastore. Contact Administrator."); }
        $oldData='';
        while(!feof($myfile))
            $oldData.=fgets($myfile);
        fclose($myfile);
        $oldData=json_decode($oldData);

        foreach($oldData as $data) {
            if ($data['username']==$_POST['username']) {
                return array("status" => false,"id"=>"login_username_alert", "msg" => "User Name Already Exist!!!");}
            if ($data->email==$_POST['email']) {
                return array("status" => false,"id"=>"login_email_alert", "msg" => "Email Already Exist!!!"); } }

        if ($myfile = fopen($this->getUserFileLocation(), "w")) { }
        else {
            return array("status" => false, "id"=>"registration_error_msg", "msg" => "Unable to write to users datastore. Contact Administrator.");  }
        if($oldData==null) {
            fwrite($myfile, json_encode(array($registrationData))); }
        else{
            fwrite($myfile, json_encode(array_merge($oldData, array($registrationData))));
            // @todo dont hardcode url?
            $message = 'Hi <br /> <a href="/index.php?control=Signup&action=verify&verificationCode=verify">Click here to activate account</a>';
            mail($_POST['email'], 'Verification mail from '.PHARAOH_APP, $message); }
        // print_r(array_merge($oldData, array($registrationData)));
        fclose($myfile);
        // @todo dont output from model?
        return array("status" => true, "id"=>"registration_error_msg", "msg" => "Registration Successful!!") ;
    }

    public function mailVerification() {
        $file = $this->getUserFileLocation();;
        $accountsJson = file_get_contents($file);
        $accounts = json_decode($accountsJson);
        $verified = false;
        foreach($accounts as $index=>$account) {
            if ($account->verificationcode == $this->params['verificationCode']) {
                $verified = true;
                $accounts[$index][$account->status] = 1; } }
        if ($verified === true) {
            $accountsJson = json_encode($accounts);
            file_put_contents($file, $accountsJson); }
    }

}
