<?php
$servername = "localhost"; 
$dbname = "mythos";
$username = "root";
$password = "";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;port=3306;charset=utf8mb4";

    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10, // prevents long hanging attempts
        PDO::ATTR_PERSISTENT => false,
    ]);

    echo "Connected successfully";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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