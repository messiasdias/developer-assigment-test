<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\PersonController;

// Routes
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write(json_encode(['success' => "API is working!"]));
  return $response;
});

$app->get('/person', PersonController::class . ':all');
$app->get('/person/{id}', PersonController::class . ':find');
$app->post('/person', PersonController::class . ':create');
$app->patch('/person', PersonController::class . ':update');
$app->delete('/person', PersonController::class . ':delete');