<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    if ($user->update($id, $newUsername, $newPassword)) {
        header('Location: admin_panel.php');
        exit;
    } else {
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
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="text" name="newUsername" placeholder="New Username" required><br>
        <input type="password" name="newPassword" placeholder="New Password" required><br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
