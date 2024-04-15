<?php

class User
{
    private string $nom;
    private string $prenom;
    private string $adresse_mail;
    private int $age;
    private string $numero_telephone;
    private string $username;
    private string $password;
    private string $user_type;

    public function __construct($nom, $prenom, $adresse_mail, $age, $numero_telephone, $username, $password, $user_type)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse_mail = $adresse_mail;
        $this->age = $age;
        $this->numero_telephone = $numero_telephone;
        $this->username = $username;
        $this->password = $password;
        $this->user_type = $user_type;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getAdresseMail()
    {
        return $this->adresse_mail;
    }

    public function setAdresseMail($adresse_mail)
    {
        $this->adresse_mail = $adresse_mail;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getNumeroTelephone()
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone($numero_telephone)
    {
        $this->numero_telephone = $numero_telephone;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getUser_type()
    {
        return $this->user_type;
    }

    public function setUser_type($user_type)
    {
        $this->user_type = $user_type;
    }
}
