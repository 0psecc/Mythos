<?php
$logbestand = "logs/logboek.txt";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Logboek</title>
</head>
<body>
    <h1>Logboek</h1>
    <pre><?php
        if (file_exists($logbestand)) {
            echo htmlspecialchars(file_get_contents($logbestand)); // Toont de inhoud veilig, voorkomt XSS
        } else {
            echo "Nog geen logs aanwezig.";
        }
    ?></pre>
</body>
</html>