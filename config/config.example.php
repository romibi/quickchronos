<?php
return array(
	'slim' => array(
		'settings' => [
		'displayErrorDetails' => true,
		],
		'templates.path' => __DIR__ . '/../templates',
		'log.level' => 4,
		'log.enabled' => true,
		'log.writer' => new Slim\Logger\DateTimeFileWriter(
			array(
				'path' => __DIR__ . '/../logs',
				'name_format' => 'y-m-d'
			)
		)
	),
	'twig' => array(
			//'charset' => 'utf-8',
			//'cache' => __DIR__ . '/../templates/cache',
			'cache' => false,
			//'auto_reload' => false,
			//'strict_variables' => true,
			//'autoescape' => true,
			'debug' => true,
	),
	'db' => array(
		'driver'   => 'pdo_sqlite',
		'path'   => __DIR__ . '/../data/chronos-storage.sqlite'
	),
	'custom' => array(
		'isDevMode' => true
	)
);