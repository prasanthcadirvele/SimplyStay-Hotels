<?php

require_once '../repository/DBManagerClient.php'; // Include the parent class : Includes all functions from client db manager

// Exclusive functions for DBManagerDirecteur
class DBManagerDirecteur extends DBManagerClient {
    public function __construct() {
        parent::__construct();
    }

    // Function to get all users
    public function getAllUsers() {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        $usersObj = [];
        foreach ($users as $user) {
            $usersObj[] = $this->getUserById($user["id"]);
        }

        return $usersObj;
    }

    // Function to add a new user
    public function addUser($userData) {
        $conn = $this->getConnection();

        // Extract user data
        $firstname = $userData['firstname'];
        $lastname = $userData['lastname'];
        $email = $userData['email']; 
        $age = $userData['age'];
        $num_tel = $userData['num_tel'];
        $username = $userData['username'];
        $password = $userData['password'];
        $userType = isset($userData['userType']) ? $userData['userType'] : 'client'; // Default user type is 'client'

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO _user (firstname, lastname, email, age, num_tel, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $firstname, $lastname, $email, $age, $num_tel, $username, $hashedPassword, $userType);

        // Execute the statement
        $success = $stmt->execute();

        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Return success or failure status
        return $success;
    }

    public function getReservations()
    {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM reservation");
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

    public function deleteUser($user_id){
        $conn = $this->getConnection();

        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if($result){
            return true;
        }

        return false;
    }

    // Add more functions specific to the director's tasks as needed
    public function getRoomTypes()
    {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM roomtype");
        $stmt->execute();
        $result = $stmt->get_result();
        $room_types = $result->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        return $room_types;
    }

    public function insertRoom( $room )
    {
        $conn = $this->getConnection();

        // Prepare the SQL statement
        $sql = "INSERT INTO room (room_number, room_type, price_per_night, room_description, thumbnail_image) VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $roomNumber = $room->getRoomNumber();
        $type = $room->getType();
        $pricePerNight = $room->getPricePerNight();
        $description = $room->getDescription();
        $thumbnailUrl = $room->getThumbnailUrl();
        $stmt->bind_param("ssdss", $roomNumber, $type, $pricePerNight, $description, $thumbnailUrl);
        $result = $stmt->execute();

        $stmt->close();
        $conn->close();

        // Execute the statement
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function insertRoomType($room_type)
    {
        $conn = $this->getConnection();

        // Prepare the SQL statement
        $sql = "INSERT INTO roomtype (room_type) VALUES (?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $room_type);
        $result = $stmt->execute();

        $stmt->close();
        $conn->close();

        // Execute the statement
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function archiveReservation($reservation_id)
    {
    $conn = $this->getConnection();

    // First, retrieve the reservation information
    $stmt = $conn->prepare("SELECT * FROM reservation WHERE id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Now, insert the reservation into the archived_reservation table
    $stmt = $conn->prepare("INSERT INTO archived_reservation (id, user_id, room_id, reservation_date, start_date, end_date, nb_persons, archive_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiisssss", $reservation['id'], $reservation['user_id'], $reservation['room_id'], $reservation['reservation_date'], $reservation['start_date'], $reservation['end_date'], $reservation['nb_persons']);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Finally, delete the reservation from the reservation table
    $stmt = $conn->prepare("DELETE FROM reservation WHERE id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return true;
    }
}

