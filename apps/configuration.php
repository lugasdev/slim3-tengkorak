<?php
use Illuminate\Database\Capsule\Manager as Capsule;

function loadEnvRecursive(){
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
    if (!isset($_ENV['APP_NAME'])) // checks a variable that should be loaded
    {
        sleep(1);
        return loadEnvRecursive(); // if not set, retry ad infinitum
    }
}
loadEnvRecursive();

$capsule = new Capsule;
$capsule->addConnection(
    array(
        'driver'    => $_ENV["DB_CONNECTION"],
        'host'      => $_ENV["DB_HOST"],
        'database'  => $_ENV["DB_DATABASE"],
        'username'  => $_ENV["DB_USERNAME"],
        'password'  => $_ENV["DB_PASSWORD"],
        'port'      => $_ENV["DB_PORT"],
        'read' => [
            'host' => $_ENV["DB_HOST"]
        ],
        'write' => [
            'host' => $_ENV["DB_HOST"]
        ],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ),
    "default"
);

$capsule->setAsGlobal();
$capsule->bootEloquent();

