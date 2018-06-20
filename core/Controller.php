<?php

class Controller
{
	private $vars = [];
	private $view;
	protected $model;

	public function __construct(){}

	public function loadModel($model)
	{
		require_once(ROOT . "models/$model.php");

		$name = $model . 'Model';
		$this->model = new $name();
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function render($filename, $layout = 'default')
	{
		$this->view = new View(get_class($this), $layout);
		$this->view->setVars($this->vars);
		$this->view->render($filename);
	}
}