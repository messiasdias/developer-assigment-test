<?php
//Loading .env file
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['APP_ENV','DB_DRIVER']);

    if ($_ENV['DB_DRIVER'] === 'splite') {
        $dotenv->required('DB_NAME');
    }

    if ($_ENV['DB_DRIVER'] === 'mysql') {
        $dotenv->required(
            [
                'DB_HOST', 
                'DB_NAME',
                'DB_USER',
                'DB_PASS',
                'DB_PORT'
            ]
        );
    }
} catch(\Exception $e) {
    echo $e->getMessage();
    exit;
}

$eloquent = [
    'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? 'root',
    'database' => $_ENV['DB_DRIVER'] === 'sqlite' ? __DIR__."/{$_ENV['DB_NAME']}.sqlite3" : $_ENV['DB_NAME'],
];

$phinx = [
    'adapter' => $eloquent['driver'],
    'user' => $eloquent['username'],
    'pass' => $eloquent['password'],
    'name' => str_replace('.sqlite3', '', $eloquent['database']),
];

$database = array_merge(
    //Eloquent
    $eloquent,

    //Phinx
    $phinx,

    //both
    [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'charset' => 'utf8'
    ]
);

return
[
    'paths' => [
        'migrations' => [
            'App\Database' => '%%PHINX_CONFIG_DIR%%/src/database/migrations'
        ],
        'seeds' => [
            'App\Database' => '%%PHINX_CONFIG_DIR%%/src/database/seeds',
        ]
    ],
    'migration_base_class' => 'App\Database\Migration',
    'seed_base_class' => 'App\Database\Seed',
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => $_ENV['APP_ENV']  ?? 'development',
        'production' => $database,
        'development' => $database,
        'testing' => [
            //Phinx
            'adapter' => 'sqlite',
            'name' => __DIR__.'/storage/test_database',
            //Eloquent
            'driver' => 'sqlite',
            'database' => __DIR__.'/storage/test_database.sqlite3',
        ]
    ],
    'version_order' => 'creation'
];
