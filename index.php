<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

error_reporting(0);

$app = new \Slim\App;

// ip address
$app->get('/', function (Request $request, Response $response, array $args) {
    $data = array('ok'=>true);
    $response = $response->withJson($data);
    return $response;
});

// ip address
$app->get('/ip', function (Request $request, Response $response, array $args) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $data = array('ip'=>$ip, 'hostname'=>$hostname);
    $response = $response->withJson($data);
    return $response;
});

// check port
$app->get('/port/{port}', function (Request $request, Response $response, array $args) {
    $port = $args['port'];
    $port = intval($port);
    $ip = $_SERVER['REMOTE_ADDR'];
    $errno = 0;
    $errmsg = '';
    if ($socket = fsockopen($ip, $port, $errno, $errmsg, 1))
    {
        $data = array('port' => $port, 'open'=>true);
        fclose($socket);
    }
    else
    {
        $data = array('port' => $port, 'open'=>false);
    }
    $response = $response->withJson($data);
    return $response;
});

// ip address
$app->get('/useragent', function (Request $request, Response $response, array $args) {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $data = array('useragent'=>$useragent);
    $response = $response->withJson($data);
    return $response;
});

$app->run();
