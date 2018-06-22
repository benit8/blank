<?php

class AuthModel extends Model
{
	private $errors;


	public function __construct()
	{
		$this->errors = [];
	}

	public function register()
	{
		$fv = new FormValidator($_POST);
		$fv->required('email', 'password', 'password2');
		$fv->email('email');
		$fv->equality('password', 'password2');
		$fv->password('password');
		$fv->password('password2');

		if (!$fv->isValid()) {
			$this->addError($fv->getErrors());
			return false;
		}
		else {
			$data = $fv->getVars();
			$exists = DB::fetchUnique(
				"SELECT * FROM `users` WHERE email = ?",
				[$data['email']]
			);

			if ($exists) {
				$this->addError("This email address is already registered.");
				return false;
			}

			$insert = DB::query(
				"INSERT INTO `users` VALUES (null, ?, ?, NOW(), null, null, 0)",
				[$data['email'], $data['password']]
			);

			if ($insert) {
				$this->addError("Database error.");
				return false;
			}

			return true;
		}
	}

	public function login()
	{
		$fv = new FormValidator($_POST);
		$fv->required('email', 'password');
		$fv->email('email');
		$fv->password('password');

		if (!$fv->isValid()) {
			$this->addError($fv->getErrors());
			return false;
		}
		else {
			$data = $fv->getVars();
			$fetch = DB::fetchUnique("SELECT * FROM `users` WHERE `email` = ?", [$data['email']]);

			if (!$fetch) {
				$this->addError("This email address is not registered.");
				return false;
			}
			else if ($fetch->password != $data['password']) {
				$this->addError("Invalid login informations.");
				return false;
			}
			else if ($fetch->confirmed == null) {
				$this->addError("You must confirm your account before loggin in.");
				return false;
			}
			else {
				DB::query("UPDATE `users` SET `last_login` = NOW() WHERE `id` = ?", [$fetch->id]);

				Session::set('auth', $fetch);
				return true;
			}
		}
	}


	public function getErrors()
	{
		return $this->errors;
	}

	private function addError($error)
	{
		if (gettype($error) === "array")
			$this->errors = array_merge($this->errors, $error);
		else
			$this->errors[] = strval($error);
	}
}