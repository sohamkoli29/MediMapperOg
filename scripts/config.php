<?php
$host = "";
$username = "";
$password = "";
$database = "";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
define('API_KEY', 'your_api_key'); 
?>
