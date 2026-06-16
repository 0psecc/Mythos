<?php
$uploadmap = "uploads/"; // Map waar bestanden worden opgeslagen

if (!file_exists($uploadmap)) { // Als de map nog niet bestaat wordt hij aangemaakt
    mkdir($uploadmap, 0777, true);
}

$bestanden = scandir($uploadmap); // Leest alle bestanden in de map in een array
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Beschikbare bestanden</title>
</head>
<body>
    <h1>Beschikbare bestanden</h1>

    <?php
    $heeftBestanden = false;
    foreach ($bestanden as $bestand) {
        if ($bestand !== "." && $bestand !== "..") { // Zorgt dat . en .. overgeslagen worden
            $heeftBestanden = true;
            $urlBestand = urlencode($bestand); // Maakt de bestandsnaam veilig voor in een URL
            echo "<p><a href=\"download.php?file=$urlBestand\">$bestand downloaden</a></p>"; // Toont een downloadlink per bestand
        }
    }

    if (!$heeftBestanden) { // Als er geen bestanden zijn wordt melding getoond
        echo "<p>Er zijn nog geen bestanden geüpload.</p>"; 
    }
    ?>

    <p><a href="upload.php">Terug naar uploaden</a></p>
</body>
</html>