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
  <title>AI Mental Health Expert Chat</title>
<link rel="stylesheet" href="../style/Experts.css">
</head>
<body style="background-image: url('../asset/MentalHealthExpertBg.jpg');">
  <!-- Header -->
  <div class="chat-header">
    <div class="header-left">
      <div class="doctor-profile">
        <div class="doctor-avatar">
          <img src="../asset/aiMentalExpert.jpg" alt="AI Medical Expert">
        </div>
        <div class="doctor-info">
          <h3>AI Mental Health Expert</h3>
          <p>Online</p>
        </div>
      </div>
    </div>
    <div class="header-right">
      <button onclick="clearChat()">&#8635;</button>
      <button onclick="window.location.href='indexP.php'">&#10005;</button>
    </div>
  </div>

  <!-- Chat Container -->
  <div class="chat-container" id="chatContainer">
    <div class="welcome-message">
      <h3>AI Mental Health Expert</h3>
      <p>Hello! I'm your AI Mental Health Expert assistant. How can I help you today?</p>
      
    </div>
  </div>

  <!-- Footer (Message Input) -->
  <div class="chat-footer">
    <input type="text" class="message-input" id="messageInput" placeholder="Type a message..." onkeypress="if(event.key === 'Enter') sendMessage()">
    <button class="send-btn" onclick="sendMessage()">
      &#10148;
    </button>
  </div>

  <!-- Bottom Navigation -->
  <div class="bottom-nav">
    <a href="MedicalExpert.php" class="nav-item ">
      <i>🩺</i>
      <span>Medical</span>
    </a>
    <a href="AyurvedicExpert.php" class="nav-item ">
      <i>🌿</i>
      <span>Ayurvedic</span>
    </a>
    <a href="NutritionistExpert.php" class="nav-item">
      <i>🥗</i>
      <span>Nutrition</span>
    </a>
    <a href="MentalExpert.php" class="nav-item active">
      <i>🧠</i>
      <span>Mental Health</span>
    </a>
  </div>

  <script src="../scripts/MentalExpert.js"></script>
</body>
</html>
