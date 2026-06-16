<?php
$uploadmap = "uploads/";

if (!file_exists($uploadmap)) {
    mkdir($uploadmap, 0777, true);
}

$bestanden = scandir($uploadmap);
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
        if ($bestand !== "." && $bestand !== "..") {
            $heeftBestanden = true;
            $urlBestand = urlencode($bestand);
            echo "<p><a href=\"download.php?file=$urlBestand\">$bestand downloaden</a></p>";
        }
    }

    if (!$heeftBestanden) {
        echo "<p>Er zijn nog geen bestanden geüpload.</p>";
    }
    ?>

    <p><a href="upload.php">Terug naar uploaden</a></p>
</body>
</html>
