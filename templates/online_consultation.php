<?php 
include('../scripts/config.php'); 
session_start();  

// Ensure the user is logged in as a patient 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {     
    header("Location: login.php");     
    exit(); 
}  

// Fetch all doctors (including status)
$doctors_query = "SELECT d.user_id, u.name, u.profile_picture, d.specialization, d.qualification,
                  (NOW() - d.last_activity <= 30) AS status
                  FROM users u
                  JOIN doctors d ON u.id = d.user_id";
$doctors_result = $conn->query($doctors_query); 

?>  

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Online Consultation</title>     
    <link rel="stylesheet" href="../style/online_consultation.css"> 
    <style>
        .status-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 10px 0;
            }

        .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
        }

        .status-dot.online {
        background-color: #28a745; /* Green for online */
        }

        .status-dot.offline {
        background-color: #dc3545; /* Red for offline */
        }

        .status-indicator span {
        font-size: 0.9em;
        color: #666;
        }
    </style>
</head> 
<body>   
    <main>  
<div class="dashboard">         
    <h1>Online Consultation</h1>         
    <h2>Available Doctors</h2>         
    <div class="doctor-list">
    <?php while ($doctor = $doctors_result->fetch_assoc()) { 
        $is_online = $doctor['status'] == 1; 
        $status_text = $is_online ? 'Online' : 'Offline';
    ?>
    <div class="doctor-card">
        <img src="<?php echo !empty($doctor['profile_picture']) ? './' . htmlspecialchars($doctor['profile_picture']) : '../images/default-avatar.png'; ?>" alt="Doctor Picture">
        <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
        <div class="status-indicator">
            <span class="status-dot <?php echo $is_online ? 'online' : 'offline'; ?>"></span>
            <span><?php echo $status_text; ?></span>
        </div>
        <p>Specialization: <?php echo htmlspecialchars($doctor['specialization']); ?></p>
        <p>Qualification: <?php echo htmlspecialchars($doctor['qualification']); ?></p>
        <button class="visit-doctor-btn" data-doctor-id="<?php echo $doctor['user_id']; ?>">
                            Schedule Consultation
                        </button>
    </div>

    <?php } ?>
    
</div>                         
</div> 


<script src="../scripts/online_consultation.js"></script>

</body> 
</html>
