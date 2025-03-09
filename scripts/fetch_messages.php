<?php
// fetch_messages.php
include('../scripts/config.php');
session_start();

$sender_id = $_SESSION['sender_id'];
$receiver_id = $_SESSION['receiver_id'];

$sql = "SELECT sender_id, sender_role, message, file_path, timestamp FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) 
        OR (sender_id = ? AND receiver_id = ?) 
        ORDER BY timestamp ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $class = ($row['sender_role'] == 'doctor') ? 'doctor' : 'patient';
    echo "<div class='message-$class'><strong>{$row['sender_role']}:</strong> ";

    if (!empty($row['message'])) {
        echo htmlspecialchars($row['message']);
    }

    if (!empty($row['file_path'])) {
        $file_url = htmlspecialchars($row['file_path']);
        $file_ext = strtolower(pathinfo($file_url, PATHINFO_EXTENSION));

        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<div class='file-preview blurred' onclick='downloadFile(this, \"$file_url\")'>
                    <img src='$file_url' alt='Image' class='blurred-image'>
                  </div>";
        } elseif (in_array($file_ext, ['mp4', 'webm', 'ogg'])) {
            echo "<div class='file-preview blurred' onclick='downloadFile(this, \"$file_url\")'>
                    <video src='$file_url' class='blurred-video'></video>
                  </div>";
        } else {
            echo "<a href='$file_url' download>Download File</a>";
        }
    }

    echo "</div>";
}

$stmt->close();
$conn->close();
?>

<script>
// Reveal the blurred content after clicking
function downloadFile(element, fileUrl) {
    window.location.href = fileUrl;
    element.classList.remove('blurred');
}
</script>

<style>
/* Blur effect */
.blurred {
   
    cursor: pointer;
}

.blurred:hover {
    
}

.blurred img, .blurred video {
    width: 150px;
    height: auto;
}

.message {
    max-width: 70%;
    margin: 5px;
    padding: 10px;
    border-radius: 8px;
    line-height: 1.5;
}

/* Patient message (left side) */
.message-patient {
    align-self: flex-start; /* Align left */
    background-color: var(--white);
    border: 1px solid var(--mid-gray);
    border-bottom-left-radius: 4px;
    margin-left: auto; 
    padding: 10px;
    border-radius:20px ;
}

/* Doctor message (right side) */
.message-doctor {
    align-self: flex-end; /* Align right */
    background-color: var(--primary-blue);
    color: var(--white);
    border-bottom-right-radius: 4px;
    margin-right: auto;
    padding: 10px;
    border-radius:20px ;
}
</style>