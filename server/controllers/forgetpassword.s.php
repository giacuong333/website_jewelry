<?php

class ForgetPassWordContr extends ForgetPassWordModel
{
    public function getPasswordByEmail($email)
    {
        return ForgetPassWordModel::getPasswordByEmail($email);
    }

    public function generateRandomPassword($length = 8)
    {
        return ForgetPassWordModel::generateRandomPassword($length = 8);
    }

    public function updatePasswordByEmail($email, $hashed_password)
    {
        return ForgetPassWordModel::updatePasswordByEmail($email, $hashed_password);
    }
}
