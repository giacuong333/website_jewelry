<?php

class LoginController extends Login
{

      private $useremail;
      private $password;

      function __construct($useremail,  $password)
      {
            $this->useremail = $useremail;
            $this->password = $password;
      }

      function loginUser()
      {
            if ($this->isEmpty()) {
                  header("location: ../templates/login.php?error=emptyinput");
                  exit();
            }

            $this->getUser($this->useremail, $this->password);
      }

      private function isEmpty()
      {
            return empty($this->useremail) || empty($this->password);
      }
}
