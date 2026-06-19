<?php

require_once 'auth.php';
require_once 'db_connection.php';

// Zorg dat token aanwezig is (clean URL of fallback)
$token = $_GET['token'] ?? '';

if ($token === '') {
    die("Geen download token opgegeven.");
}

// Haal bestand op uit database via token
$stmt = $conn->prepare("
    SELECT 
        id,
        filename,
        encrypted_file,
        file_password_hash,
        expires_at,
        used
    FROM uploads
    WHERE download_token = ?
");

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bestand bestaat niet.");
}

$file = $result->fetch_assoc();

// Controle: expired?
if (strtotime($file['expires_at']) < time()) {

    die("Deze link is verlopen.");
}

// Controle: al gebruikt?
if ($file['used'] == 1) {
    die("Deze downloadlink is al gebruikt.");
}

// Wachtwoord check (via POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
?>

<form method="POST">
    <h2>Voer bestand wachtwoord in</h2>
    <input type="password" name="file_password" required>
    <button type="submit">Download</button>
</form>

<?php
    exit;
}

// Check password
$password = $_POST["file_password"] ?? '';

if (!password_verify($password, $file["file_password_hash"])) {
    die("Onjuist wachtwoord.");
}

// AES decrypt key
$key = hash('sha256', 'MythosEcnryptieSleutel', true);

// Split IV + data
$content = $file["encrypted_file"];
$iv = substr($content, 0, 16);
$encryptedData = substr($content, 16);

// Decrypt bestand
$decryptedData = openssl_decrypt(
    $encryptedData,
    'AES-256-CBC',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

// Markeer als gebruikt (one-time link)
$stmt = $conn->prepare("
    UPDATE uploads
    SET used = 1
    WHERE id = ?
");

$stmt->bind_param("i", $file["id"]);
$stmt->execute();

// Headers voor download
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $file["filename"] . "\"");
header("Content-Length: " . strlen($decryptedData));

// Output file
echo $decryptedData;

exit;

?>