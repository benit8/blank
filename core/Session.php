<?php

namespace Core;

class Session
{
	private function __construct()
	{}

	public static function init($vars)
	{
		if (session_status() == PHP_SESSION_ACTIVE)
			return true;

		session_start();

		foreach ($vars as $key => $value) {
			if (!isset($_SESSION[$key]))
				$_SESSION[$key] = $value;
		}
	}

	public static function get($var)
	{
		return isset($_SESSION[$var]) ? $_SESSION[$var] : false;
	}

	public static function set($var, $val)
	{
		$_SESSION[$var] = $val;
	}

	public static function delete($var)
	{
		if (isset($_SESSION[$var]))
			unset($_SESSION[$var]);
	}

	public static function isLoggedIn()
	{
		return !empty(Session::get('auth'));
	}

	public static function addFlash($type, $message)
	{
		switch ($type) {
			case 'success':
				$message = "<i class=\"fa fa-smile-o\"></i>&nbsp&nbsp" . $message;
			break;
			case 'info':
				$message = "<i class=\"fa fa-info-circle\"></i>&nbsp&nbsp" . $message;
			break;
			case 'warning':
				$message = "<i class=\"fa fa-frown-o\"></i>&nbsp&nbsp" . $message;
			break;
			case 'danger':
				$message = "<i class=\"fa fa-ban\"></i>&nbsp&nbsp" . $message;
			break;
			default:
				return false;
			break;
		}

		$_SESSION['flash'][$type][] = $message;
	}

	public static function renderFlash()
	{
		if (empty($_SESSION['flash']))
			return false;

		foreach ($_SESSION['flash'] as $type => $array) {
			echo "<div class=\"alert alert-dismissible alert-" . $type . "\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><ul>";
			foreach ($array as $k => $value)
				echo '<li>' . $value . '</li>';
			echo "</ul></div>";
		}

		$_SESSION['flash'] = [];
	}
}