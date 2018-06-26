<?php

namespace App\Controllers;

class Index extends \Core\Controller
{
	public function __construct()
	{}

	public function index()
	{
		$this->render('index');
	}
}