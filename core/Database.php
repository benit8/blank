<?php

class Database
{
	private static $pdo;

	private function __construct()
	{}

	public static function set($host, $user, $pass, $dbname)
	{
		try {
			self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch (\PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function query($queryString, $params = null)
	{
		if ($params == null)
			$query = self::$pdo->query($queryString);
		else {
			$query = self::$pdo->prepare($queryString);
			$query->execute($params);
		}

		return $query;
	}

	public static function fetch($queryString, $params = null)
	{
		if ($params == null)
			$query = self::$pdo->query($queryString);
		else {
			$query = self::$pdo->prepare($queryString);
			$query->execute($params);
		}

		$result = [];
		while ($r = $query->fetch())
			$result[] = $r;

		return $result;
	}

	public static function fetchUnique($queryString, $params = null)
	{
		if ($params == null)
			$query = self::$pdo->query($queryString);
		else {
			$query = self::$pdo->prepare($queryString);
			$query->execute($params);
		}

		$result = $query->fetch();
		return $result ? $result : false;
	}

	public static function lastID()
	{
		return self::$pdo->lastInsertId();
	}
}