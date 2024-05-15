<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

// Connessione al database
$database = new Database();
$db = $database->connect();

// Istanziazione dell'oggetto User
$user = new User($db);

// Verifica se è stata inviata una richiesta POST per eliminare un utente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Tentativo di eliminazione dell'utente dal database
    if ($user->delete($id)) {
        // Reindirizza a admin_panel.php dopo l'eliminazione con successo
        header('Location: admin_panel.php');
        exit;
    } else {
        // Se si verifica un errore durante l'eliminazione, visualizza un messaggio di errore
        $error = 'Errore durante l\'eliminazione dell\'utente';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
    <h2>Delete User</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <!-- Form per confermare l'eliminazione dell'utente -->
    <form method="POST" action="">
        <!-- Campo nascosto per passare l'ID dell'utente da eliminare -->
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <!-- Pulsante per confermare l'eliminazione -->
        <button type="submit" name="delete">Delete</button>
    </form>
</body>
</html>
