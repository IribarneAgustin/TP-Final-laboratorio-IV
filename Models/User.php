<?php

namespace Models;

class User{

    private $id;
    private $userName;
    private $email;
    private $password;
    private $role;

    public function __construct(){}

    public function getId()
    {
        return $this->getId;
    }

    public function setId()
    {
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;

    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

    }
}