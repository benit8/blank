<?php

namespace App\Controllers;

class Error404 extends \Core\Controller
{
	public function __construct() {}

	public function index()
	{
		$this->render('index');
	}
}