<?php
// status.php
$is_online = checkUserStatus(); // Replace with your logic
echo '<span class="status-dot ' . ($is_online ? 'online' : 'offline') . '"></span>';

// Example status-checking function
function checkUserStatus() {
    // Simulate user status (1 for online, 0 for offline)
    return rand(0, 1); 
}
?>