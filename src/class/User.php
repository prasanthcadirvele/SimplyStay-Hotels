<?php

class User
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private int $age;
    private string $num_tel;
    private string $username;
    private string $password;
    private string $user_type;

    public function __construct($id, $firstname, $lastname, $email, $age, $num_tel, $username, $password, $user_type)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->age = $age;
        $this->num_tel = $num_tel;
        $this->username = $username;
        $this->password = $password;
        $this->user_type = $user_type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getNumTel(): string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): void
    {
        $this->num_tel = $num_tel;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUserType(): string
    {
        return $this->user_type;
    }

    public function setUserType(string $user_type): void
    {
        $this->user_type = $user_type;
    }
}

