<?php
session_start();

// Check if the user confirmed the logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
} else {
    // If not confirmed, redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>