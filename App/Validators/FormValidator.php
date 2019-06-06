<?php

namespace App\Validators;

class FormValidator
{
	private $vars;
	private $errors = [];

	public function __construct($vars)
	{
		$this->vars = $vars;
	}

	public function required(...$keys)
	{
		foreach ($keys as $key) {
			if (!isset($this->vars[$key]) || empty($this->vars[$key]))
				$this->setError("Field '$key' is required.");
		}
	}

	public function equality($key1, $key2)
	{
		if ($this->vars[$key1] !== $this->vars[$key2])
			$this->setError("Fields '$key1' and '$key2' must be identical.");
	}

	public function match($key, $pattern)
	{
		if (!preg_match($pattern, $this->vars[$key]))
			$this->setError("Field '$key' is invalid.");
	}

	public function email($key)
	{
		$this->vars[$key] = filter_var($this->vars[$key], FILTER_SANITIZE_EMAIL);
		if (!filter_var($this->vars[$key], FILTER_VALIDATE_EMAIL))
			$this->setError("Field '$key' is not a valid email address.");
	}

	public function integer($key, $min = null, $max = null)
	{
		if (!filter_var($this->vars[$key], FILTER_VALIDATE_INT))
			$this->addError("Field '$key' is not a valid integer value.");

		$this->vars[$key] = intval($this->vars[$key]);

		if (!is_null($min) && $this->vars[$key] < $min)
			$this->addError("Field '$key' value must be greater than $min.");
		if (!is_null($max) && $this->vars[$key] > $max)
			$this->addError("Field '$key' value must be less than $max.");
	}

	public function decimal($key, $min = null, $max = null)
	{
		if (!filter_var($this->vars[$key], FILTER_VALIDATE_FLOAT))
			$this->addError("Field '$key' is not a valid decimal value.");

		$this->vars[$key] = floatval($this->vars[$key]);

		if (!is_null($min) && $this->vars[$key] < $min)
			$this->addError("Field '$key' value must be greater than $min.");
		if (!is_null($max) && $this->vars[$key] > $max)
			$this->addError("Field '$key' value must be less than $max.");
	}

	public function boolean($key)
	{
		if (!filter_var($this->vars[$key], FILTER_VALIDATE_BOOLEAN))
			$this->addError("Field '$key' is not a valid boolean value.");

		$this->vars[$key] = boolval($this->vars[$key]);
	}

	public function date($key)
	{
		if (DateTime::createFromFormat('Y-m-d', $this->vars[$key]) === FALSE)
			$this->addError("Field '$key' is not a valid date.");
	}

	public function time($key)
	{
		if (DateTime::createFromFormat('H:i:s', $this->vars[$key]) === FALSE)
			$this->addError("Field '$key' is not a valid time.");
	}

	public function datetime($key)
	{
		if (DateTime::createFromFormat('Y-m-d H:i:s', $this->vars[$key]) === FALSE)
			$this->addError("Field '$key' is not a valid datetime.");
	}

	public function password($key)
	{
		if (!preg_match("/^[a-z0-9!\"#$%]{8,16}$/i", $this->vars[$key]))
			$this->setError("Password field '$key' must be between 8 and 16 characters long and may only contain letters, numbers and the following special characters: !\"#$%");
		else
			$this->vars[$key] = hash('sha256', $this->vars[$key]);
	}

	public function epur($key)
	{
		$this->vars[$key] = addslashes(htmlspecialchars(trim($this->vars[$key])));
	}


	public function isValid()
	{
		return empty($this->errors);
	}

	public function getVars()
	{
		return $this->vars;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	private function setError($err)
	{
		$this->errors[] = $err;
	}
}