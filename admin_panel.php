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
</body>
</html>