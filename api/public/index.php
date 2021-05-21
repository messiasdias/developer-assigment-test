<?php
/**
 * App Bootstrap
 */

require __DIR__ . '/../vendor/autoload.php';

//Cors and Config definitions
require __DIR__ . '/../src/cors.php';
require __DIR__ . '/../src/settings.php';

//Create App and set container
$app = Slim\Factory\AppFactory::create(
    new Slim\Psr7\Factory\ResponseFactory,
    new DI\Container
);

//Dependencies, middlewares and routes definitions
require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/../src/middlewares.php';
require __DIR__ . '/../src/routes.php';

//Run App
try {
    $app->run();
} catch (Slim\Exception\HttpNotFoundException $e){
    header("HTTP/1.1 404 End-Point Not Found!");
    header("Content-Type: application/json");
    echo json_encode(['status' => ['message' => $e->getMessage(), 'code' => 404]]);
}
