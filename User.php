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
    
        // Debug per verificare i dati ottenuti dalla query
        var_dump($user);
    
        // Se l'utente esiste
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }
    
    public function isLoggedIn() {
        // Verifica se l'utente è autenticato
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        // Logout dell'utente distruggendo la sessione
        session_destroy();
    }

    // Funzione per creare un nuovo utente nel database
    public function create($username, $password) {
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    // Funzione per leggere tutti gli utenti dal database
    public function readAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Funzione per aggiornare i dati di un utente nel database
    public function update($id, $newUsername, $newPassword) {
        $query = "UPDATE users SET username = :username, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':password', $newPassword);
        return $stmt->execute();
    }

    // Funzione per eliminare un utente dal database
    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

