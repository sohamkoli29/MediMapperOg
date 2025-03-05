<?php 
include('../scripts/config.php'); 
session_start();  

// Ensure the user is logged in as a patient 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {     
    header("Location: login.php");     
    exit(); 
}  

// Fetch all doctors (Make sure we use d.user_id)
$doctors_query = "SELECT d.user_id, u.name, u.profile_picture, d.specialization, d.qualification                    
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
</head> 
<body>     
    <div class="dashboard">         
        <h1>Online Consultation</h1>         
        <h2>Available Doctors</h2>         
        <div class="doctor-list">             
            <?php while ($doctor = $doctors_result->fetch_assoc()) { ?>                 
                <div class="doctor-card">                 
                    <img src="<?php echo './' . $doctor['profile_picture']; ?>" alt="Doctor Picture">                     
                    <h3><?php echo $doctor['name']; ?></h3>                     
                    <p>Specialization: <?php echo $doctor['specialization']; ?></p>                     
                    <p>Qualification: <?php echo $doctor['qualification']; ?></p>
                    <div class="doctor-actions">
                        <button class="visit-doctor-btn" data-doctor-id="<?php echo $doctor['user_id']; ?>">
                            Schedule Consultation
                        </button>
                    </div>
                </div>             
            <?php } ?>         
        </div>     
    </div>  

    <script src="../scripts/online_consultation.js"></script>
</body> 
</html>
