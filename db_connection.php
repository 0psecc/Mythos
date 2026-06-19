<?php

$servername = "database-5020707928.webspace-host.com"; 
$dbname = "dbs15793234";
$username = "dbu2762504";
$password = "MythosDB_2026!";


$conn = new mysqli($servername, $username, $password, $dbname);
// creates a new connection to the MySQL database using the details above


if ($conn->connect_error) {
    // checks if there was an error while trying to connect

    die("Connection failed: " . $conn->connect_error);
    // stops the script and shows an error message if connection failed
}


$conn->set_charset("utf8mb4");
// sets the character encoding to utf8mb4 so it supports all characters including emojis and special symbols

?>