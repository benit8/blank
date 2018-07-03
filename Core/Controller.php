<?php

namespace Core;

class Controller
{
	protected $model;
	private $view;
	private $vars = [];
	private $files = [];

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

	public function loadFile($file)
	{
		if (is_array($file))
			$this->files = array_merge($this->files, $file);
		else
			$this->files = array_merge($this->files, [$file]);
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
		foreach ($this->files as $file) {
			$filepath = ROOT . "public/$file";
			$ext = pathinfo($filepath, PATHINFO_EXTENSION);
			switch ($ext) {
				case 'css':
					$this->view->loadStyle($file);
					break;
				case 'js':
					$this->view->loadScript($file);
					break;
				default:
					break;
			}
		}
	}
}