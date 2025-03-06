<?php
$host = "192.168.9.176";
$username = "sohamkoli29";
$password = "securemedimapper";
$database = "healthcare";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('API_KEY', 'AIzaSyDKRCRzNDQ8Z0Nf8HhETR3Ah7J2PfACUHk');
?>