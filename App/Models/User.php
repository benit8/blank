<?php

namespace App\Models;

class User extends \Core\Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUser($id)
	{
		return $this->db->fetchUnique("SELECT * FROM `users` WHERE `id` = ?", [$id]);
	}

	public function getEmail($id)
	{
		return $this->db->fetchUnique("SELECT `email` FROM `users` WHERE `id` = ?", [$id])->email;
	}
}