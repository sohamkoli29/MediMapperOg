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
  <title>Symptom Mapper</title>
  <link rel="stylesheet" href="../style/predict.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<header>
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">MediMapper</a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="indexP.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item active"><a href="predict.php" class="nav-link">Symptom Checker</a></li>
                    <li class="nav-item"><a href="report.php" class="nav-link">Report Analysis</a></li>
                    <li class="nav-item"><a href="remedies.php" class="nav-link">Home Remedies</a></li>
                </ul>
                <div class="user-actions">
                    <a href="profile.php" class="user-icon"><i class="fas fa-user-circle"></i></a>
                    <a href="logout.php" class="user-icon"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </nav>
        </div>
    </header>
<main>
  <h1>Symptom Checker</h1>
  <p>Type symptoms below and get predictions for possible diseases:</p>
  
  <input type="text" id="symptomInput" placeholder="Type a symptom..." autocomplete="off" />
  <ul id="suggestions"></ul>
  <button id="predictButton">Predict Disease</button>
  <button id="resetButton">Reset</button>


  <div id="results">Selected Symptoms: None</div>
</main> 
  <script src="../scripts/symtoms.js"></script>
  <script src="../scripts/predict.js"></script>
</body>
</html>
