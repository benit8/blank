<!DOCTYPE html>
<html>
	<head>
		<title><?= \Core\Config::site['title'] ?></title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta property="og:type" content="website">
		<meta property="og:title" content="<?= \Core\Config::site['title'] ?> - <?= \Core\Config::site['lead'] ?>">
		<meta property="og:site_name" content="<?= \Core\Config::site['title'] ?>">
		<meta property="og:description" content="<?= \Core\Config::site['desc'] ?>">
		<meta property="og:image" content="<?= WEBROOT ?>images/og.png">
		<meta property="og:url" content="<?= \Core\Config::site['url'] ?>">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= WEBROOT ?>css/default.css">
		<link rel="icon" href="<?= WEBROOT ?>images/favicon.ico"/>
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="<?= WEBROOT ?>"><?= \Core\Config::site['title'] ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item"><a class="nav-link" href="<?= WEBROOT ?>">Home</a></li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<?php if (!\Core\Session::isLoggedIn()): ?>
						<li class="nav-item"><a class="nav-link" href="<?= WEBROOT ?>auth/login">Login</a></li>
						<li class="nav-item"><a class="nav-link" href="<?= WEBROOT ?>auth/register">Register</a></li>
					<?php else: ?>
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">(You)</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="<?= WEBROOT ?>auth/logout">Logout</a>
							</div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>

		<main role="main">
			<div class="container">