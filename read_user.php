<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

$users = $user->readAll();

echo "<h2>Users</h2>";
echo "<ul>";
foreach ($users as $user) {
    echo "<li>{$user['username']}</li>";
}
echo "</ul>";
?>
