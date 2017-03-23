<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

require_once '../api/v1/auth_functions.php';
require_once '../api/include/dbhandler.php';

$app->run();