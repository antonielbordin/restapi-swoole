<?php

namespace Api\Controllers;

use Application\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $this->userService->registerUser($data['name'], $data['login'], $data['password']);
        return $response->withStatus(201)->withJson(['message' => 'User created']);
    }

    public function getUser(Request $request, Response $response, $args)
    {
        $user = $args['login'];
        $userData = $this->userService->getUserByLogin($user);

        if ($userData) {
            return $response->withJson($userData);
        }

        return $response->withStatus(404)->withJson(['message' => 'User not found']);
    }
}
