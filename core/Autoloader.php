<?php


spl_autoload_register(function($class) {
	$autoload_directories = [
		'core',
		'controllers',
		'models',
		'views'
	];

	foreach ($autoload_directories as $dir) {
		$filename = ROOT . $dir . '/' . $class . '.php';
		if (file_exists($filename)) {
			require_once($filename);
			break;
		}
	}
});