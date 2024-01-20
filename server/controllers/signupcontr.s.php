<?php

class SignupController extends Signup
{
          private $fullname;
          private $email;
          private $phone_number;
          private $password;
          private $role;

          function __construct($fullname, $email, $phone_number, $password, $role)
          {
                    $this->fullname = $fullname;
                    $this->email = $email;
                    $this->phone_number = $phone_number;
                    $this->password = $password;
                    $this->role = $role;
          }

          public function signupUser()
          {
                    if (!$this->isEmpty()) {
                              header("location: ../index.html?error=emptyinput");
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

                    $this->setUser($this->fullname, $this->email, $this->phone_number, $this->password, $this->role);
          }

          private function isEmpty()
          {
                    return empty($this->fullname) || empty($this->email) || empty($this->phone_number) || empty($this->password) || empty($this->role);
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
