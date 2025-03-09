<?php
include('../scripts/config.php');
session_start();

// Ensure the doctor is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    http_response_code(403); // Forbidden
    exit();
}

$doctor_id = $_SESSION['user_id'];
$status = isset($_POST['status']) ? intval($_POST['status']) : 0;

// Update doctor status and last activity
$stmt = $conn->prepare("UPDATE doctors SET status = ?, last_activity = NOW() WHERE user_id = ?");
$stmt->bind_param("ii", $status, $doctor_id);
$stmt->execute();
?>
