<?php

namespace Core;

class View
{
	private $view;
	private $layout;
	private $vars = [];
	private $files = [];

	public function __construct($controllerName, $layout = 'default')
	{
		$this->view = $controllerName;
		$this->layout = $layout;
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function setCustomFiles(array $files)
	{
		$this->files = $files;
	}

	public function render($filename)
	{
		$_controller = $this->view;
		$_action = ucfirst($filename);

		extract($this->vars);
		extract($this->files);

		require(ROOT . 'App/Views/layouts/' . $this->layout . '/header.php');
		Session::renderFlash();
		require(ROOT . 'App/Views/' . $this->view . '/' . $filename . '.php');
		require(ROOT . 'App/Views/layouts/' . $this->layout . '/footer.php');
	}
}