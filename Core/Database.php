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
		$sth = $this->pdo->prepare($queryString);
		return $sth->execute($params) ? $sth->rowCount() : false;
	}

	public function fetch($queryString, ...$params)
	{
		$sth = $this->pdo->prepare($queryString);
		if ($sth->execute($params) === false)
			throw new Exception('\Core\Database::fetch() failed: ' . print_r($sth->errorInfo(), 1));

		return $sth->fetch();
	}

	public function fetchAll($queryString, ...$params)
	{
		$sth = $this->pdo->prepare($queryString);
		if ($sth->execute($params) === false)
			throw new Exception('\Core\Database::fetchAll() failed: ' . print_r($sth->errorInfo(), 1));

		return $sth->fetchAll();
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}