<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROUTE', realpath(dirname(__FILE__)) . DS); 

require 'vendor/autoload.php';

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

use Firebase\JWT\JWT;

// JWT secret key 
$jwtSecret = 'UThEQ9Mfoj3jYKSvhSrq1vm6LwIZ1zta';

// Predefined user credentials
$credentials = [
  'username' => 'admin',
  'password' => 'admin'
];

// Create an instance of the HTTP server
$http = new Server("0.0.0.0", 5009, SWOOLE_BASE);

$http->on("start", function ($server) {
  echo "Swoole http server is started at http://127.0.0.1:5009\n";   
});

// Define a route for handling POST requests for authentication
$http->on('request', function (Request $request, Response $response) use ($jwtSecret, $credentials) {
  $path = $request->server['request_uri'];

  if ($request->server['request_method'] === 'POST' && $path === '/authenticate') {
    // Get POST data
    $postData = $request->post;
    $username = $postData['username'] ?? null;
    $password = $postData['password'] ?? null;

    // Check credentials
    if ($username === $credentials['username'] && $password === $credentials['password']) {
      // Generate JWT token
      $payload = [
        'iss' => 'authenticator.api', // Issuer
        'iat' => time(),              // Issued at: time when the token was generated
        'exp' => time() + 3600,       // Expiration time (1 hour from now)
        'sub' => $username,           // Subject (the username)
        'role' => 'admin'             // role (the role for user)
      ];
      
      $jwt = JWT::encode($payload, $jwtSecret, 'HS256');

      // Send response with JWT token
      $response->header("Content-Type", "application/json");
      $response->end(json_encode(['token' => $jwt]));
    } else {
      // Invalid credentials
      $response->status(401);
      $response->header("Content-Type", "application/json");
      $response->end(json_encode(['error' => 'Invalid username or password']));
    }
  } else {
    // Route not found
    $response->status(404);
    $response->header("Content-Type", "application/json");
    $response->end(json_encode(['error' => 'Route not found']));
  }
});

// Start the server
$http->start();