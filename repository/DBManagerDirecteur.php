<?php

require_once 'DBManagerClient.php'; // Include the parent class : Includes all functions from client db manager


// Exclusive functions for DBManagerDirecteur
class DBManagerDirecteur extends DBManagerClient {
    public function __construct($servername, $username, $password, $dbname) {
        parent::__construct($servername, $username, $password, $dbname);
    }

    // Ajoutez ici les méthodes spécifiques pour le directeur
    // Par exemple, des méthodes pour gérer les utilisateurs, les réservations, les rapports, etc.
    // Voici un exemple de méthode pour récupérer tous les utilisateurs du système
    public function getAllUsers() {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM User";
        $result = $conn->query($sql);
        $users = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        $conn->close();
        return $users;
    }

    // Ajoutez d'autres méthodes spécifiques au directeur selon vos besoins
}

?>
