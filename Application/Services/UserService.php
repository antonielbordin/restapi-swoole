<?php

namespace Application\Services;

use Domain\Entities\User;
use Domain\Repositories\IUserRepository;

class UserService
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($name, $login, $password)
    {
        $user = new User($name, $login, $password);
        $this->userRepository->save($user);
    }

    public function getUserByLogin($login)
    {
        return $this->userRepository->findByLogin($login);
    }
}
