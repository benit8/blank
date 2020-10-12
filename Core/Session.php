<?php

namespace Core;

class Session
{
	private function __construct()
	{}

	public static function init(array $vars = [])
	{
		if (session_status() == PHP_SESSION_ACTIVE)
			return true;

		if (!session_start())
			return false;

		$_SESSION = array_merge($_SESSION, $vars);
		if (!self::contains('flash'))
			self::set('flash', []);
		return true;
	}

	public static function contains(string $var): bool
	{
		return isset($_SESSION[$var]);
	}

	public static function get(string $var)
	{
		return $_SESSION[$var] ?? null;
	}

	public static function set(string $var, $val)
	{
		$_SESSION[$var] = $val;
	}

	public static function delete($var)
	{
		if (self::contains($var))
			unset($_SESSION[$var]);
	}

	public static function isLoggedIn()
	{
		return !empty(self::get('auth'));
	}

	public static function addFlash(string $type, $message)
	{
		if (!isset($_SESSION['flash'][$key]))
			$_SESSION['flash'][$key] = [];

		if (is_array($message))
			$_SESSION['flash'][$key] = array_merge($_SESSION['flash'][$key], $message);
		else
			$_SESSION['flash'][$key][] = $message;
	}

	public static function hasFlash(string $key = null): bool
	{
		return $key === null ? !empty($_SESSION['flash']) : !empty($_SESSION['flash'][$key]);
	}

	public static function dumpFlash(string $key, string $format = "<p>%s</p>")
	{
		if (!self::hasFlash($key))
			return;

		foreach ($_SESSION['flash'][$key] as $flash) {
			printf($format, $flash);
		}

		unset($_SESSION['flash'][$key]);
	}

	public static function dumpGlobalFlash()
	{
		$globalTypes = ['_error', '_warning', '_success', '_info'];

		foreach ($globalTypes as $type) {
			if (!self::hasFlash($type))
				continue;

			foreach ($_SESSION['flash'][$type] as $flash) {
				echo '<div class="flash ' . substr($type, 1) . '"><span>' . $flash . '</span></div>';
			}

			unset($_SESSION['flash'][$type]);
		}
	}
}