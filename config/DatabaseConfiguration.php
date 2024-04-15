<?php

namespace config;

class DatabaseConfiguration
{
    private $host;
    private $dbname;
    private $username;
    private $password;

    /**
     * @param $host
     * @param $dbname
     * @param $username
     * @param $password
     */

    public function __construct()
    {
        $this->host = "localhost";
        $this->dbname = "hotel_management";
        $this->username = "user_hotel_management";
        $this->password = "Secret@!123";
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getDbname()
    {
        return $this->dbname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
