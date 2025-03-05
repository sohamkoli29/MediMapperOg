<?php
include('../scripts/config.php');
session_start();

if (isset($_GET['doctor_id'])) {
    $_SESSION['receiver_id'] = $_GET['doctor_id'];
    $_SESSION['receiver_role'] = 'doctor';
} elseif (isset($_GET['patient_id'])) {
    $_SESSION['receiver_id'] = $_GET['patient_id'];
    $_SESSION['receiver_role'] = 'patient';
}

$_SESSION['sender_id'] = $_SESSION['user_id'];
$_SESSION['sender_role'] = $_SESSION['role'];
$receiver_id = $_SESSION['receiver_id'];
$receiver_role = $_SESSION['receiver_role'];
$sender_id = $_SESSION['sender_id'];

if ($sender_id == $receiver_id) {
    die("You can't chat with yourself.");
}

// Fetch receiver name for display
$receiver_name_query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($receiver_name_query);
$stmt->bind_param("i", $receiver_id);
$stmt->execute();
$result = $stmt->get_result();
$receiver_name = $result->fetch_assoc()['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/chat.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat with <?php echo htmlspecialchars($receiver_name); ?></h2>
        </div>
        
        <div class="chat-box" id="chatBox"></div>
        
        <div class="message-input-container">
            <textarea id="messageInput" rows="2" placeholder="Type your message..."></textarea>
            <button onclick="sendMessage()" class="send-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function loadMessages() {
            $.ajax({
                url: '../scripts/fetch_messages.php',
                type: 'GET',
                data: { 
                    sender_id: <?php echo $sender_id; ?>, 
                    receiver_id: <?php echo $receiver_id; ?> 
                },
                success: function(response) {
                    $('#chatBox').html(response);
                    // Auto-scroll to the bottom of the chat
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                }
            });
        }

        function sendMessage() {
            let message = $('#messageInput').val();
            if (message.trim() !== '') {
                $.ajax({
                    url: '../scripts/send_message.php',
                    type: 'POST',
                    data: { 
                        message: message, 
                        sender_id: <?php echo $sender_id; ?>, 
                        receiver_id: <?php echo $receiver_id; ?> 
                    },
                    success: function(response) {
                        $('#messageInput').val('');
                        loadMessages();
                    }
                });
            }
        }

        // Load messages every 2 seconds
        setInterval(loadMessages, 2000);
        
        // Initial message load
        loadMessages();

        // Allow sending message with Enter key
        $('#messageInput').keypress(function(e) {
            if (e.which == 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    </script>
</body>
</html>