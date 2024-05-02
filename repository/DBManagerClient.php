<?php

require_once 'DBManager.php'; // Include the parent class
require_once 'Reservation.php'; // Include the Reservation class

class DBManagerClient extends DBManager {
    public function __construct() {
        parent::__construct();
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

    /**
     * Get room by room ID
     * 
     * @param int $room_id The ID of the room
     * @return Room|null The room object if found, null otherwise
     */
    public function getRoomByRoomId($room_id) {
        // Assuming you have a 'rooms' table in your database
        $sql = "SELECT * FROM rooms WHERE room_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $room = new Room($row['room_id'], $row['room_number'], $row['room_type'],); // Adjust based on your Room class
            return $room;
        } else {
            return null;
        }
    }

    // Create a Room object from a room array
    public function createRoomClass($oneRoom) {
        $room = new Room($oneRoom['roomNumber'], $oneRoom['type'], $oneRoom['pricePerNight']);
        // Set other attributes...
        return $room;
    }

    // Create a list of Room objects from a list of room arrays
    public function createRoomClassList($roomsList) {
        $roomClassList = [];
        foreach ($roomsList as $room) {
            $roomClassList[] = $this->createRoomClass($room);
        }
        return $roomClassList;
    }

    // Create a Reservation object from a reservation array
    public function createReservationClass($oneReservation) {
        $reservation = new Reservation($oneReservation['user'], $oneReservation['room'], $oneReservation['reservationDebut'], $oneReservation['reservationFin'], $oneReservation['nombreDePersonnes']);
        // Set check-in and check-out dates if available
        if (isset($oneReservation['checkInDate'])) {
            $reservation->setReservationDebut($oneReservation['checkInDate']);
        }
        if (isset($oneReservation['checkOutDate'])) {
            $reservation->setReservationFin($oneReservation['checkOutDate']);
        }
        // Set other attributes if needed
        return $reservation;
    }

    // Create a list of Reservation objects from a list of reservation arrays
    public function createReservationClassList($reservationsList) {
        $reservationClassList = [];
        foreach ($reservationsList as $reservation) {
            $reservationClassList[] = $this->createReservationClass($reservation);
        }
        return $reservationClassList;
    }

    // Create a function to check if a reservation exists for a particular date for a given room
    public function isRoomFree($dateDebut, $dateFin, $roomNumber) {
        $conn = $this->getConnection();
        $sql = "SELECT COUNT(*) as count FROM reservation WHERE room_id = $roomNumber AND check_in_date <= '$dateFin' AND check_out_date >= '$dateDebut'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $conn->close();
        return $count == 0; // True if room is free, false otherwise
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

    // Effectuer une réservation
    public function makeReservation($roomId, $clientId, $checkInDate, $checkOutDate, $numberOfGuests) {
        $conn = $this->getConnection();
        $sql = "INSERT INTO reservation (room_id, client_id, check_in_date, check_out_date, number_of_guests) VALUES ($roomId, $clientId, '$checkInDate', '$checkOutDate', $numberOfGuests)";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    // Modifier la réservation effectuée
    public function updateReservation($reservationId, $checkInDate, $checkOutDate, $numberOfGuests) {
        $conn = $this->getConnection();
        $sql = "UPDATE reservation SET check_in_date = '$checkInDate', check_out_date = '$checkOutDate', number_of_guests = $numberOfGuests WHERE id = $reservationId";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    // Annuler la réservation effectuée
    public function cancelReservation($reservationId) {
        $conn = $this->getConnection();
        $sql = "DELETE FROM reservation WHERE id = $reservationId";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    // Other methods...
}

