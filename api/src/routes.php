<?php
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\PersonController;

//Not Found
$app->get('error/{status}', function (Request $request, Response $response, $args) {
    return $response->withStatus($args['status'] ?? 404);
});

// Routes
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write(json_encode(['success' => "API is working!"]));
  return $response;
});

$app->group('/person', function (RouteCollectorProxy $group) {
  $group->get('', PersonController::class . ':all');
  $group->get('/{id}', PersonController::class . ':find');
  $group->post('', PersonController::class . ':create');
  $group->patch('', PersonController::class . ':update');
  $group->delete('', PersonController::class . ':delete');
})->add(new App\Middlewares\AuthMiddleware);