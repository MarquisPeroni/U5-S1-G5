<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

if (!$user->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Messaggio di successo o errore dopo le operazioni CRUD
$message = '';

// Se è stata inviata una richiesta di creazione di un nuovo utente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];

    if ($user->create($username, $password)) {
        $message = 'Nuovo utente creato con successo!';
    } else {
        $message = 'Errore durante la creazione del nuovo utente.';
    }
}

// Se è stata inviata una richiesta di aggiornamento di un utente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $newUsername = $_POST['updated_username'];
    $newPassword = $_POST['updated_password'];

    if ($user->update($id, $newUsername, $newPassword)) {
        $message = 'Utente aggiornato con successo!';
    } else {
        $message = 'Errore durante l\'aggiornamento dell\'utente.';
    }
}

// Se è stata inviata una richiesta di eliminazione di un utente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];

    if ($user->delete($id)) {
        $message = 'Utente eliminato con successo!';
    } else {
        $message = 'Errore durante l\'eliminazione dell\'utente.';
    }
}

// Leggi tutti gli utenti dal database
$users = $user->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <p>Benvenuto, <?php echo $_SESSION['user_id']; ?>!</p>
    <a href="logout.php">Logout</a>

    <h3>Gestione Utenti</h3>
    <p><?php echo $message; ?></p>

    <h4>Crea Nuovo Utente</h4>
    <form method="post" action="">
        <label for="new_username">Username:</label>
        <input type="text" id="new_username" name="new_username" required><br>
        <label for="new_password">Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <button type="submit" name="create_user">Crea Utente</button>
    </form>

    <h4>Elenco Utenti</h4>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Azioni</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['password']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="text" name="updated_username" value="<?php echo $user['username']; ?>">
                        <input type="text" name="updated_password" value="<?php echo $user['password']; ?>">
                        <button type="submit" name="update_user">Aggiorna</button>
                    </form>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="delete_user">Elimina</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
