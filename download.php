<?php
// Definieer de map waar de uploads staan
$uploadmap = "uploads/";

// Controleer of er een file parameter in de URL meegegeven is
if (isset($_GET["file"])) {

    //Haalt alleen de bestandsnaam op, zonder mapstructuur
    $bestand = basename($_GET["file"]);

    // Bouw het volledige pad naar het bestand op
    $pad = $uploadmap . $bestand;
    logActie("DOWNLOAD", $bestand); // Logt de download.
    // Controleert of het bestand bestaat.
    if (file_exists($pad)) {
    require "logger.php"; // Zorgt dat de  logger werkt.
        // Stuur HTTP-headers naar de browser zodat deze het bestand
        // behandelt als een download (en niet probeert te tonen)
        header("Content-Type: application/octet-stream"); 
        // header("Content-Disposition: attachment; filename=\"" . $bestand . "\""); //Bestandsnaam
        header("Content-Length: " . filesize($pad)); // Grootte van het bestand

        // Verbeterde en nettere methode
        $downloadNaam = str_replace(".enc", "", $bestand); // Laat de originele bestandsnaam zien
        header("Content-Disposition: attachment; filename=\"" . $downloadNaam . "\"");

        /*
        Oude methode zonder encryptie. Het bestand werd direct naar de browser gestuurd. Dit werkte alleen zolang bestanden niet versleuteld werden opgeslagen.
        readfile($pad);
        exit;
        */

        // Leest het versleutelde bestand uit de uploadmap
        $content = file_get_contents($pad);

        // Haalt de willekeurige code (IV) uit het begin van het bestand
        $iv = substr($content, 0, 16);

        // Haalt de versleutelde inhoud van het bestand op
        $encryptedData = substr($content, 16);

        // Gebruikt dezelfde sleutel als bij het uploaden van het bestand
        $key = hash('sha256', 'MythosEcnryptieSleutel', true);

        // Ontsleutelt het bestand zodat het weer gebruikt kan worden
        $decryptedData = openssl_decrypt(
            $encryptedData,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        // Stuurt het originele bestand naar de browser
        echo $decryptedData;
        exit;

    } else {
        echo "Bestand bestaat niet.";
    }

} else {
    echo "Geen bestand opgegeven.";
}
?>