<?php
// Definizione della classe User
class User {
    // Proprietà privata per la connessione al database
    private $db;

    // Costruttore della classe User che accetta la connessione al database come parametro
    public function __construct($db) {
        $this->db = $db;
    }

    // Metodo per verificare se l'utente è loggato
    public function isLoggedIn() {
        // Verifica se nella sessione è presente l'ID dell'utente
        return isset($_SESSION['user_id']);
    }    

    // Metodo per effettuare il login dell'utente
    public function login($username, $password) {
        // Query per selezionare l'utente dal database con username e password corrispondenti
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        
        // Preparazione della query
        $stmt = $this->db->prepare($query);
        
        // Bind dei parametri username e password
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        // Esecuzione della query
        $stmt->execute();
        
        // Recupero dei dati dell'utente dalla riga risultante
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se esiste un utente con username e password corrispondenti
        if ($user) {
            // Imposta l'ID dell'utente nella sessione
            $_SESSION['user_id'] = $user['id'];
            // Restituisce true per indicare che il login è avvenuto con successo
            return true;
        } else {
            // Se non esiste un utente con username e password corrispondenti, restituisce false
            return false;
        }
    }

    // Metodo per creare un nuovo record nella tabella "avalanche"
    public function create($nome, $cognome) {
        // Query per inserire un nuovo record nella tabella "avalanche"
        $query = "INSERT INTO avalanche (nome, cognome) VALUES (:nome, :cognome)";
        
        // Preparazione della query
        $stmt = $this->db->prepare($query);
        
        // Bind dei parametri nome e cognome
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cognome', $cognome);
        
        // Esecuzione della query e restituzione del risultato
        return $stmt->execute();
    }

    // Metodo per leggere tutti i record dalla tabella "avalanche"
    public function readAll() {
        // Query per selezionare tutti i record dalla tabella "avalanche"
        $query = "SELECT * FROM avalanche";
        
        // Preparazione della query
        $stmt = $this->db->prepare($query);
        
        // Esecuzione della query
        $stmt->execute();
        
        // Restituzione dei risultati sotto forma di array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo per aggiornare un record nella tabella "avalanche"
    public function update($id, $newNome, $newCognome) {
        // Query per aggiornare un record nella tabella "avalanche"
        $query = "UPDATE avalanche SET nome = :nome, cognome = :cognome WHERE id = :id";
        
        // Preparazione della query
        $stmt = $this->db->prepare($query);
        
        // Bind dei parametri id, nome e cognome
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $newNome);
        $stmt->bindParam(':cognome', $newCognome);
        
        // Esecuzione della query e restituzione del risultato
        return $stmt->execute();
    }

    // Metodo per eliminare un record dalla tabella "avalanche"
    public function delete($id) {
        // Query per eliminare un record dalla tabella "avalanche"
        $query = "DELETE FROM avalanche WHERE id = :id";
        
        // Preparazione della query
        $stmt = $this->db->prepare($query);
        
        // Bind del parametro id
        $stmt->bindParam(':id', $id);
        
        // Esecuzione della query e restituzione del risultato
        return $stmt->execute();
    }
}
?>



