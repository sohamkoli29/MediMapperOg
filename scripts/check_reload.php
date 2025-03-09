<?php
// check_reload.php
include('../scripts/config.php');
session_start();

$user_id = $_SESSION['user_id'];

// Check if the user's page should reload
$query = "SELECT reload_flag FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['reload_flag'] == 1) {
    // Reset reload flag after detection
    $reset_query = "UPDATE users SET reload_flag = 0 WHERE id = ?";
    $reset_stmt = $conn->prepare($reset_query);
    $reset_stmt->bind_param("i", $user_id);
    $reset_stmt->execute();
    
    echo "reload"; // Signal the client to reload the page
}

$stmt->close();
$conn->close();
?>
