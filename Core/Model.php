<?php

namespace Core;

class Model
{
	protected $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}


	protected function generateRandomToken(int $length = 32): string
	{
		$keySpace = '0123456789abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ';
		$max = strlen($keySpace);

		$token = '';
		for ($i = 0; $i < $length; $i++)
			$token .= $keySpace[random_int(0, $max - 1)];
		return $token;
	}
}