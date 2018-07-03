<?php

namespace Core;

class View
{
	private $view;
	private $layout;
	private $vars = [];
	private $files = [
		'styles' => [],
		'scripts' => []
	];

	public function __construct($controllerName, $layout = 'default')
	{
		$this->view = $controllerName;
		$this->layout = $layout;
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function loadStyle($style)
	{
		$this->files['styles'][] = WEBROOT . $style;
	}

	public function loadScript($script)
	{
		$this->files['scripts'][] = WEBROOT . $script;
	}

	public function render($filename)
	{
		$_controller = $this->view;
		$_action = ucfirst($filename);

		extract($this->vars);
		extract($this->files);

		require_once(ROOT . 'App/Views/layouts/' . $this->layout . '/header.php');
		Session::renderFlash();
		require_once(ROOT . 'App/Views/' . $this->view . '/' . $filename . '.php');
		require_once(ROOT . 'App/Views/layouts/' . $this->layout . '/footer.php');
	}
}