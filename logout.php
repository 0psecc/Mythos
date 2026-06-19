<?php

// Start de sessie zodat we hem kunnen vernietigen
session_start();

// Leegt alle sessie-variabelen
$_SESSION = [];

// Vernietigt de sessie zelf
session_destroy();

// Stuurt gebruiker terug naar login pagina
header("Location: /login.php");

exit;

?>