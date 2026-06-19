<?php

// Gebruiker moet ingelogd zijn voordat hij deze pagina mag zien
require_once 'auth.php';

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mythos Dashboard</title>
</head>
<body>

    <h1>Welkom, <?= htmlspecialchars($_SESSION['username']) ?></h1>

    <p>Je bent succesvol ingelogd.</p>

    <hr>

    <h2>Bestand uploaden</h2>

    <!-- Upload formulier (gaat straks naar nieuwe upload.php) -->
    <form action="/upload" method="post" enctype="multipart/form-data">

        <label>Kies bestand:</label>
        <input type="file" name="bestand" required>

        <br><br>

        <label>Bestand wachtwoord:</label>
        <input type="password" name="file_password" required>

        <br><br>

        <button type="submit">Uploaden</button>

    </form>

    <hr>

    <h2>Acties</h2>

    <!-- Logout via simpele link (komen we later op terug) -->
    <a href="/logout">Uitloggen</a>

</body>
</html>