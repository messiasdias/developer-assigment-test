<?php
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\PersonController;

// Routes
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write(json_encode(['success' => "API is working!"]));
  return $response;
});

$app->group('/person', function (RouteCollectorProxy $group) {
  $group->get('[/{page:[0-9]+}/{perPage:[0-9]+}]', PersonController::class . ':all');
  $group->get('/{id:[0-9]+}', PersonController::class . ':find');
  $group->post('', PersonController::class . ':create');
  $group->patch('', PersonController::class . ':update');
  $group->delete('', PersonController::class . ':delete');
})->add(new App\Middlewares\AuthMiddleware);