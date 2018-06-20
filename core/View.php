<?php

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

		$__controller = $this->view;
		$__action     = ucfirst($filename);

		require_once(ROOT . 'views/layouts/' . $this->layout . '/header.php');
			SS::renderFlash();
		require_once(ROOT . 'views/' . $this->view . '/' . $filename . '.php');
		require_once(ROOT . 'views/layouts/' . $this->layout . '/footer.php');
	}
}