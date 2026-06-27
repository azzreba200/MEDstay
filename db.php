<?php
// Database connection — auto-selects LOCAL (XAMPP) vs LIVE (Hostinger).
// Same file works in both places; nothing needs to change on deploy.

$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocal  = php_sapi_name() === 'cli'
         || strpos($httpHost, 'localhost') !== false
         || strpos($httpHost, '127.0.0.1') !== false;

if ($isLocal) {
    // ---- Local XAMPP ----
    $host     = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'medstay';
} else {
    // ---- Live (Hostinger) ----
    $host     = '127.0.0.1';
    $username = 'u119737814_Admain_zero';
    $password = 'ZERO4224Zero';
    $database = 'u119737814_medstay';
}

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset for special characters (é, ñ, etc.)
$conn->set_charset("utf8mb4");
?>
