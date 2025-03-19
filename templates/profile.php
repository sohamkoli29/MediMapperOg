<?php
include('../scripts/config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile_picture'])) {
    if (!empty($_POST['cropped_image'])) {
        $upload_dir = '../uploads';
        $file_name = 'profile_' . $user_id . '_' . time() . '.png'; // Unique file name
        $file_path = $upload_dir . $file_name;

        // Save the cropped image
        $cropped_image = $_POST['cropped_image'];
        $cropped_image = str_replace('data:image/png;base64,', '', $cropped_image);
        $cropped_image = str_replace(' ', '+', $cropped_image);
        $image_data = base64_decode($cropped_image);

        if (file_put_contents($file_path, $image_data)) {
            // Update profile picture in the database
            $update_query = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $file_path, $user_id);

            if ($update_stmt->execute()) {
                $_SESSION['success_message'] = "Profile picture updated successfully!";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to update profile picture. Please try again.";
            }
        } else {
            $_SESSION['error_message'] = "Failed to save the cropped image. Please try again.";
        }
    } else {
        $_SESSION['error_message'] = "No image selected for upload.";
    }
}

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update user data in the database
    $update_query = "UPDATE users SET name = ?, email = ?, phone_number = ?, address = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $email, $phone_number, $address, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to update profile. Please try again.";
    }
}

// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in the database
            $update_password_query = "UPDATE users SET password = ? WHERE id = ?";
            $update_password_stmt = $conn->prepare($update_password_query);
            $update_password_stmt->bind_param("si", $hashed_password, $user_id);

            if ($update_password_stmt->execute()) {
                $_SESSION['success_message'] = "Password changed successfully!";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to change password. Please try again.";
            }
        } else {
            $_SESSION['error_message'] = "New passwords do not match.";
        }
    } else {
        $_SESSION['error_message'] = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - HealthPortal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>
<header>
    <div class="container">
        <nav class="navbar">
            <a href="indexP.php" class="logo">MediMapper</a>
            <ul class="nav-menu">
            <li class="nav-item "><a href="consultation.php" class="nav-link">Consultation</a></li>
                <li class="nav-item"><a href="predict.php" class="nav-link">Symptom Checker</a></li>
                <li class="nav-item"><a href="report.php" class="nav-link">Report Analysis</a></li>
                <li class="nav-item"><a href="remedies.php" class="nav-link">Home Remedies</a></li>
                <li class="nav-item"><a href="delivery.php" class="nav-link">Medicine Delivery</a></li>
            </ul>
            <div class="user-actions">
                <a href="profile.php" class="user-icon"><i class="fas fa-user-circle"></i></a>
                <a href="#" onclick="confirmLogout()" class="user-icon"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Profile Picture Section -->
        <div class="profile-picture-section">
            <div class="profile-picture-container">
                <img src="<?= $user['profile_picture'] ? $user['profile_picture'] : '../uploads/profile_pictures/default.png'; ?>" alt="Profile Picture" class="profile-picture" id="profilePicture">
                <label for="profile_picture" class="change-profile-picture">
                    <i class="fas fa-camera"></i>
                </label>
            </div>
            <form action="profile.php" method="POST" enctype="multipart/form-data" class="profile-picture-form">
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;" onchange="loadImage(event)">
                <input type="hidden" id="cropped_image" name="cropped_image">
                <button type="submit" name="update_profile_picture" class="submit-button">Update Profile Picture</button>
            </form>
        </div>

        <!-- Image Cropper Modal -->
        <div id="cropperModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="cropper-container">
                    <img id="imageToCrop" src="#" alt="Image to Crop">
                </div>
                <button id="cropButton" class="submit-button">Crop Image</button>
            </div>
        </div>

        <!-- Profile Update Form -->
        <form action="profile.php" method="POST" class="profile-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']); ?>">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address']); ?>">
            </div>
            <button type="submit" name="update_profile" class="submit-button">Update Profile</button>
        </form>

        <!-- Change Password Form -->
        <h2>Change Password</h2>
        <form action="profile.php" method="POST" class="password-form">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="submit-button">Change Password</button>
        </form>
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

<!-- Cropper.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    // Function to load the selected image into the cropper modal
    function loadImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageToCrop = document.getElementById('imageToCrop');
                imageToCrop.src = e.target.result;

                // Open the cropper modal
                const modal = document.getElementById('cropperModal');
                modal.style.display = "block";

                // Initialize Cropper.js
                const cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1, // 1:1 ratio
                    viewMode: 1,
                    autoCropArea: 1,
                });

                // Handle crop button click
                document.getElementById('cropButton').onclick = function() {
                    const croppedCanvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 300,
                    });

                    // Convert cropped image to base64
                    const croppedImage = croppedCanvas.toDataURL('image/png');
                    document.getElementById('cropped_image').value = croppedImage;

                    // Update the profile picture preview
                    document.getElementById('profilePicture').src = croppedImage;

                    // Close the modal
                    modal.style.display = "none";
                };

                // Close the modal when the close button is clicked
                document.querySelector('.close').onclick = function() {
                    modal.style.display = "none";
                };
            };
            reader.readAsDataURL(file);
        }
    }
    
</script>
<script>
    function confirmLogout() {
    const confirmLogout = confirm("Are you sure you want to logout?");
    if (confirmLogout) {
        // Redirect to logout.php with confirmation
        window.location.href = "logout.php?confirm=true";
    } else {
        // Stay on the current page
        return false;
    }
}
</script>
</body>
</html>