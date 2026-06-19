<?php


if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') { // Controleert of HTTPS aanwezig is voor het beveiligd uploaden van bestanden
    die("HTTPS is vereist.");
}

$uploadmap = "uploads/";

if (!file_exists($uploadmap)) {
    mkdir($uploadmap, 0777, true); // Maakt de map aan als die nog niet bestaat
}

$melding = ""; // Variabele voor fout- of succesmeldingen

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Controleert of het formulier verstuurd is
    if (isset($_FILES["bestand"]) && $_FILES["bestand"]["error"] === 0) { // Controleert of er een geldig bestand is ontvangen

        $bestandsnaam = basename($_FILES["bestand"]["name"]); // Haalt de bestandsnaam op
        $doel = $uploadmap . $bestandsnaam; // Bouwt het volledige pad op waar het bestand naartoe gaat
        $maxgrootte = 10 * 1024 * 1024; // 10MB -- 1014 aangepast naar 1024 (Typ fout)
        if ($_FILES["bestand"]["size"] > $maxgrootte) {
            $melding = "Bestand is groter dan 10 MB."; // Checkt nu wel of het bestand niet groter is dan 10 MB
        } else {

            /*
            Oude methode zonder encryptie. Het bestand werd direct opgeslagen in de uploadmap en kon daardoor gewoon gelezen worden op de server.
            if (move_uploaded_file($_FILES["bestand"]["tmp_name"], $doel)) {
                $melding = "Upload gelukt! Bestand opgeslagen als: " . htmlspecialchars($bestandsnaam);
            } else {
                $melding = "Upload mislukt bij het verplaatsen van het bestand.";
            }
            */

            // Nieuwe methode met AES-256 encryptie
            $data = file_get_contents($_FILES["bestand"]["tmp_name"]); // Leest de inhoud van het geüploade bestand
            $key = hash('sha256', 'MythosEcnryptieSleutel', true); // Maakt een sleutel voor de encryptie
            $iv = random_bytes(16); // Maakt een willekeurige code aan die nodig is voor de encryptie

            // Versleutelt de inhoud van het bestand met AES-256
            $encryptedData = openssl_encrypt(
                $data,
                'AES-256-CBC',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            ); 

            // Slaat het versleutlde bestand op in de uploadmap
            if (file_put_contents($doel . ".enc", $iv . $encryptedData)) {
                $melding = "Upload gelukt! Bestand versleuteld opgeslagen.";
            } else {
                $melding = "Encryptie of oplsag mislukt.";
            }
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