<?php
//App config
$phinx_config = require __DIR__ . '/../phinx.php';

//Development and/or Production
$enviroment = $phinx_config['environments']['default_environment'] ?? 'development';
$db_config = $phinx_config['environments'][$enviroment];
$db_config['charset'] = 'utf8';

//Testing
$db_config_testing['driver'] = $phinx_config['environments']['testing']['driver'];
$db_config_testing['database'] = $phinx_config['environments']['testing']['database'];

if ($db_config['driver'] === 'sqlite') {
    unset(
      $db_config['adapter'],
      $db_config['host'], 
      $db_config['port'], 
      $db_config['name'], 
      $db_config['user'], 
      $db_config['pass']
    );
}

if ($db_config['driver'] === 'mysql') {
  unset(
    $db_config['name']
  );
}