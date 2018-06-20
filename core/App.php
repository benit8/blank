<?php

class App
{
	private $parameters;
	private $controller;
	private $action;

	public function __construct()
	{
		$this->parseURL();

		if (!file_exists(ROOT . "controllers/" . $this->controller . ".php")) {
			$this->controller = "Error404";
			$this->action = 'index';
		}

		require_once(ROOT . "controllers/" . $this->controller . ".php");

		try {
			$this->controller = new $this->controller();

			if (method_exists($this->controller, $this->action))
				array_shift($this->parameters);
			else
				throw new Exception("404");
		}
		catch (Exception $e) {
			$this->notFound();
			return;
		}

		if (call_user_func_array([$this->controller, $this->action], $this->parameters) === false)
			$this->notFound();
	}

	private function parseURL()
	{
		$route = isset($_GET['route']) ? $_GET['route'] : "";
		$this->parameters = array_filter(explode('/', $route));

		$this->controller = !empty($this->parameters[0]) ? ucfirst($this->parameters[0]) : 'Index';
		$this->action = isset($this->parameters[1]) ? $this->parameters[1] : 'index';

		array_shift($this->parameters);
	}

	private function notFound()
	{
		require_once(ROOT . 'controllers/Error404.php');

		$c = new Error404();
		$c->index();
	}


	public static function debug($vars, $die = false)
	{
		echo '<pre>' . print_r($vars, true) . '</pre>';

		if ($die)
			die();
	}

	public static function redirect($url = '')
	{
		header("Location: " . WEBROOT . $url);
		die();
	}
}