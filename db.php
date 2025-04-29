<?php
$host = "localhost";
$user = "root"; //  DB username
$pass = "";     //  DB password
$db   = "login";

// Create connection with correct parameters
$conn = new mysqli($host, $user, $pass, $db);

// Check connection with better error handling
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\nPlease make sure:\n1. MySQL service is running in XAMPP\n2. Database 'login' exists\n3. Username and password are correct");
}

// Set charset to ensure proper encoding
$conn->set_charset("utf8mb4");

// Set timezone if needed
date_default_timezone_set('UTC');
?>
