<?php
// Avvia la sessione e richiede i file necessari per la gestione dell'autenticazione
session_start();
require_once 'Database.php';
require_once 'User.php';

// Connessione al database
$database = new Database();
$db = $database->connect();

// Istanzia un oggetto User per gestire le operazioni CRUD
$user = new User($db);

// Gestione della creazione di un nuovo utente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Crea un nuovo utente nel database
    if ($user->create($username, $password)) {
        // Reindirizza all'admin panel dopo la creazione dell'utente
        header('Location: admin_panel.php');
        exit;
    } else {
        // Messaggio di errore se si verifica un problema durante la creazione dell'utente
        $error = 'Errore durante la creazione dell\'utente';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
    <h2>Create User</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <!-- Form per la creazione di un nuovo utente -->
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="create">Create</button>
    </form>
</body>
</html>
