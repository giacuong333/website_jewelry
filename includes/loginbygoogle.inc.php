<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../server/connection/connect.s.php';

use Dotenv\Dotenv;
use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

if (session_status() === PHP_SESSION_NONE)
      session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize configuration
$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'];

// Create Google Client instance
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->setPrompt("select_account"); // Prompt user to select account on login
$client->addScope("email");
$client->addScope("profile");

// Authenticate code from Google OAuth Flow
if (isset($_GET['code'])) :
      try {
            // Exchange authorization code for access token
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // Get profile information from Google OAuth
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email = $google_account_info->email;
            $name = $google_account_info->name;
            $phoneNumber = $google_account_info->phone;

            // Use this profile info to create or update account in your website
            $database = new Database();

            // Check if user already exists in your database
            $statement = $database->connect()->prepare("SELECT * FROM `user` WHERE email = ?");
            $statement->execute([$email]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) :
                  // User exists, set session variables and redirect to homepage
                  $_SESSION["id"] = $user["id"];
                  $_SESSION["useremail"] = $user["email"];
                  $_SESSION["fullname"] = $user["fullname"];
                  $_SESSION["phone_number"] = $user["phone_number"];
                  $_SESSION["role_id"] = $user["role_id"];
                  $user['role_id'] !== 3 ? header("Location: ../admin/admin.php") : header("Location: ../templates/trangchu.php");
                  exit();
            else :
                  // User doesn't exist, insert new user into database
                  $statement = $database->connect()->prepare('INSERT INTO `user` (`fullname`, `email`, `phone_number`, `role_id`) VALUES (?, ?, ?, ?)');
                  $statement->execute([$name, $email, $phoneNumber, 3]);

                  // Retrieve inserted user details
                  $statement = $database->connect()->prepare('SELECT * FROM `user` WHERE `email` = ?');
                  $statement->execute([$email]);
                  $result = $statement->fetch(PDO::FETCH_ASSOC);

                  // Set session variables and redirect to homepage
                  $_SESSION["id"] = $result["id"];
                  $_SESSION["useremail"] = $result["email"];
                  $_SESSION["fullname"] = $result["fullname"];
                  $_SESSION["phone_number"] = $result["phone_number"];
                  $_SESSION["role_id"] = $result["role_id"];
                  $user['role_id'] !== 3 ? header("Location: ../admin/admin.php") : header("Location: ../templates/trangchu.php");
                  exit();
            endif;
      } catch (Exception $e) {
            // Handle any errors that occur during OAuth or database operations
            echo 'Caught exception: ' . $e->getMessage();
      }
else :
      // Redirect to Google OAuth login
      $authUrl = $client->createAuthUrl();
      header("Location: $authUrl");
      exit();
endif;
