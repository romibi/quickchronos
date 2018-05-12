<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use ch\romibi\quickchronos;

$app->group('', function () use ($app, $chronos) {
	$app->get('/', function ($request, $response) use ($chronos) {
		$this->view->render($response, 'index.twig');
	});
	$app->group('/project', function () use ($app, $chronos) {
		$app->get('/{projectId}[/{action:(?:start|stop|trigger)}]', function ($request, $response, $args) use ($chronos) {
			$project = $chronos->project()->get($args['projectId']);
			if(!isset($args['action'])) {
				$args['action']=null;
			}
			$this->view->render($response, 'project.twig', array('project'=>$project, 'projectId'=>$args['projectId'], 'action'=>$args['action']));
		});
	});
})->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($app, $chronos) {
    // Use the PSR 7 $request object
    $chronos->setRequestObj($request);
    $chronos->setResponseObj($response);

    $this->get('view')->getEnvironment()->addGlobal('user', $chronos->getUser());

	return $next($request, $response);
});