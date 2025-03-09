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

// Fetch receiver name
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
    <title>Chat with <?php echo htmlspecialchars($receiver_name); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../style/chat.css">
   
</head>

<body>

<div class="chat-container">
    <div class="chat-header">
        <h2>Chat with <?php echo htmlspecialchars($receiver_name); ?></h2>
    </div>

    <div class="chat-box" id="chatBox"></div>

    <!-- Drag & Drop Area -->
    <div id="dropArea" class="drop-area">
        Drag and drop files here or
        <input type="file" id="fileInput" accept="image/*,application/pdf,video/*" style="display: none;">
        <button type="button" onclick="$('#fileInput').click();">Choose File</button>
        <button type="button" onclick="removeFile()">Discard</button> 
        <div id="filePreview" class="file-preview"></div>
    </div>

    <div class="message-input-container">
        <textarea id="messageInput" rows="2" placeholder="Type your message..."></textarea>
        <button onclick="sendMessage()" class="send-btn">
                    Send
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<script>
    // Trigger file input click on button press
$('#fileInput').on('change', function() {
    const file = this.files[0];
        if (file) {
                $('#filePreview').html(`<p>File: ${file.name}</p>`);
            } else {
                $('#filePreview').html('');
            }
        });

    
        function loadMessages() {
    $.ajax({
        url: '../scripts/fetch_messages.php',
        type: 'GET',
        cache: false, // Prevent caching issues
        success: function (response) {
            $('#chatBox').html(response); // Update chat messages
          
        },
        error: function (xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
}


    function sendMessage() {
        let message = $('#messageInput').val();
        let file = $('#fileInput')[0].files[0];
            
        if (message.trim() !== '' || file) {
            let formData = new FormData();
            formData.append('message', message);
            formData.append('sender_id', <?php echo $sender_id; ?>);
            formData.append('receiver_id', <?php echo $receiver_id; ?>);
            if (file) formData.append('file', file);

            $.ajax({
                url: '../scripts/send_message.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#messageInput').val('');
                    $('#fileInput').val('');
                    $('#filePreview').html('');
                    loadMessages();
                }
            });
        }
    }

    // Drag and drop file upload
    const dropArea = document.getElementById('dropArea');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('drag-over');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('drag-over');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('drag-over');

        const file = e.dataTransfer.files[0];
        $('#fileInput')[0].files = e.dataTransfer.files;

        if (file) {
            $('#filePreview').html(`<p>File: ${file.name}</p>`);
        }
    });

    setInterval(loadMessages, 2000);
    loadMessages();

    $('#messageInput').keypress(function (e) {
        if (e.which == 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function removeFile() {
        $('#fileInput').val('');        // Reset the file input
        $('#filePreview').html('');
    }
</script>

</body>
</html>
