<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

http_response_code(500);

(function () {
    $app = new App([
        'settings' => [
            'addContentLengthHeader' => false,
            'displayErrorDetails' => (bool)getenv('APP_DEBUG'),
        ],
    ]);
    $app->get('/', function (Request $request, Response $response) {
        return $response->withJson([
            'name' => 'Manager',
            'param' => $request->getQueryParam('param'),
        ]);
    });
    $app->run();
})();
