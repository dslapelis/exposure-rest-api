<?php

require_once '../api/include/dbhandler.php';

$app->post('/api/v1/login', function($request, $response, $args) {
    
    $db = new DbHandler();
    $variables = $request->getParsedBody();
    $username = $variables['email'];
    $password = $variables['password'];
    
    if($db->login($username, $password))
    {
        $result = $db->getUserFromEmail($username);
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
    }
    else
    {
        return $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json');
    }
});

$app->post('/api/v1/register', function($request, $response, $args) {
    
    $db = new DbHandler();
    $variables = $request->getParsedBody();
    $username = $variables['email'];
    $password = $variables['password'];
    
    if($db->register($username, $password))
    {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json');
    }
    else
    {
        return $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json');
    }
});
?>