<?php

namespace Core;

class Route
{
	private $controller = null;
	private $action = null;

	public function __construct(array $callable)
	{
		$this->controller = "\\App\\Controllers\\" . ($callable[0] ?? 'Index');
		$this->action = $callable[1] ?? 'index';
	}

	public function run(array $parameters)
	{
		if (!class_exists($this->controller))
			return false;

		$controller = new $this->controller;

		if (!method_exists($controller, $this->action))
			return false;

		return call_user_func_array([$controller, $this->action], $parameters) ?? true;
	}
}