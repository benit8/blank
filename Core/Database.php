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
		if (!isset(self::$_instance))
			self::$_instance = new Database();
		return self::$_instance;
	}


	public function query($queryString, ...$params)
	{
		if (empty($params))
			$query = $this->pdo->query($queryString);
		else {
			$query = $this->pdo->prepare($queryString);
			$query->execute($params);
		}

		return $query;
	}

	public function fetch($queryString, ...$params)
	{
		if (empty($params))
			$query = $this->pdo->query($queryString);
		else {
			$query = $this->pdo->prepare($queryString);
			$query->execute($params);
		}

		$result = $query->fetch();
		return $result ?: false;
	}

	public function fetchAll($queryString, ...$params)
	{
		if (empty($params))
			$query = $this->pdo->query($queryString);
		else {
			$query = $this->pdo->prepare($queryString);
			$query->execute($params);
		}

		return $query->fetchAll();
	}

	public function getLastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}