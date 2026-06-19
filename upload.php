<?php

require_once 'auth.php';
require_once 'db_connection.php';

// HTTPS check (optioneel)
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    die("HTTPS is vereist.");
}

$melding = "";

// Upload handling
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_FILES["bestand"]) || $_FILES["bestand"]["error"] !== 0) {
        $melding = "Geen geldig bestand ontvangen.";
    }

    else {

        $bestand = $_FILES["bestand"];
        $bestandsnaam = basename($bestand["name"]);
        $sizeLimit = 10 * 1024 * 1024;

        if ($bestand["size"] > $sizeLimit) {
            $melding = "Bestand is te groot (max 10MB).";
        }

        else {

            $filePassword = $_POST["file_password"] ?? '';

            if ($filePassword === '') {
                $melding = "Bestand wachtwoord is verplicht.";
            }

            else {

                $data = file_get_contents($bestand["tmp_name"]);

                // AES key (terug zoals jij het had)
                $key = hash('sha256', 'MythosEcnryptieSleutel', true);

                $iv = random_bytes(16);

                $encryptedData = openssl_encrypt(
                    $data,
                    'AES-256-CBC',
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );

                $finalData = $iv . $encryptedData;

                $passwordHash = password_hash($filePassword, PASSWORD_DEFAULT);

                $token = bin2hex(random_bytes(32));

                $expiresAt = date("Y-m-d H:i:s", time() + 600);

                $stmt = $conn->prepare("
                    INSERT INTO uploads
                    (
                        user_id,
                        filename,
                        encrypted_file,
                        file_password_hash,
                        download_token,
                        expires_at
                    )
                    VALUES
                    (?, ?, ?, ?, ?, ?)
                ");

                $stmt->bind_param(
                    "isssss",
                    $_SESSION["user_id"],
                    $bestandsnaam,
                    $finalData,
                    $passwordHash,
                    $token,
                    $expiresAt
                );

                if ($stmt->execute()) {

                    $downloadLink = "/download/" . $token;

                    $melding = "Upload gelukt! Deel deze link: " . $downloadLink;

                } else {
                    $melding = "Upload mislukt in database.";
                }

                $stmt->close();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Upload bestand</title>
</head>
<body>

<h1>Bestand uploaden</h1>

<?php if ($melding): ?>
    <p><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <label>Bestand:</label>
    <input type="file" name="bestand" required>

    <br><br>

    <label>Bestand wachtwoord:</label>
    <input type="password" name="file_password" required>

    <br><br>

    <button type="submit">Uploaden</button>

</form>

<p><a href="/index">Terug</a></p>

</body>
</html>