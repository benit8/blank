<?php

class FormValidator
{
	private $vars;
	private $errors;

	public function __construct($vars)
	{
		$this->vars = $vars;
		$this->errors = [];
	}

	public function required(...$keys)
	{
		foreach ($keys as $key) {
			if (!isset($this->vars[$key]) || empty($this->vars[$key]))
				$this->setError($key, "field is empty.");
		}
	}

	public function equality($key1, $key2)
	{
		if ($this->vars[$key1] !== $this->vars[$key2])
			$this->setError($key1, "field must be identical to $key2 field.");
	}

	public function match($key, $pattern)
	{
		if (!preg_match($pattern, $this->vars[$key]))
			$this->setError($key, "field is invalid.");
	}

	public function email($key)
	{
		$this->vars[$key] = filter_var($this->vars[$key], FILTER_SANITIZE_EMAIL);
		if (!filter_var($this->vars[$key], FILTER_VALIDATE_EMAIL))
			$this->setError($key, "field is not a valid email address.");
	}

	public function integer($key, $min = null, $max = null)
	{
		if (!is_numeric($this->vars[$key]))
			$this->setError($key, "field is not a valid integer value.");

		$this->vars[$key] = intval($this->vars[$key]);

		if (!is_null($min) && $this->vars[$key] < $min)
			$this->setError($key, "field value must be superior to $min.");
		if (!is_null($max) && $this->vars[$key] > $max)
			$this->setError($key, "field value must be inferior to $max.");
	}

	public function password($key)
	{
		if (!preg_match("/^[a-z0-9!\"#$%]{8,16}$/i", $this->vars[$key]))
			$this->setError($key, "field must be between 8 and 16 characters long and may only contain letters, numbers and the following special characters: !\"#$%");
	}

	public function epur($key)
	{
		$this->vars[$key] = addslashes(htmlspecialchars(trim($this->vars[$key])));
	}


	public function isValid()
	{
		return empty($this->errors);
	}

	private function setError($key, $message)
	{
		$this->errors[] = ucfirst($key) . ' ' . $message;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getVars()
	{
		return $this->vars;
	}
}