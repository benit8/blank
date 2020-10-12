<?php

namespace Core;

class App
{
	private $router;

	const HTTP_METHODS = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

	public function __construct()
	{
		if (!Session::init())
			throw new Exception("Could not initialize session");

		$this->router = new Router();
	}

	public function __call($name, $arguments)
	{
		if (count($arguments) < 2)
			throw new Exception("Not enough arguments supplied");

		$ucName = strtoupper($name);

		if (in_array($ucName, self::HTTP_METHODS))
			$this->map([$ucName], $arguments[0], $arguments[1]);
	}

	public function any($pattern, $callback)
	{
		$this->map(self::HTTP_METHODS, $pattern, $callback);
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

	public static function redirect($url = '/')
	{
		header('Location: ' . $url);
		die;
	}
}