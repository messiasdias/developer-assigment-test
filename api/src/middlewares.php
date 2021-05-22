<?php
$middlewares = [
  //new App\Middlewares\AuthMiddleware,
  new App\Middlewares\GetParsedBody,
];

foreach ($middlewares as $middleware) {
  $app->add($middleware);
}