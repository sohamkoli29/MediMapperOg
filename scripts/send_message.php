<?php
// send_message.php
include('../scripts/config.php');
session_start();

$sender_id = $_SESSION['sender_id'];
$receiver_id = $_SESSION['receiver_id'];
$sender_role = $_SESSION['sender_role'];
$message = isset($_POST['message']) ? $_POST['message'] : '';
$file_path = '';

// Handle file upload
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $upload_dir = '../uploads/';
    $file_name = time() . '_' . basename($_FILES['file']['name']);
    $file_path = $upload_dir . $file_name;
    move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
}

// Insert message or file path into the database
$sql = "INSERT INTO messages (sender_id, receiver_id, sender_role, message, file_path) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $sender_id, $receiver_id, $sender_role, $message, $file_path);

if ($stmt->execute()) {
    echo "Message sent!";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>