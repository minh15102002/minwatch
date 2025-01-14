<?php

require_once 'vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// init configuration
$clientID = '188751309579-kelns8d85ill98dsjdo85o7c1a6tnhv5.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/Website_BanDongHo/inc/google-login.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_min_watch";

$conn = mysqli_connect($hostname, $username, $password, $database);
