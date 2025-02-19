<?php
$servername = '198.187.31.103';
$username = 'melemegc_melek_global_education';
$password = 'melemegc_KwameGilbert';
$dbname = 'melemegc_melek_global_education';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>