<?php
include('../scripts/config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$doctor = null;
$doctor_id = isset($_GET['doctor_id']) ? (int) $_GET['doctor_id'] : 0;

// Fetch doctor details
if ($doctor_id > 0) {
    $doctor_query = "SELECT u.name, u.profile_picture, d.specialization, d.qualification, d.experience, d.availability 
                     FROM users u 
                     JOIN doctors d ON u.id = d.user_id
                     WHERE u.id = ?";
    $stmt = $conn->prepare($doctor_query);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $doctor_result = $stmt->get_result();
    
    if ($doctor_result->num_rows > 0) {
        $doctor = $doctor_result->fetch_assoc();
    } else {
        echo "<p style='color:red;'>Doctor not found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="../style/onlineDoctors.css">
</head>
<body>
    <div class="profile-container">
        <h1>Doctor Profile</h1>

        <?php if ($doctor): // Check if doctor data is available ?>
            <div class="profile-card">
                <img src="<?php echo !empty($doctor['profile_picture']) ? $doctor['profile_picture'] : 'path/to/default_image.jpg'; ?>" alt="Doctor Picture" class="profile-image">
                <div class="profile-details">
                    <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
                    <div class="doctor-info">
                        <div class="info-item">
                            <span class="info-label">Specialization:</span>
                            <span class="info-value"><?php echo htmlspecialchars($doctor['specialization']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Qualification:</span>
                            <span class="info-value"><?php echo htmlspecialchars($doctor['qualification']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Experience:</span>
                            <span class="info-value"><?php echo htmlspecialchars($doctor['experience']); ?> years</span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="chat.php?doctor_id=<?php echo $doctor_id; ?>" class="chat-btn">Chat with Doctor</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p style="color:red;">Doctor details not available.</p>
        <?php endif; ?>
    </div>
</body>
</html>