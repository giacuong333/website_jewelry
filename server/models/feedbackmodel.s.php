<?php 
class FeedbackModel extends Database {
    protected function addFeedback($name,$email,$message){
        try{
            $sql = "INSERT INTO contact(fullname,email,content) VALUES(?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$name,$email,$message]);
            return true;
        }
        catch(Exception $e) {
            $e->getMessage();
            return false;
            }
    }
}