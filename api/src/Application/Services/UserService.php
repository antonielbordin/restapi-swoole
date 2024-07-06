<?php

namespace ApiSwoole\Application\Services;

use ApiSwoole\Infrastructure\Repositories\UserRepository;

class UserService
{
  private $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function getAllUsers()
  {
    return $this->userRepository->findAll();
  }

  public function getUserById($id)
  {
    return $this->userRepository->findById($id);
  }

  public function createUser($data)
  {
    return $this->userRepository->create($data);
  }
}
