<?php

require_once 'DBManagerClient.php'; // Include the parent class : Includes all functions from client db manager

// Exclusive functions for DBManagerDirecteur
class DBManagerDirecteur extends DBManagerClient {
    public function __construct($servername, $username, $password, $dbname) {
        parent::__construct($servername, $username, $password, $dbname);
    }

    // Function to get all users
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
        $stmt = $conn->prepare("INSERT INTO User (firstname, lastname, email, age, num_tel, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $firstname, $lastname, $email, $age, $num_tel, $username, $hashedPassword, $userType);

        // Execute the statement
        $success = $stmt->execute();

        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Return success or failure status
        return $success;
    }

    // Function to remove an existing user
    public function removeUser($userId) {
        $conn = $this->getConnection();
        // Implement code to remove the user with $userId from the database
        $conn->close();
        // Return success or failure status
    }

    // Function to modify an existing user
    public function modifyUser($userId, $modifiedUserData) {
        $conn = $this->getConnection();
        // Implement code to modify the user with $userId using $modifiedUserData
        $conn->close();
        // Return success or failure status
    }

    // Function to get all personnel
    public function getAllPersonnel() {
        $conn = $this->getConnection();
        // Implement code to get all personnel from the database
        $conn->close();
        // Return personnel data
    }

    // Function to add a new personnel
    public function addPersonnel($personnelData) {
        $conn = $this->getConnection();
        // Implement code to add a new personnel to the database using $personnelData
        $conn->close();
        // Return success or failure status
    }

    // Function to remove a personnel
    public function removePersonnel($personnelId) {
        $conn = $this->getConnection();
        // Implement code to remove the personnel with $personnelId from the database
        $conn->close();
        // Return success or failure status
    }

    // Function to update a personnel
    public function updatePersonnel($personnelId, $newPersonnelData) {
        $conn = $this->getConnection();
        // Implement code to update the personnel with $personnelId using $newPersonnelData
        $conn->close();
        // Return success or failure status
    }

    // Function to add a new room type
    public function addRoomType($roomTypeData) {
        $conn = $this->getConnection();
        // Implement code to add a new room type to the database using $roomTypeData
        $conn->close();
        // Return success or failure status
    }

    // Function to add a new room
    public function addRoom($roomData) {
        $conn = $this->getConnection();
        // Implement code to add a new room to the database using $roomData
        $conn->close();
        // Return success or failure status
    }

    // Function to modify room information
    public function modifyRoom($roomId, $modifiedRoomData) {
        $conn = $this->getConnection();
        // Implement code to modify room information for room with $roomId using $modifiedRoomData
        $conn->close();
        // Return success or failure status
    }

    // Function to delete a room type
    public function deleteRoomType($roomTypeId) {
        $conn = $this->getConnection();
        // Implement code to delete the room type with $roomTypeId from the database
        $conn->close();
        // Return success or failure status
    }

    // Function to delete a room
    public function deleteRoom($roomId) {
        $conn = $this->getConnection();
        // Implement code to delete the room with $roomId from the database
        $conn->close();
        // Return success or failure status
    }

    // Add more functions specific to the director's tasks as needed
}

?>

