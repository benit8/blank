<?php

namespace Core;

class Controller
{
	protected $model;
	private $view;
	private $vars = [];
	private $files = ['styles' => [], 'scripts' => []];

	public function __construct()
	{}

	public function loadModel($model, ...$args)
	{
		require_once(ROOT . "App/Models/$model.php");

		$name = "\\App\\Models\\$model";
		$this->model = new $name(...$args);
	}

	public function setVars($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function loadStyles(array $files)
	{
		$this->files->styles = array_merge($this->files->styles, $files);
	}

	public function loadScripts(array $files)
	{
		$this->files->scripts = array_merge($this->files->scripts, $files);
	}

	public function render($filename, $layout = 'default')
	{
		$parts = explode('\\', get_class($this));

		$this->view = new View(end($parts), $layout);
		$this->passFilesToView();
		$this->view->setVars($this->vars);
		$this->view->render($filename);
	}

	private function passFilesToView()
	{
		foreach ($this->files as $fileType => $files) {
			foreach ($files as $file) {
				$file = ROOT . 'public/' . $fileType . '/' . $file;
			}
		}

		$this->view->setCustomFiles($this->files);
	}
}