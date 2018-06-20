<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));


require_once(ROOT . "config/config.php");

require_once(ROOT . "core/App.php");
require_once(ROOT . "core/Session.php");
require_once(ROOT . "core/Database.php");
require_once(ROOT . "core/Controller.php");
require_once(ROOT . "core/Model.php");
require_once(ROOT . "core/View.php");
require_once(ROOT . "core/FormValidator.php");


DB::set(DB_HOST, DB_USER, DB_PASS, DB_NAME);
SS::init(['flash' => []]);


$app = new App();