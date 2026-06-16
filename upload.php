<?php
$uploadmap = "uploads/";

if (!file_exists($uploadmap)) {
    mkdir($uploadmap, 0777, true); // Maakt de map aan als die nog niet bestaat
}

$melding = ""; // Variabele voor fout- of succesmeldingen

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Controleert of het formulier verstuurd is
    if (isset($_FILES["bestand"]) && $_FILES["bestand"]["error"] === 0) { // Controleert of er een geldig bestand is ontvangen

        $bestandsnaam = basename($_FILES["bestand"]["name"]); // Haalt de bestandsnaam op
        $doel = $uploadmap . $bestandsnaam; // Bouwt het volledige pad op waar het bestand naartoe gaat

        if (move_uploaded_file($_FILES["bestand"]["tmp_name"], $doel)) { // Verplaatst het bestand van de tijdelijke map naar de uploadmap
            $melding = "Upload gelukt! Bestand opgeslagen als: " . htmlspecialchars($bestandsnaam);
        } else {
            $melding = "Upload mislukt bij het verplaatsen van het bestand.";
        }

    } else {
        $melding = "Geen geldig bestand ontvangen.";
    }
}




?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestand uploaden</title>
</head>
<body>
    <h1>Bestand uploaden</h1>

    <?php if ($melding): ?> <!-- Als er een melding is, wordt deze getoond -->
        <p><?php echo $melding; ?></p> 
    <?php endif; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data"> <!-- enctype is nodig voor bestandsuploads -->
        <label>Bestand kiezen:</label>
        <input type="file" name="bestand" required> <!-- Bestandskiezer, verplicht invullen -->
        <button type="submit">Uploaden</button>
    </form>

    <p><a href="files.php">Ga naar bestandenlijst</a></p>
</body>
</html>