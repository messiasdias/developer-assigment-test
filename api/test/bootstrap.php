<?php
/**
 * Test Bootstrap
 */

  //Loading composer and settings
  require __DIR__.'/../vendor/autoload.php';
  require __DIR__ . '/../src/settings.php';

  //Setting Eloquent db config
  $capsule = new Illuminate\Database\Capsule\Manager();
  $capsule->addConnection($db_config_testing);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

