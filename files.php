<?php

$uploadmap = "uploads/";

if (!file_exists($uploadmap)) {
    mkdir($uploadmap, 0777, true);
}

$bestanden = scandir($uploadmap);

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mythos Files</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="navbar">

    <h1>Mythos</h1>

    <nav>
        <a href="index.php" class="nav-btn">Upload</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </nav>

</header>


<main class="login-page-wrapper">

    <div class="login-card files-card">

        <h2>Beschikbare bestanden</h2>

        <div class="file-list">

            <?php

            $heeftBestanden = false;

            foreach ($bestanden as $bestand) {

                if ($bestand !== "." && $bestand !== "..") {

                    $heeftBestanden = true;

                    $urlBestand = urlencode($bestand);

                    echo '
                    <div class="file-item">

                        <span class="file-name">
                            ' . htmlspecialchars($bestand) . '
                        </span>

                        <a href="download.php?file=' . $urlBestand . '" class="download-btn">
                            Download
                        </a>

                    </div>';
                }
            }

            if (!$heeftBestanden) {

                echo '
                <div class="empty-files">
                    Er zijn nog geen bestanden geüpload.
                </div>';
            }

            ?>

        </div>


        <a href="index.php" class="create-account-btn">
            Terug naar uploaden
        </a>

    </div>

</main>

</body>

</html>