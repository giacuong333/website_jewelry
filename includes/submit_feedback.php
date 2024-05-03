<?php 
include_once("../server/connection/connect.s.php");
include_once("../server/models/feedbackmodel.s.php");
include_once("../server/controllers/feedbackcontr.s.php");

if($_POST["submit_feedback"]){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $feedback = new Feedbackcontr();
    $is_added =  $feedback->addFeedback($name,$email,$message);
    if($is_added) {
        echo "<script>alert('Gửi feedback thành công')</script>";
        header('../templates/feedback.php');
    }
    else{
        echo "<script>alert('Gửi feedback thất bại!')</script>";
        header('../templates/feedback.php');
    }
}