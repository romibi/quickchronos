<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use ch\romibi\quickchronos;

/* Api-routes */
$app->group('/api', function () use ($app, $chronos) {
	
})->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($app, $chronos) {
    // Use the PSR 7 $request object
    $chronos->setRequestObj($request);
    $chronos->setResponseObj($response);
    //ApiHelper::getInstance()->setAcceptType($request->getHeaders()['HTTP_ACCEPT'][0]);

    $response = $next($request, $response);
    
    //$response = ApiHelper::getInstance()->getUpdatedResponse($response);
    return $response;
});