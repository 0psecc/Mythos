<?php
$servername = "localhost"; 
$dbname = "mythos";
$username = "root";
$password = "";

$melding = "";



session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestand uploaden</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">

    <h1>Mythos</h1>

    <nav>
        <a href="files.php" class="nav-btn">Files</a>
        <a href="logout.php" class="nav-btn">Logout</a>
    </nav>

</header>

<main class="login-page-wrapper">

    <div class="login-card">

        <h2>Bestand Uploaden</h2>

        <?php if ($melding): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($melding); ?>
            </div>
        <?php endif; ?>

        <form
            class="login-form"
            action="upload.php"
            method="post"
            enctype="multipart/form-data"
        >

            <div class="input-group">

                <label for="bestand">
                    Bestand kiezen
                </label>

                <input
                    type="file"
                    id="bestand"
                    name="bestand"
                    required
                >

            </div>

            <button
                type="submit"
                class="login-submit-btn"
            >
                Uploaden
            </button>

        </form>

        <a
            href="files.php"
            class="create-account-btn"
        >
            Ga naar bestandenlijst
        </a>

    </div>

</main>

</body>
</html>