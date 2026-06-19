<?php
function logActie($actie, $bestandsnaam = "") {
    $logmap = "logs/"; // Vaste map voor logs
    if (!file_exists($logmap)) {
        mkdir($logmap, 0777, true); // Maakt logmap aan als die nog niet bestaat
    }

    $tijd = date("Y-m-d H:i:s"); // Huidige datum en tijd
    $ip = $_SERVER["REMOTE_ADDR"]; // IP-adres van de gebruiker (vervangt "wie" zonder login systeem)

    $logregel = "[$tijd] $actie - Bestand: $bestandsnaam - IP: $ip" . PHP_EOL; // Bouwt de logregel op
    file_put_contents($logmap . "logboek.txt", $logregel, FILE_APPEND); // Voegt de regel toe aan het logbestand
}
?>