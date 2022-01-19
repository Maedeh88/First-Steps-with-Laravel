<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, "USERS");

$table = "CREATE TABLE IF NOT EXISTS PERSONAL_INFORMATION (
    username VARCHAR (30) NOt NULL PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL ,
    email VARCHAR (30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    age VARCHAR (4) NOT NULL 
)";
if ($conn->query($table) == TRUE) {
    echo "table is created";
} else {
    echo "ERROR";
}
$conn->close();

