<?php 
namespace App;

use Slim\Factory\AppFactory;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Server\RequestHandlerInterface as RequestHandler;


$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Set up middle (for CORS, JSON Parsing, etc.)
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// CORS Middleware
$app->add(function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

//Include routes
(require_once __DIR__ . '/routes/api.php')($app);


return $app;