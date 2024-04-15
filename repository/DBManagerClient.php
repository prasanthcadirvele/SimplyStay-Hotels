<?php

require_once 'DBManager.php'; // Include the parent class

class DBManagerClient extends DBManager {
    public function __construct($servername, $username, $password, $dbname) {
        parent::__construct($servername, $username, $password, $dbname);
    }

    // Consulter les annonces de chambres proposées
    public function getAllRooms() {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM room";
        $result = $conn->query($sql);
        $rooms = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
        }
        $conn->close();
        return $rooms;
    }

    // Effectuer une réservation
    public function makeReservation($roomId, $clientId, $checkInDate, $checkOutDate, $numberOfGuests) {
        $conn = $this->getConnection();
        // Ajoutez ici le code pour insérer une nouvelle réservation dans la base de données
        // Assurez-vous de gérer les vérifications de disponibilité de la chambre, etc.
    }

    // Consulter les réservations par le client
    public function getReservationsByClient($clientId) {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM reservation WHERE client_id = $clientId";
        $result = $conn->query($sql);
        $reservations = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reservations[] = $row;
            }
        }
        $conn->close();
        return $reservations;
    }

    // Modifier la réservation effectuée
    public function updateReservation($reservationId, $checkInDate, $checkOutDate, $numberOfGuests) {
        $conn = $this->getConnection();
        // Ajoutez ici le code pour mettre à jour une réservation existante dans la base de données
        // Assurez-vous de vérifier que la réservation peut être modifiée, etc.
    }

    // Annuler la réservation effectuée
    public function cancelReservation($reservationId) {
        $conn = $this->getConnection();
        // Ajoutez ici le code pour annuler une réservation dans la base de données
        // Assurez-vous de vérifier que la réservation peut être annulée, etc.
    }

    // Ajoutez d'autres méthodes spécifiques au client selon vos besoins
}

?>
