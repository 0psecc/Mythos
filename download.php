<?php
// Definieer de map waar de uploads staan
$uploadmap = "uploads/";

// Controleer of er een file parameter in de URL meegegeven is
if (isset($_GET["file"])) {

    //Haalt alleen de bestandsnaam op, zonder mapstructuur
    $bestand = basename($_GET["file"]);

    // Bouw het volledige pad naar het bestand op
    $pad = $uploadmap . $bestand;

    // Controleert of het bestand bestaat.
    if (file_exists($pad)) {

        // Stuur HTTP-headers naar de browser zodat deze het bestand
        // behandelt als een download (en niet probeert te tonen)
        header("Content-Type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename=\"" . $bestand . "\""); //Bestandsnaam
        header("Content-Length: " . filesize($pad)); // Grootte van het bestand

        // Leest het bestand en stuurt de inhoud direct naar de browser
        readfile($pad);
        exit;

    } else {
        echo "Bestand bestaat niet.";
    }

} else {
    echo "Geen bestand opgegeven.";
}
?>