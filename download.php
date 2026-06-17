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
        $sleutel = "jouw_geheime_sleutel_32tekens!!"; // Zelfde sleutel als bij upload
$inhoud = file_get_contents($pad); // Leest het versleutelde bestand
[$ivBase64, $versleuteld] = explode("::", $inhoud, 2); // Splits IV en versleutelde inhoud
$iv = base64_decode($ivBase64); // Decodeer de IV
echo openssl_decrypt($versleuteld, "AES-256-CBC", $sleutel, 0, $iv); // Ontsleutelt en stuurt naar browser
exit;
        readfile($pad);
        exit;

    } else {
        echo "Bestand bestaat niet.";
    }

} else {
    echo "Geen bestand opgegeven.";
}
?>