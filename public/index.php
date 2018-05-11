<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
require '../vendor/autoload.php';
require_once '../quickchronos/bootstrap.php';

$config = $chronos->getBaseConfig();

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use ch\romibi\QuickChronos;

$app = new \Slim\App($config['slim']);

$container = $app->getContainer();
$container['view'] = function ($container) use ($config) {
    $view = new \Slim\Views\Twig($config['slim']['templates.path'], $config['twig']);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    
    return $view;
};

$chronos->setSlimAppObj($app);

/* Routes */
require '../quickchronos/routes/api.php';
require '../quickchronos/routes/web.php';
$app->run();
