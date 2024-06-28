<?php

namespace Infrastructure\Repositories;

use Domain\Entities\User;
use Domain\Repositories\IUserRepository;

class UserRepository implements IUserRepository
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function save(User $user)
    {
        $stmt = $this->database->prepare("INSERT INTO users (name, login, password) VALUES (?, ?, ?)");
        $stmt->execute([$user->getName(), $user->getLogin(), $user->getPassword()]);
    }

    public function findByLogin($login)
    {
        $stmt = $this->database->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $result = $stmt->fetch();

        if ($result) {
            return new User($result['name'], $result['login'], $result['password']);
        }

        return null;
    }
}
