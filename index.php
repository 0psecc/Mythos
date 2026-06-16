<?php
$servername = "localhost";
$username = "username";
$password = "";
$dbname = "mythos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mythos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
</body>
</html>