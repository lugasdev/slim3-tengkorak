<?php
// Set timezone
date_default_timezone_set('Asia/Jakarta');

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

include 'configuration.php';

$config = require APP_DIR . '/src/settings.php';

$myApp = new \MyApp;
$app   = $myApp->SlimApp(['settings' => $config]);

$container = $app->getContainer();

$app->add(new \Slim\Middleware\Session([
    'name'        => md5( $_ENV["APP_NAME"] . "SESSION" ),
    'autorefresh' => true,
    'lifetime'    => '3 hour'
]));

$container['errorHandler'] = function ($container) {
    return function ($req, $res, $exception) use ($container) {

        $err = [
            "status"  => 'error',
            "type"    => get_class($exception),
            "message" => $exception->getMessage(),
            "code"    => !empty($exception->getCode()) ? (is_numeric($exception->getCode())) ? $exception->getCode() : 500 : 500
        ];

        if (strpos(get_class($exception), 'Illuminate\Database') !== false) {
            $err['code'] = 500;
            $err['message'] = 'Database Error';
        }
        if (strpos(get_class($exception), 'Illuminate\\Database') !== false) {
            $err['code'] = 500;
            $err['message'] = 'Database Error';
        }

        return $res->withStatus( $err["code"] )
            ->withHeader('Content-Type', 'application/json')
            ->write( json_encode($err) );
    };
};

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

$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

include APP_DIR . "/src/middlewares.php";
include APP_DIR . "/src/routes.php";

$app->run();
