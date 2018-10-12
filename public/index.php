<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once(ROOT . "Core/Autoload.php");

///////////////////////////////////////////////////////////////////////////////


$app = new Core\App();

$app->get('/', []);

$app->run();
