<?php
// db.php
 
$db_host = 'localhost';
$db_user = 'ur9iyguafpilu';
$db_pass = '51gssrtsv3ei';
$db_name = 'dbnemtkdfx0ocu';
 
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
 
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
 
// Set charset to utf8mb4 for better character support
$conn->set_charset("utf8mb4");
?>
 
