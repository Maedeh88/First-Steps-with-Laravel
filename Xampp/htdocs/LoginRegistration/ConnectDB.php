<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

// Create DB for users
$sql = "CREATE DATABASE IF NOT EXISTS USERS";
if ($conn->query($sql) == TRUE) {
    echo "Database created succesfully\n";
} else {
    echo "We have an ERROR" . $conn->error;
}

$conn->close();
//echo "\n" . $_SERVER['SERVER_PORT'];
?>
