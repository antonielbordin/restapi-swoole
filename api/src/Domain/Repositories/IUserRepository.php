<?php

namespace ApiSwoole\Domain\Repositories;

interface IUserRepository
{
  public function findAll();
  public function findById($id);
  public function create($data);
}
