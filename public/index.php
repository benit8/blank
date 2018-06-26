<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT',    str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once(ROOT . "core/Autoload.php");

///////////////////////////////////////////////////////////////////////////////

\Core\Session::init();

$app = new \App\App();
$app->run();