<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use ch\romibi\quickchronos;

$app->group('', function () use ($app, $chronos, $container) {
	$app->get('/', function ($request, $response) use ($app, $chronos, $container) {
		$container['view']->render($response, 'index.twig');
	});
})->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($app, $chronos) {
    // Use the PSR 7 $request object
    $chronos->setRequestObj($request);
    $chronos->setResponseObj($response);

	return $next($request, $response);
});