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
    <title>Medicine Delivery - HealthPortal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/delivery.css">
    
</head>
<body>
<header>
    <div class="container">
        <nav class="navbar">
             <!-- Hamburger Menu Icon -->
             <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <a href="indexP.php" class="logo">MediMapper</a>
           
            <!-- Navigation Menu -->
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item"><a href="consultation.php" class="nav-link">Consultation</a></li>
                <li class="nav-item"><a href="predict.php" class="nav-link">Symptom Checker</a></li>
                <li class="nav-item"><a href="report.php" class="nav-link">Report Analysis</a></li>
                <li class="nav-item active"><a href="remedies.php" class="nav-link">Home Remedies</a></li>
                <li class="nav-item "><a href="delivery.php" class="nav-link">Medicine Delivery</a></li>
            </ul>
            <div class="user-actions">
                <a href="profile.php" class="user-icon"><i class="fas fa-user-circle"></i></a>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container">
        <h1>Medicine Delivery</h1>
        <p>This feature is coming soon! Stay tuned for a seamless medicine delivery experience.</p>
        <div class="coming-soon">
            <i class="fas fa-truck"></i>
            <p>We're working hard to bring you the best service.</p>
        </div>
    </div>
</main>
<footer>
    <div class="container">
        <div class="footer-container">
            <div class="footer-col">
                <h4>HealthPortal</h4>
                <p>Your comprehensive healthcare companion for symptom checking, remedies, and medical report analysis.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="symptom_checker.php">Symptom Mapper</a></li>
                    <li><a href="remedies.php">Home Remedies</a></li>
                    <li><a href="consultations.php">Doctor Consultations</a></li>
                    <li><a href="report_analysis.php">Report Analysis</a></li>
                    <li><a href="chatbot.php">Health Chatbot</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="help.php">Help Center</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Health Street, Medical City</li>
                    <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> support@healthportal.com</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 MediMapper [Team CodeMates]. All rights reserved.
        </div>
    </div>
</footer>
<script src="../scripts/delivery.js"></script>
</body>
</html>