<?php
// Ho utilizzato la index.php per il sistema di login
session_start();
require_once 'Database.php';
require_once 'User.php';

// Connessione al database
$database = new Database();
$db = $database->connect();

// Istanziazione dell'oggetto User
$user = new User($db);

// Verifica se è stata inviata una richiesta POST per effettuare il login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tentativo di login con le credenziali fornite
    if ($user->login($username, $password)) {
        // Reindirizza a admin_panel.php dopo il login con successo
        header('Location: admin_panel.php');
        exit;
    } else {
        // Se le credenziali non sono valide, visualizza un messaggio di errore
        $error = 'Credenziali non valide';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <!-- Form per inserire le credenziali di accesso -->
    <form method="POST" action="">
        <!-- Campo per l'inserimento dello username -->
        <input type="text" name="username" placeholder="Username" required><br>
        <!-- Campo per l'inserimento della password -->
        <input type="password" name="password" placeholder="Password" required><br>
        <!-- Pulsante per inviare il modulo di login -->
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>


