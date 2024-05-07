<?php
class Feedbackcontr extends FeedbackModel
{
    public function addFeedback($name, $email, $message, $phonenumber)
    {
        return FeedbackModel::addFeedback($name, $email, $message, $phonenumber);
    }
}
