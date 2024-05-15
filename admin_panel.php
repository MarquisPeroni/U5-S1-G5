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

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user'])) {
    $nome = $_POST['new_nome'];
    $cognome = $_POST['new_cognome'];

    if ($user->create($nome, $cognome)) {
        $message = 'Nuovo record creato con successo!';
    } else {
        $message = 'Errore durante la creazione del nuovo record.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $newNome = $_POST['updated_nome'];
    $newCognome = $_POST['updated_cognome'];

    if ($user->update($id, $newNome, $newCognome)) {
        $message = 'Record aggiornato con successo!';
    } else {
        $message = 'Errore durante l\'aggiornamento del record.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];

    if ($user->delete($id)) {
        $message = 'Record eliminato con successo!';
    } else {
        $message = 'Errore durante l\'eliminazione del record.';
    }
}

$records = $user->readAll();
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

    <h3>Gestione Dati Tabella Avalanche</h3>
    <p><?php echo $message; ?></p>

    <h4>Crea Nuovo Record</h4>
    <form method="post" action="">
        <label for="new_nome">Nome:</label>
        <input type="text" id="new_nome" name="new_nome" required><br>
        <label for="new_cognome">Cognome:</label>
        <input type="text" id="new_cognome" name="new_cognome" required><br>
        <button type="submit" name="create_user">Crea Record</button>
    </form>

    <h4>Elenco Records</h4>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Azioni</th>
        </tr>
        <?php foreach ($records as $record): ?>
            <tr>
                <td><?php echo $record['id']; ?></td>
                <td><?php echo $record['nome']; ?></td>
                <td><?php echo $record['cognome']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $record['id']; ?>">
                        <input type="text" name="updated_nome" value="<?php echo $record['nome']; ?>">
                        <input type="text" name="updated_cognome" value="<?php echo $record['cognome']; ?>">
                        <button type="submit" name="update_user">Aggiorna</button>
                    </form>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $record['id']; ?>">
                        <button type="submit" name="delete_user">Elimina</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


