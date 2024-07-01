<?php

namespace Domain\Repositories;

use Domain\Entities\User;

interface IUserRepository
{
    public function save(User $user);
    public function findByLogin($login);
}
