<?php
namespace ec_website;

class Signout extends \ec_website\Controller {
    
    public function startSignout() {

      if ($this->loginStatus()) { 
          $this->signoutProcess();
      }
      
    }
    
    protected function signoutProcess() {

        session_unset();
        header('Location: ' . SITE_URL);
        exit();
    }
}