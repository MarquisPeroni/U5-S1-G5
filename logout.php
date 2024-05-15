<?php
// Inizia la sessione
session_start();

// Svuota tutti i dati della sessione
session_unset();

// Distrugge la sessione
session_destroy();

// Reindirizza l'utente alla pagina di login (presumibilmente index.php)
header("Location: index.php");
exit;
?>
