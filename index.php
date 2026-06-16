<?php
$servername = "database-5020707928.webspace-host.com";
$username = "dbu2762504";
$password = "MythosDB_2026!";
$dbname = "dbs15793234";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
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