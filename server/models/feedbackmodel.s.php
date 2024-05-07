<?php
class FeedbackModel extends Database
{
    protected function addFeedback($name, $email, $message, $phonenumber)
    {
        try {
            $sql = "INSERT INTO contact(fullname, email, content, phone_number) VALUES(?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$name, $email, $message, $phonenumber]);
            return true;
        } catch (Exception $e) {
            $e->getMessage();
            return false;
        }
    }
}
