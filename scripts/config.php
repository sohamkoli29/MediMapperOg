<?php
$host = "192.168.60.184";
$username = "sohamkoli29";
$password = "securemedimapper";
$database = "healthcare";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>