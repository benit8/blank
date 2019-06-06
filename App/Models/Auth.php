<?php

namespace App\Models;

use \App\Validators\FormValidator;
use \Core\Database;
use \Core\Session;

class Auth extends \Core\Model
{
	private $errors = [];

	public function __construct()
	{
		parent::__construct();
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

			$record = $this->db->fetch("SELECT * FROM `users` WHERE `email` = ?", $data['email']);
			if ($record) {
				$this->addError("This email address is already registered.");
				return false;
			}

			$insertion = $this->db->query(
				"INSERT INTO `users` (`email`, `password`) VALUES (?, ?)",
				$data['email'], $data['password']
			);
			$loggin = $this->db->query(
				"INSERT INTO `logs` VALUES (NOW(), ?, 'registration', ?)",
				$this->db->lastInsertId(), ""/* TODO: Random token */
			);

			if ($insertion === false || $loggin === false) {
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

			$record = $this->db->fetch("SELECT * FROM `users` WHERE `email` = ?", $data['email']);
			if (!$record) {
				$this->addError("This email address is not registered.");
				return false;
			}
			else if ($record->password !== $data['password']) {
				$this->addError("Invalid login informations.");
				return false;
			}
			else if ($record->confirmed === '0') {
				$this->addError("You must confirm your account before loggin in.");
				return false;
			}
			else {
				$this->db->query("
					INSERT INTO `logs` VALUES (NOW(), ?, 'login', ?)",
					$record->id, $_SERVER['REMOTE_ADDR']
				);

				Session::set('auth', $record);
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
		if (is_array($error))
			$this->errors = array_merge($this->errors, $error);
		else
			$this->errors[] = strval($error);
	}
}