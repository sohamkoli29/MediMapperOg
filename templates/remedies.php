
<?php
include('../scripts/config.php');
session_start();


// Ensure the user is logged in as a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Remedies Generator</title>

    <link rel="stylesheet" href="../style/remedies.css">
</head>
<body>
    <div class="container">
        <h1>Home Remedies Generator</h1>
        <p>Enter your Disease to find Home Remedies:</p>
        <input type="text" id="DiseaseInput" placeholder="Type a symptom..." autocomplete="off" />
        <ul id="suggestions"></ul>
        <button id="predictButton">Give Remedies</button>
        <button id="resetButton">Reset</button>


  <div id="results">Selected Disease: None</div>
        
    </div>
    <script src="../scripts/diseases.js"></script>
    <script src="../scripts/remedies.js"></script>
</body>
</html>
