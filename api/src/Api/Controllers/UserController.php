<?php
namespace ApiSwoole\Api\Controllers;

use Swoole\Http\Request;
use Swoole\Http\Response;
use ApiSwoole\Application\Services\UserService;

use Firebase\JWT\JWT;

class UserController
{
  private $userService;

  /** Predefined user credentials */ 
  private $credentials = [
    'username' => 'admin',
    'password' => 'admin'
  ];

  /** JWT secret key */
  private $jwtSecret = 'UThEQ9Mfoj3jYKSvhSrq1vm6LwIZ1zta';

  public function __construct()
  {
    $this->userService = new UserService();
  }

  public function getAllUsers(Request $request, Response $response)
  {
    $users = $this->userService->getAllUsers();
    $response->header("Content-Type", "application/json");
    $response->end(json_encode(['data' => $users]));
  }

  public function getUserById(Request $request, Response $response, $id)
  {
    $user = $this->userService->getUserById($id);
    if ($user) {
      $response->header('Content-Type', 'application/json');
      $response->end(json_encode(['data' => $user]));
    } else {
      $response->status(404);
      $response->header("Content-Type", "application/json");
      $response->end(json_encode(['error' => 'User not found']));
    }
  }

  public function createUser(Request $request, Response $response)
  {
    $data = json_decode($request->rawContent(), true);
    $user = $this->userService->createUser($data);
    $response->status(201);
    $response->header('Content-Type', 'application/json');    
    $response->end(json_encode(['data' => $user]));
  }

  public function authUser(Request $request, Response $response)
  {
    // Get raw POST data
    $postData = $request->rawContent(); 
    // Decode Json Data
    $data = json_decode($postData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      $response->status(400);
      $response->end('Invalid JSON data');
      return;
    }

    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;
    
    // Check credentials
    if ($this->credentials['username'] === $username && $this->credentials['password'] === $password) {
      // Generate JWT token
      $payload = [
        'iss' => 'authenticator.api', // Issuer
        'iat' => time(),              // Issued at: time when the token was generated
        'exp' => time() + 3600,       // Expiration time (1 hour from now)
        'sub' => $username,           // Subject (the username)
        'role' => 'admin'             // role (the role for user)
      ];

      $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

      // Send response with JWT token
      $response->header("Content-Type", "application/json");
      $response->end(json_encode(['data' => $jwt]));
    } else {
      // Invalid credentials
      $response->status(401);
      $response->header("Content-Type", "application/json");
      $response->end(json_encode(['error' => 'Invalid username or password']));
    }
  }
}
