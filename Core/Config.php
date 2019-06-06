<?php

namespace Core;

class Config
{
	private function __construct()
	{}

	const database = [
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => 'ascent',
		'name' => 'blank'
	];

	const site = [
		'title' => 'Blank',
		'lead' => "A website starter template",
		'desc' => "A little framework for starting new projects quickly",
		'url' => "blank.benito.io/"
	];
}