<?php
$servername = "localhost"; 
$dbname = "mythos";
$username = "root";
$password = "";

$melding = "";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestand uploaden</title>
</head>
<body>
    <h1>Bestand uploaden</h1>

    <?php if ($melding): ?>
        <p><?php echo $melding; ?></p>
    <?php endif; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Bestand kiezen:</label>
        <input type="file" name="bestand" required>
        <button type="submit">Uploaden</button>
    </form>

    <p><a href="files.php">Ga naar bestandenlijst</a></p>
</body>
</html>