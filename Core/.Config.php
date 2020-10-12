<?php

namespace Core;

class Config
{
	private function __construct()
	{}

	public static function database()
	{
		return (object) [
			'host' => getenv('DB_HOST')     ?: '127.0.0.1',
			'user' => getenv('DB_USERNAME') ?: 'root',
			'pass' => getenv('DB_PASSWORD') ?: 'ascent',
			'name' => getenv('DB_DATABASE') ?: 'blank'
		];
	}

	public static function site()
	{
		return (object) [
			'title' => 'Blank',
			'lead'  => 'A website starter template',
			'desc'  => 'A little framework for starting new projects quickly',
			'url'   => 'http://blank'
		];
	}
}