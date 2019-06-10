<?php

$app->get('/', Controllers\HomeController::class . ':home');

// $app->get('/', function ($req, $res, $args) {
//     $res->getBody()->write("Hello, Lugas");
//     return $res;
// });

// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });

// $app->post("/v1/login", Controllers\UsersController::class . ':login');
// $app->post("/v1/registration", Controllers\UsersController::class . ':registration');

// $app->group('/v1', function (\Slim\App $app) {
//     $app->get("/device", Controllers\DevicesController::class . ':get');
// })->add($auth);

