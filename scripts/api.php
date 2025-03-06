<?php
include('config.php');

// Return API key as JSON
header('Content-Type: application/json');
echo json_encode(['apiKey' => API_KEY]);
