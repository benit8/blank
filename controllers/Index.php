<?php

class Index extends Controller
{
	public function __construct(){}

	public function index()
	{
		$this->render('index');
	}
}