<?php

require_once 'class/User.php';

class DBManager {
    protected $conn;
    protected $servername;
    protected $username;
    protected $password;
    protected $dbname;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "hotel_user";
        $this->password = "admin";
        $this->dbname = "hotel";
    }

    public function getConnection() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function verifyUser($username, $password): bool {
        $this->getConnection();

        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $this->closeConnection();
        return $user !== null && password_verify($password, $user['password']);
    }

    public function closeConnection(): void {
        $this->conn->close();
    }

    // Function to insert a new user into the database
    public function insertUser(User $user) {
        $conn = $this->getConnection();
        
        // Extract user data
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $age = $user->getAge();
        $num_tel = $user->getNumTel();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $user_type = $user->getUserType();
        
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO user (firstname, lastname, email, age, num_tel, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $firstname, $lastname, $email, $age, $num_tel, $username, $password, $user_type);
        
        // Execute the statement
        $success = $stmt->execute();
        
        // Close statement
        $stmt->close();
        
        return $success;
    }

    // Function to check if a username already exists in the database
    public function usernameExists($username) {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $user !== null;
    }

    public function getUserByUsername($username){
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return new User($user['id'], $user['firstname'], $user['lastname'], $user['email'], $user['age'], $user['num_tel'], $user['username'], null, $user['user_type']);
    }

    public function getUserById($user_id){
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return new User($user['id'], $user['firstname'], $user['lastname'], $user['email'], $user['age'], $user['num_tel'], $user['username'], null, $user['user_type']);
    }

}



