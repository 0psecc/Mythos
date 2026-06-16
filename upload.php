<?php
$uploadmap = "uploads/";

// Map aanmaken als die nog niet bestaat
if (!file_exists($uploadmap)) {
    mkdir($uploadmap, 0777, true);
}

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["bestand"]) && $_FILES["bestand"]["error"] === 0) {

        $bestandsnaam = basename($_FILES["bestand"]["name"]);
        $doel = $uploadmap . $bestandsnaam;

        if (move_uploaded_file($_FILES["bestand"]["tmp_name"], $doel)) {
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

    <?php if ($melding): ?>
        <p><?php echo $melding; ?></p>
    <?php endif; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Bestand kiezen:</label>
        <input type="file" name="bestand" required>
        <button type="submit">Uploaden</button>
    </form>

    <p><a href="files.php">Ga naar bestandenlijst</a></p>
</body>
</html>
