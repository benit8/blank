<?php

namespace App;

use Controllers\Error404;
use \Core\Session;

class App
{
	private $parameters;
	private $controller;
	private $action;

	public function __construct()
	{
		$this->parseURL();
	}

	public function run()
	{
		if (class_exists($this->controller))
			$this->controller = new $this->controller;
		else
			$this->notFound();

		if (method_exists($this->controller, $this->action))
			array_shift($this->parameters);
		else
			$this->notFound();

		if (call_user_func_array([$this->controller, $this->action], $this->parameters) === false)
			$this->notFound();
	}

	private function parseURL()
	{
		$route = $_GET['route'] ?? "";
		$this->parameters = array_filter(explode('/', $route));

		$this->controller = !empty($this->parameters[0]) ? ucfirst($this->parameters[0]) : 'Index';
		$this->action = $this->parameters[1] ?? 'index';

		$this->controller = "\\App\\Controllers\\$this->controller";

		array_shift($this->parameters);
	}

	private function notFound()
	{
		$c = new Error404();
		$c->index();
		die;
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