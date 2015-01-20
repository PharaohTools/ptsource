<?php

Namespace Controller ;

class Signup extends Base {

    public function execute($pageVars) {
      $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
      // if we don't have an object, its an array of errors
      $this->content = $pageVars ;
      if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
      if($pageVars["route"]["action"] == "login"){
            $this->content["data"] = $thisModel->getlogin();
      }
      if($pageVars["route"]["action"] == "login_submit"){
          $username = $_POST['username'];
          $password = $_POST['password'];
          $user_info = $thisModel->Checklogin($username, $password);
          if ($user_info == NULL) {
              echo json_encode(array("status" => FALSE, "msg" => 'Sorry!! Wrong User name Or Password'));
              return;
          } else {
              // Start the session
              session_start();
              $_SESSION["username"] = $username;
              echo json_encode(array("status" => TRUE));
              return;
          }
      }
      if($pageVars["route"]["action"] == "logout"){
          $thisModel->allLogininfodestroy();
          header("Location: /index.php?control=Signup&action=login");
          die();
      }
      return array ("type"=>"view", "view"=>"signup", "pageVars"=>$this->content);
    }
}
