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

// Verifica se la richiesta HTTP è di tipo POST e se è stata inviata la variabile 'update'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Recupera l'ID dell'utente da aggiornare dalla variabile POST 'id'
    $id = $_POST['id'];
    
    // Recupera il nuovo username dalla variabile POST 'newUsername'
    $newUsername = $_POST['newUsername'];
    
    // Recupera la nuova password dalla variabile POST 'newPassword'
    $newPassword = $_POST['newPassword'];

    // Verifica se l'aggiornamento dell'utente ha avuto successo
    if ($user->update($id, $newUsername, $newPassword)) {
        // Se l'aggiornamento è avvenuto con successo, reindirizza l'utente alla pagina admin_panel.php
        header('Location: admin_panel.php');
        exit;
    } else {
        // Se si è verificato un errore durante l'aggiornamento, imposta un messaggio di errore
        $error = 'Errore durante l\'aggiornamento dell\'utente';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <!-- Campo nascosto per passare l'ID dell'utente da aggiornare -->
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <!-- Campo per inserire il nuovo username -->
        <input type="text" name="newUsername" placeholder="New Username" required><br>
        <!-- Campo per inserire la nuova password -->
        <input type="password" name="newPassword" placeholder="New Password" required><br>
        <!-- Pulsante di invio per aggiornare l'utente -->
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>

