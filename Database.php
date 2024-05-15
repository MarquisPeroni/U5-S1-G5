<?php
class Database {
    private $host = 'localhost';
    private $username = 'root'; 
    private $password = ''; 
    private $dbname = 'autentication_system'; 
    private $conn;

    // Metodo per stabilire la connessione al database
    public function connect() {
        $this->conn = null;

        try {
            // Crea una nuova connessione PDO
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);

            // Imposta il modo di gestione degli errori su ERRMODE_EXCEPTION per abilitare le eccezioni PDO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Gestisce eventuali errori di connessione
            echo 'Connection Error: ' . $e->getMessage();
        }
        // Restituisce l'oggetto di connessione PDO
        return $this->conn;
    }
}
?>
