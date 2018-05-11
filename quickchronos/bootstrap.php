<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../configs/config.php';

 
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use ch\romibi\quickchronos\QuickChronos;

// App setup
$paths = array(__DIR__ . "/entities");
$isDevMode = $config['custom']['isDevMode'];

// the connection configuration
$dbParams = $config['db'];
 
$dbconfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
if($isDevMode) {
	$dbconfig->setAutoGenerateProxyClasses(\Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_EVAL);
}
$entityManager = EntityManager::create($dbParams, $dbconfig);

require_once 'quickchronos.php';

$chronos = QuickChronos::getInstance();
$chronos->setBaseConfig($config);
$chronos->setEntityManager($entityManager);