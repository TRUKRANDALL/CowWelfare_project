<?php
// db.php
$host   = 'localhost';
$dbName = 'cow_welfare';    // make sure you created this database
$dbUser = 'root';
$dbPass = '';               // empty by default in XAMPP

$mysqli = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>