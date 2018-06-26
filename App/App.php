<?php

namespace App;

use \Core\Session;
use \Core\Router;

class App
{
	private $router;

	private static $httpMethods = [
		'GET',
		'HEAD',
		'POST',
		'PUT',
		'PATCH',
		'DELETE',
		'OPTIONS'
	];

	public function __construct()
	{
		Session::init();

		$this->router = new Router();
	}

	public function __call($name, $arguments)
	{
		if (count($arguments) < 2)
			throw new Exception("Not enough arguments supplied");

		$ucName = strtoupper($name);

		if (in_array($ucName, self::$httpMethods))
			$this->map([$ucName], $arguments[0], $arguments[1]);
	}

	public function any($pattern, $callback)
	{
		$this->map(self::$httpMethods, $pattern, $callback);
	}

	public function map(array $methods, $pattern, $callback)
	{
		$this->router->map($methods, $pattern, $callback);
	}

	public function run()
	{
		$this->router->dispatch();
	}

	public static function debug($vars, $die = false)
	{
		echo '<pre>' . print_r($vars, true) . '</pre>';

		if ($die)
			die;
	}

	public static function redirect($url = '')
	{
		header("Location: " . WEBROOT . $url);
		die;
	}
}