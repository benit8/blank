<?php

namespace Core;

class Controller
{
	private $vars = [];
	private $view;
	protected $model;

	public function __construct()
	{}

	public function loadModel($model)
	{
		require_once(ROOT . "App/Models/$model.php");

		$name = "\\App\\Models\\$model";
		$this->model = new $name();
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function render($filename, $layout = 'default')
	{
		$parts = explode('\\', get_class($this));
		$this->view = new View(end($parts), $layout);
		$this->view->setVars($this->vars);
		$this->view->render($filename);
	}
}