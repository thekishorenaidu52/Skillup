<?php
$host = 'localhost';
$db = 'skillup_db';
$user = 'root'; // change this if needed
$pass = '';     // change this if needed

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
?>
