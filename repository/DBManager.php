<?php
class DBManager {
    protected $conn;
    protected $servername;
    protected $username;
    protected $password;
    protected $dbname;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
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

        $stmt = $this->conn->prepare("SELECT * FROM User WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $this->closeConnection();
        return $user !== null;
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
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO User (firstname, lastname, email, age, num_tel, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $firstname, $lastname, $email, $age, $num_tel, $username, $hashedPassword, $user_type);
        
        // Execute the statement
        $success = $stmt->execute();
        
        // Close statement
        $stmt->close();
        
        return $success;
    }

    // Function to check if a username already exists in the database
    public function usernameExists($username) {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM User WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $user !== null;
    }
}



