<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        // Verifica credenziali database
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':username' => $username, ':password' => $password));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se l'utente esiste, imposto sessione per mantenere l'utente autenticato
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn() {
        // Verifica se l'utente è autenticato
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        // Logout dell'utente distruggendo la sessione
        session_destroy();
    }
}
?>