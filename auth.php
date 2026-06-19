<?php

// Start een sessie zodat gebruikersgegevens beschikbaar zijn
session_start();

// Controleert of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {

    // Stuurt niet-ingelogde gebruikers terug naar de loginpagina
    header("Location: /login");

    exit;
}

// Extra beveiliging tegen sessie-kaping
if (!isset($_SESSION['created'])) {

    $_SESSION['created'] = time();

} elseif (time() - $_SESSION['created'] > 1800) {

    // Vernieuwt het sessie-ID iedere 30 minuten
    session_regenerate_id(true);

    $_SESSION['created'] = time();
}

?>