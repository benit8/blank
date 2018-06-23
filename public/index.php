<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));


require_once(ROOT . "config/config.php");
require_once(ROOT . "core/Autoloader.php");


Database::set(DB_HOST, DB_USER, DB_PASS, DB_NAME);
Session::init(['flash' => []]);


$app = new App();
$app->run();