<?php
// This script should be run via cron job every 5-10 minutes
include('config.php');

// Remove session entries older than 10 minutes
$cleanup_query = "DELETE FROM active_sessions WHERE last_activity < DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
$conn->query($cleanup_query);

// Close connection
$conn->close();
?>
