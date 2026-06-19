<?php

include 'db_connection.php';

// Controleert of het formulier daadwerkelijk verstuurd is
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: /registration.php");
    exit;
}

// Haalt de ingevulde gegevens op
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

$error = "";

// Controleert of alle velden ingevuld zijn
if ($username === '' || $password === '' || $confirmPassword === '') {

    $error = "Alle velden zijn verplicht.";
}

// Controleert of beide wachtwoorden gelijk zijn
elseif ($password !== $confirmPassword) {

    $error = "De wachtwoorden komen niet overeen.";
}

// Controleert of de gebruikersnaam al bestaat
if ($error === "") {

    $stmt = $conn->prepare("
        SELECT id
        FROM users
        WHERE username = ?
    ");

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $error = "Deze gebruikersnaam bestaat al.";
    }

    $stmt->close();
}

// Als er een fout is stopt het script
if ($error !== "") {

    die($error);
}

// Maakt een veilige hash van het wachtwoord
$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// Slaat de nieuwe gebruiker op
$stmt = $conn->prepare("
    INSERT INTO users
    (
        username,
        password
    )
    VALUES
    (
        ?,
        ?
    )
");

$stmt->bind_param(
    "ss",
    $username,
    $passwordHash
);

// Controleert of de gebruiker succesvol is toegevoegd
if ($stmt->execute()) {

    header("Location: /login.php?registered=1");

    exit;

} else {

    die("Account aanmaken mislukt.");
}

$stmt->close();

$conn->close();

?>