<?php

class SignupController extends Signup
{
          private $fullname;
          private $email;
          private $phone_number;
          private $password;

          function __construct($fullname, $email, $phone_number, $password)
          {
                    $this->fullname = $fullname;
                    $this->email = $email;
                    $this->phone_number = $phone_number;
                    $this->password = $password;
          }

          public function signupUser()
          {
                    if ($this->isEmpty()) {
                              header("location: ../index.php?error=emptyinput");
                              exit();
                    }

                    if (!$this->isEmail()) {
                              header("location: ../index.php?error=email");
                              exit();
                    }

                    if ($this->isEmailTaken()) {
                              header("location: ../index.php?error=emailtaken");
                              exit();
                    }

                    $this->setUser($this->fullname, $this->email, $this->phone_number, $this->password);
          }

          private function isEmpty()
          {
                    return empty($this->fullname) || empty($this->email) || empty($this->phone_number) || empty($this->password);
          }

          private function isEmail()
          {
                    return filter_var($this->email, FILTER_VALIDATE_EMAIL);
          }

          private function isEmailTaken()
          {
                    return $this->checkUser($this->email);
          }
}
