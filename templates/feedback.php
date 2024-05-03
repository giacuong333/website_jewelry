<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/config.css"> <!-- Đường dẫn tới tập tin CSS của bạn -->
    <link rel="stylesheet" href="../assets/css/feedback.css"> <!-- CSS cho trang phản hồi -->

    <!-- JQUERY -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script> <!-- Đường dẫn tới jQuery -->

    <!-- JavaScript -->
    <script src="../js/feedback.js" type="module"></script> <!-- JavaScript cho trang phản hồi -->
</head>

<body>
    <?php
    include_once("../templates/header.php"); // Bao gồm tiêu đề hoặc thanh điều hướng nếu cần
    ?>

    <div class="feedback-container">
        <h1>Feedback Form</h1>
        <form id="feedback-form" action="../includes/submit_feedback.php" method="post">
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" />
            </div>
            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" />
            </div>
            <div class="form-group">
                <label for="message">Your Feedback:</label>
                <textarea id="message" name="message" placeholder="Enter your feedback"></textarea>
            </div>
            <button type="submit" name="submit_feedback" value="submit_feedback">Submit Feedback</button>
        </form>
    </div>

    <?php
    include_once("../templates/footer.php"); 
    ?>
</body>

</html>