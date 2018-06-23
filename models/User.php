<?php

class UserModel extends Model
{
	public function __construct(){}

	public function getUser($id)
	{
		return Database::fetchUnique("SELECT * FROM `users` WHERE `id` = ?", [$id]);
	}

	public function getEmail($id)
	{
		return Database::fetchUnique("SELECT `email` FROM `users` WHERE `id` = ?", [$id])->email;
	}
}