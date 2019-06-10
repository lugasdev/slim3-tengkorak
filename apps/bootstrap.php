<?php
require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection(array(
    'driver'    => $_ENV["DB_CONNECTION"],
    'host'      => $_ENV["DB_HOST"],
    'database'  => $_ENV["DB_DATABASE"],
    'username'  => $_ENV["DB_USERNAME"],
    'password'  => $_ENV["DB_PASSWORD"],
    'port'      => $_ENV["DB_PORT"],
));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$config = require APP_DIR . '/src/settings.php';
$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

// $container['errorHandler'] = function ($container) {
//     return function ($req, $res, $exception) use ($container) {

//         $err = [
//             "type"    => get_class($exception),
//             "message" => $exception->getMessage(),
//             "code"    => !empty($exception->getCode()) ? $exception->getCode() : 500
//         ];

//         return $res->withStatus( $err["code"] )
//             ->withHeader('Content-Type', 'application/json')
//             ->write( json_encode($err) );
//     };
// };

$container['view'] = function ($container) {
    $con = new \Controllers\Controller;

    return $con->twig();
    // return new \Slim\Views\PhpRenderer( APP_DIR . '/templates');
};
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler( APP_DIR . '/cache/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

include APP_DIR . "/src/middlewares.php";
include APP_DIR . "/src/routes.php";

$app->run();