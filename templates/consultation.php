<?php
include('../scripts/config.php');
session_start();


// Ensure the user is logged in as a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Consultation</title>
    <link rel="stylesheet" href="../style/consultation.css">
</head>
<body>
    <div class="container">
        <div class="consultation-container">
            <div class="online-consultation">
                <h2>Online Consultation</h2>
                <div class="consultation-content">
                    <div class="consultation-info">
                        <p>Get expert medical advice from the comfort of your home</p>
                        <ul>
                            <li>Time Saving</li>
                            <li>Quick Response</li>
                            <li>Secure Platform</li>
                        </ul>
                    </div>
                    <div class="consultation-actions">
                        <button id="online-doctors-btn" class="consultation-btn">
                            Available Doctors
                        </button>
                    </div>
                </div>
            </div>

            <div class="offline-consultation">
                <h2>Offline Consultation</h2>
                <div class="consultation-content">
                    <div class="consultation-info">
                        <p>Schedule an in-person visit at our healthcare center</p>
                        <ul>
                            <li>Detailed Check-up</li>
                            <li>Personal Interaction</li>
                            <li>Advanced Diagnostics</li>
                        </ul>
                    </div>
                    <div class="consultation-actions">
                        <button id="offline-doctors-btn" class="consultation-btn">
                            Available Doctors
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../scripts/consultation.js"></script>
</body>
</html>
