<?php
include('../scripts/config.php');
session_start();

$sender_id = $_SESSION['sender_id'];
$receiver_id = $_SESSION['receiver_id'];

$sql = "SELECT sender_id, sender_role, message, timestamp FROM messages 
        WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') 
        OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') 
        ORDER BY timestamp ASC";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $class = ($row['sender_role'] == 'doctor') ? 'doctor' : 'patient';
    echo "<div class='message $class'><strong>{$row['sender_role']}:</strong> {$row['message']}</div>";
}

$conn->close();
?>
