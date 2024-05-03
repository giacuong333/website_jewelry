<?php
class Feedbackcontr extends FeedbackModel {
     public function addFeedback($name,$email,$message){
        return FeedbackModel::addFeedback($name,$email,$message);
    }
}