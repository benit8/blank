<?php

spl_autoload_register(function($class) {
	$filename = ROOT . str_replace('\\', '/', $class) . ".php";
	if (file_exists($filename))
		require_once($filename);
});