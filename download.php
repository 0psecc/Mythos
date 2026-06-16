<?php
$uploadmap = "uploads/";

if (isset($_GET["file"])) {
    $bestand = basename($_GET["file"]);
    $pad = $uploadmap . $bestand;

    if (file_exists($pad)) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $bestand . "\"");
        header("Content-Length: " . filesize($pad));
        readfile($pad);
        exit;
    } else {
        echo "Bestand bestaat niet.";
    }
} else {
    echo "Geen bestand opgegeven.";
}
