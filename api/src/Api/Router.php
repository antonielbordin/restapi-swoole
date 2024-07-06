<?php
namespace ApiSwoole\Api;

use Swoole\Http\Request;
use Swoole\Http\Response;
use ApiSwoole\Api\Controllers\UserController;

class Router
{
  private $routes = [];

  public function __construct()
  {
    $this->routes = [
      'GET' => [
        '/users' => [UserController::class, 'getAllUsers'],
        '/users/{id}' => [UserController::class, 'getUserById'],
      ],
      'POST' => [
        '/users' => [UserController::class, 'createUser'],
        '/authenticate' => [UserController::class, 'authUser'],
      ],
      // Add more routes as needed
    ];
  }

  public function handle(Request $request, Response $response)
  {
    $method = $request->server['request_method'];
    $uri = $request->server['request_uri'];

    if (isset($this->routes[$method])) {
      foreach ($this->routes[$method] as $route => $handler) {
        $routePattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
        if (preg_match('#^' . $routePattern . '$#', $uri, $matches)) {
          array_shift($matches); // Remove the full match from the beginning
          $controller = new $handler[0];
          call_user_func_array([$controller, $handler[1]], array_merge([$request, $response], $matches));
          return;
        }
      }
    }

    $response->status(404);
    $response->header("Content-Type", "application/json");
    $response->end(json_encode(['error' => 'Route not found']));
  }
}
