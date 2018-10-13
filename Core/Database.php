<?php

namespace Core;

use PDO;

class Database
{
	private static $_instance = null;
	private $pdo;

	private function __construct()
	{
		try {
			$this->pdo = new PDO(
				"mysql:host=" . Config::database['host'] . ";dbname=" . Config::database['name'],
				Config::database['user'], Config::database['pass'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance()
	{
		if (self::$_instance === null)
			self::$_instance = new Database();
		return self::$_instance;
	}


	public function query($queryString, ...$params)
	{
		if (empty($params))
			$ret = $this->pdo->query($queryString);
		else {
			$query = $this->pdo->prepare($queryString);
			$ret = $query->execute($params);
		}

		return $ret;
	}

	public function fetch($queryString, ...$params)
	{
		if (empty($params)) {
			$stmt = $this->pdo->query($queryString);
			if ($stmt === false)
				return false;
		}
		else {
			$stmt = $this->pdo->prepare($queryString);
			if (!$stmt->execute($params))
				return false;
		}

		$result = $stmt->fetch();
		return $result ?: false;
	}

	public function fetchAll($queryString, ...$params)
	{
		if (empty($params)) {
			$stmt = $this->pdo->query($queryString);
			if ($stmt === false)
				return false;
		}
		else {
			$stmt = $this->pdo->prepare($queryString);
			if (!$stmt->execute($params))
				return false;
		}

		return $stmt->fetchAll();
	}

	public function getLastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}