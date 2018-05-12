<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use ch\romibi\quickchronos;

/* Api-routes */
$app->group('/api', function () use ($app, $chronos) {
	$app->post('/user', function ($request, $response) use ($chronos) {
		$chronos->user()->post($request->getParsedBody());
	});
	$app->map(['GET', 'PATCH', 'DELETE'], '/user/{id}', function ($request, $response, $args) use ($chronos) {
		if ($request->isGet()) {
			echo $chronos->user()->find($args['id']);
		}
	});

	$app->group('/project', function() use ($app, $chronos) {
		$app->map(['GET', 'PUT', 'PATCH', 'DELETE'], '/{id}', function($request, $response, $args) use ($chronos) {
			if ($request->isPut()) {
				$chronos->project()->put($args['id'], $request->getParsedBody());
			}
		});

		$app->put('/{id}/{action:(?:start|stop|trigger)}', function($request, $response, $args) use ($chronos) {
			$userId = $request->getParsedBody()['user']['id'];
			$user = $chronos->user()->find($userId);
			$activeProject = $user->getActiveProject();
			$project = $chronos->project()->get($args['id']);

			if($args['action'] == "trigger" || $args['action']=="start") {
				if($activeProject!=null && $activeProject!=$project)  {
					$chronos->project()->stop($user);
				}

				echo $chronos->project()->start($user, $project);
			}
			if($args['action'] == "stop") {
				echo $chronos->project()->stop($user);
			}
		});
	});
})->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($app, $chronos) {
    // Use the PSR 7 $request object
    $chronos->setRequestObj($request);
    $chronos->setResponseObj($response);
    //ApiHelper::getInstance()->setAcceptType($request->getHeaders()['HTTP_ACCEPT'][0]);

    $response = $next($request, $response);
    
    //$response = ApiHelper::getInstance()->getUpdatedResponse($response);
    return $response;
});