<?php
// Avvia la sessione
session_start();

// Include il file Database.php che contiene la classe Database
require_once 'Database.php';

// Include il file User.php che contiene la classe User
require_once 'User.php';

// Istanzia un oggetto Database per la connessione al database
$database = new Database();

// Connessione al database utilizzando l'oggetto Database
$db = $database->connect();

// Istanzia un oggetto User passando la connessione al database
$user = new User($db);

// Ottiene tutti gli utenti dal database
$users = $user->readAll();

// Mostra gli utenti recuperati
echo "<h2>Users</h2>";
echo "<ul>";
foreach ($users as $user) {
    // Mostra l'username di ogni utente all'interno di un elenco non ordinato
    echo "<li>{$user['username']}</li>";
}
echo "</ul>";
?>

