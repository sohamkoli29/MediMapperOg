<?php
$host = "10.111.10.158";
$username = "sohamkoli29";
$password = "securemedimapper";
$database = "healthcare";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
define('API_KEY', 'AIzaSyCnPJK3HSIYTx1ldNm88_DIeyQbLKFB4yk'); 
?>
