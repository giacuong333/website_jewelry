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
            echo json_encode(["error" => "emptyinput"]);
            exit();
        }

        if (!$this->isEmail()) {
            echo json_encode(["error" => "email"]);
            exit();
        }

        if ($this->isEmailTaken()) {
            echo json_encode(["error" => "emailtaken"]);
            exit();
        }

        if ($this->isPhoneNumberTaken()) {
            echo json_encode(["error" => "phonenumbertaken"]);
            exit();
        }

        $result = $this->setUser($this->fullname, $this->email, $this->phone_number, $this->password);
        echo json_encode(["success" => $result]);
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

    private function isPhoneNumberTaken()
    {
        return $this->checkPhoneNumber($this->phone_number);
    }
}
