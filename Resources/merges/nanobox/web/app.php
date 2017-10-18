<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$env = $_ENV['SYMFONY_ENV'] ?? 'dev';
$debug = in_array($env, ['dev', 'test']);
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
if ($debug) {
    Debug::enable();
}

$kernel = new AppKernel($env, $debug);
$request = Request::createFromGlobals();
Request::setTrustedProxies(['127.0.0.1', $request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_ALL);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
