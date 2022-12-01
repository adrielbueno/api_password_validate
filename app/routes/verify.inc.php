<?php


use App\Controller\VerifyController;
use App\Core\Handlers\Request\RequestHandler as Request;
use App\Core\Handlers\Router\Router;

$router = Router::getInstance();

$router->post('/verify', fn (Request $request) => (new VerifyController())->teste($request->getJson()));
