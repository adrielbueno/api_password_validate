<?php

$request = App\Core\Handlers\Request\RequestHandler::getInstance();

$json = file_get_contents('php://input');

if ($request->getMethod() === 'GET') {
    $json = json_encode($_GET);
}

$header = $request->getLowerCaseHeader();

$requisicao = substr($_GET['url'], -1) === '/'
    ? '/' . $_GET['url'] . $_SERVER['REQUEST_METHOD']
    : '/' . $_GET['url'] . '/' . $_SERVER['REQUEST_METHOD'];
