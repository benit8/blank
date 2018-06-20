<?php

class Error404 extends Controller
{
	public function __construct(){}

	public function index()
	{
		$this->render('index');
	}
}