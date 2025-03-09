<?php
include('../scripts/config.php');
session_start(); // Ensure the session starts once at the top

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo "<script>alert('Username and password are required!');</script>";
        exit();
    }

    // Fetch user by username and role
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // If the user is a doctor, update their online status
            if ($role === 'doctor') {
                $update_status = $conn->prepare("UPDATE doctors SET status = 1 WHERE user_id = ?");
                $update_status->bind_param("i", $user['id']);
                $update_status->execute();
            }

            // Redirect based on role
            if ($role === 'patient') {
                header("Location: indexP.php");
            } else {
                header("Location: doctor_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('User not found or role mismatch!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style/login.css">
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Login As:</label>
            <select id="role" name="role">
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
            </select>

            <a href="forgot_password.php">Forgot Password?</a>

            <button type="submit" name="login">Login</button>
            <div>Not having an account? <a href="./register.php">Create Account</a></div>
        </form>
    </div>
</body>

</html>
