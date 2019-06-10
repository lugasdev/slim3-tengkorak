<?php

$auth = function ($request, $response, $next) {
    $user = !empty($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
    $pass = !empty($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

    if (empty($user) OR empty($pass)) {
        throw new \AuthException("You Don't Have Access to Perform This Action");
    }

    $src_token = new \Models\Tokens;

    $src_token->user_id = $user;
    $src_token->token   = $pass;
    $authCheck          = $src_token->authCheck();

    if (!$authCheck) {
        throw new \AuthException("You Don't Have Access to Perform This Action");
    }

    return $response = $next($request, $response);
};