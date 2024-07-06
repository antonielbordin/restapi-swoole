<?php

namespace ApiSwoole\Infrastructure\Repositories;

use ApiSwoole\Domain\Entities\User;
use ApiSwoole\Domain\Repositories\IUserRepository;

class UserRepository implements IUserRepository
{
  private $users = [];

  public function __construct()
  {
    // Data simulation
    $this->users[] = new User(1, 'John Doe', 'john@example.com');
  }

  public function findAll()
  {
    return $this->users;
  }

  public function findById($id)
  {
    foreach ($this->users as $user) {
      if ($user->getId() == $id) {
        return $user;
      }
    }
    return null;
  }

  public function create($data)
  {
    $user = new User(count($this->users) + 1, $data['name'], $data['email']);
    $this->users[] = $user;
    return $user;
  }
}
