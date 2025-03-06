<?php
include('../scripts/config.php');
session_start();

// Ensure the user is logged in as a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: chat.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];  // Logged-in doctor ID

// Fetch list of patients the doctor has interacted with
$sql = "SELECT DISTINCT users.id, users.name 
        FROM users 
        INNER JOIN messages 
        ON (users.id = messages.sender_id OR users.id = messages.receiver_id)
        WHERE (messages.sender_id = '$doctor_id' OR messages.receiver_id = '$doctor_id') 
        AND users.role = 'patient'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    <link rel="stylesheet" href="../style/patient_list.css">
</head>
<body>

<div class="container">
    <h2>Your Patients</h2>
    
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td><a class='chat-btn' href='chat.php?patient_id={$row['id']}'>Chat</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No patients found.</td></tr>";
        }
        ?>
    </table>
    <a href="doctor_dashboard.php" class="back-button">Back to Dashboard</a>
</div>

</body>
</html>
