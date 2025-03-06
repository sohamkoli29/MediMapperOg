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
  

</head>
<body>
  
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
