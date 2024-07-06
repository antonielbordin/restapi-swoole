<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROUTE', realpath(dirname(__FILE__)) . DS); 

require 'vendor/autoload.php';

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use ApiSwoole\Api\Router;

// Create an instance of the HTTP server
$http = new Server("0.0.0.0", 5009, SWOOLE_BASE);

$http->on("start", function ($server) {
  echo "Swoole http server is started at http://127.0.0.1:5009\n";   
});

$http->on("request", function (Request $request, Response $response) {
  $router = new Router();
  $router->handle($request, $response);
});

// Start the server
$http->start();
