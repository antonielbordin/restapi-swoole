<?php

namespace Domain\Entities;

class User
{
    private $name;
    private $login;
    private $password;

    public function __construct($name, $login, $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
