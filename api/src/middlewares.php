<?php
$middlewares = [
  //new App\Middlewares\AuthMiddleware,
];

foreach ($middlewares as $middleware) {
  $app->add($middleware);
}