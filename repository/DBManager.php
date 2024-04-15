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
}

?>


