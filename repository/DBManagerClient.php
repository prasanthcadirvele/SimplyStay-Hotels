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
        return $rooms; /* TODO convert all rooms to room class => send $rooms value to another function that exploits associated array and creates a list of array */
    }

    /*
     * public function createRoomClass($oneRoom){
     *      $room = new Room();
     *      $room->setAttribut1($oneRoom['attribut1'])
     *      ... (other attributs)
     *      return $room;
     * }
     */

    /*
     * public function createRoomClassList($roomsList){
     *      $roomClassList = [];
     *      for $room in $roomList {
     *          $roomClass[] = $this->createRoomClass($room); // adding to list
     *      }
     *      return $roomClassList;
     * }
     */

    /* TODO : Create a function to check if a reservation exists for a particular date for a give room */

    /*
     * public function isRoomFree($dateDebut, $dateFin, $roomNumber){
     *      check in database => return true if exists else false;
     * }
     */

    /*
     * public makeReservation($roomId, $clientId, $checkInDate, $checkOutDate, $numberOfGuests){
     *      // function that only inserts data in reservation table
     * }
     */

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

    /* TODO : convert all reservation details to reservation class */

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
