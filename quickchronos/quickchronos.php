<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;

//require_once 'entities/something.php';

//require_once 'controllers/somethingController.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Dflydev\FigCookies\Cookies;
use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;


class QuickChronos {
	private static $instances = array();
	protected $app;
	protected $request;
	protected $response;
	protected $entityManager;
	protected $controllers;
	protected $web;
	protected $initialized = false;
	protected $config = array();

	private function __construct() {
		//$this->web = new WebController();
		$this->tryInitialize();
	}

	public static function getInstance($key='') {
		if(isset(self::$instances[$key])) {
			return self::$instances[$key];
		}
		self::$instances[$key] = new QuickChronos();
		return self::$instances[$key];
	}

	public function setSlimAppObj($app) {
		$this->app = $app;
		$this->tryInitialize();
	}

	public function setBaseConfig($config) {
		$this->config = $config;
	}

	public function setEntityManager($entityManager) {
		$this->entityManager = $entityManager;
		$this->tryInitialize();
	}

	public function setRequestObj($req) {
		$this->request = $req;
		$this->tryInitialize();
	}

	public function setResponseObj($resp) {
		$this->response = $resp;
		$this->tryInitialize();
	}

	public function getBaseConfig() {
		return $this->config;
	}

	public function getCookie($key, $default=null) {
		if($default==null)
			return FigRequestCookies::get($this->request, $key)->getValue();
		else
			return FigRequestCookies::get($this->request, $key, $default)->getValue();
	}

	public function setCookie($key, $value, $expiration=null) {
		$cookie =  SetCookie::create($key)
						->withValue($value)
						->withPath('/');
		if($expiration==null) {
			$cookie = $cookie->rememberForever();
		} else {
			$cookie = $cookie->withExpires($expiration);
		}
		$response = FigResponseCookies::set($this->response, $cookie);
		$this->setResponseObj($response);
		return $response;
	}

	private function tryInitialize() {
		if($this->initialized) return;
		if(isset($this->app) && isset($this->request) && isset($this->response) && isset($this->entityManager)) {
			$this->initialize();
		}
	}

	private function initialize() {
		//$this->controllers['something'] = new seomethingController($this->entityManager);
		
		$this->initialized = true;
	}

	public function web() {
		return $this->web;
	}

	public function __call($name, $args) {
		if(!$this->initialized) { throw new \Exception('QuickChronos isn\'t finished initializing...'); }
		return $this->controllers[$name];
	}
}

class EntityChangedException extends \Exception {}