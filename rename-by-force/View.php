<?php

namespace Core;

class View
{
	private $view;
	private $layout;
	private $vars = [];

	public function __construct($controllerName, $layout = 'default')
	{
		$this->view = $controllerName;
		$this->layout = $layout;
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function render($filename)
	{
		extract($this->vars);

		$_controller = $this->view;
		$_action = ucfirst($filename);

		require_once(ROOT . 'App/Views/layouts/' . $this->layout . '/header.php');
		Session::renderFlash();
		require_once(ROOT . 'App/Views/' . $this->view . '/' . $filename . '.php');
		require_once(ROOT . 'App/Views/layouts/' . $this->layout . '/footer.php');
	}
}