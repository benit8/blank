<?php

namespace Core;

use \App\Controllers\Error404;

class Router
{
	private $routes = [];

	public function __construct()
	{}

	public function map(array $methods, string $pattern, array $callable)
	{
		foreach ($methods as $method) {
			$method = strtoupper($method);
			$route = new Route($callable);

			$this->routes[$method][$pattern] = $route;
		}
	}

	public function dispatch()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$method = $_SERVER['REQUEST_METHOD'];

		if (!isset($this->routes[$method]))
			$this->notFound();

		$uriPath = parse_url($uri, PHP_URL_PATH);
		$uriPath = '/' . ltrim($uriPath, '/');

		foreach ($this->routes[$method] as $pattern => $route) {
			$pattern = '#^' . $pattern . '$#';
			if (preg_match($pattern, $uriPath, $parameters)) {
				array_shift($parameters);
				return $route->run($parameters);
			}
		}

		$this->notFound();
	}

	private function notFound()
	{
		header("HTTP/1.0 404 Not Found");
		(new Error404())->index();
		die;
	}
}