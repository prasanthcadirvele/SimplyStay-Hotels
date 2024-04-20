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
        $this->username = "root";
        $this->password = "";
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
