<?php
include('../scripts/config.php');
session_start();

$sender_id = $_SESSION['sender_id'];
$receiver_id = $_SESSION['receiver_id'];
$sender_role = $_SESSION['sender_role'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, sender_role, message) 
        VALUES ('$sender_id', '$receiver_id', '$sender_role', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Message sent!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
