<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }    

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function create($nome, $cognome) {
        $query = "INSERT INTO avalanche (nome, cognome) VALUES (:nome, :cognome)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cognome', $cognome);
        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM avalanche";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $newNome, $newCognome) {
        $query = "UPDATE avalanche SET nome = :nome, cognome = :cognome WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $newNome);
        $stmt->bindParam(':cognome', $newCognome);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM avalanche WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>


