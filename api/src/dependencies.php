<?php
use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as EloquentCapsule;

//Get App container
$container = $app->getContainer();

//Eloquent db
$capsule = new EloquentCapsule;
$capsule->addConnection($db_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//Container base controller
$container->set('Controller', function ($container) {
    return new Controller($container);
});