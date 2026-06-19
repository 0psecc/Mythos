<?php

require_once 'db_connection.php';

// Verwijder uploads die zijn verlopen
$stmt = $conn->prepare("
    DELETE FROM uploads
    WHERE expires_at < NOW()
");

$stmt->execute();

// (optioneel) ook al gebruikte links opruimen
$stmt = $conn->prepare("
    DELETE FROM uploads
    WHERE used = 1 AND expires_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)
");

$stmt->execute();

echo "Cleanup uitgevoerd: verlopen uploads verwijderd.";

?>