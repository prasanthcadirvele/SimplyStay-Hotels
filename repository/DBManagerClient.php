<?php

require_once 'DBManager.php'; // Include the parent class
require_once '../src/class/Reservation.php'; // Include the Reservation class
require_once '../src/class/Room.php';

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

    public function getRoomByRoomId($room_id) {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM room WHERE id = ?");
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $room = $result->fetch_assoc();

        $stmt->close();
        $conn->close();
        return $room;
    }

    // Create a Room object from a room array
    public function createRoomClass($oneRoom) {
        $room = new Room($oneRoom['room_number'], $oneRoom['room_type'], $oneRoom['price_per_night'], $oneRoom['room_description'], $oneRoom['thumbnail_image']);
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
    public function getReservationsByUser($clientId) {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM reservation WHERE user_id = ?");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservations = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conn->close();

        $reservationsObj = [];
        foreach ($reservations as $reservation){
            $reservationsObj[] = $this->buildReservationObject($reservation);
        }
        return $reservationsObj;
    }

    public function buildReservationObject($reservation) {
        $user = $this->getUserById($reservation['user_id']);
        $room = $this->getRoomByRoomId($reservation['room_id']);

        $roomObject = $this->createRoomClass($room);

        $reservationObject = new Reservation($reservation['id'], $user, $roomObject, $reservation['start_date'], $reservation['end_date'], $reservation['nb_persons']);

        return $reservationObject;
    }

    // Effectuer une réservation
    public function makeReservation($roomId, $clientId, $checkInDate, $checkOutDate, $numberOfGuests) {
        $conn = $this->getConnection();
        $sql = "INSERT INTO reservation (room_id, user_id, start_date, end_date, reservation_date, nb_persons) VALUES ($roomId, $clientId, '$checkInDate', '$checkOutDate', NOW(), $numberOfGuests)";
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
    public function deleteReservation($reservation_id)
    {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("DELETE FROM reservation WHERE id = ?");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if($result){
            return true;
        }

        return false;
    }


}

