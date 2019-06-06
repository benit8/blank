<!DOCTYPE html>
<html>
	<head>
		<title><?= \Core\Config::site['title'] ?></title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/images/favicon.ico"/>

		<meta property="og:type" content="website">
		<meta property="og:title" content="<?= \Core\Config::site['title'] ?> - <?= \Core\Config::site['lead'] ?>">
		<meta property="og:site_name" content="<?= \Core\Config::site['title'] ?>">
		<meta property="og:description" content="<?= \Core\Config::site['desc'] ?>">
		<meta property="og:image" content="/images/og.png">
		<meta property="og:url" content="<?= \Core\Config::site['url'] ?>">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha256-eSi1q2PG6J7g7ib17yAaWMcrr5GrtohYChqibrV7PBE=" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
		<link rel="stylesheet" href="/styles/bs-overrides.css">
		<link rel="stylesheet" href="/styles/default.css">
		<?php foreach ($styles as $s) echo "<link rel=\"stylesheet\" href=\"$s\">"; ?>
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="/"><?= \Core\Config::site['title'] ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav mr-auto"></ul>
				<ul class="navbar-nav ml-auto">
					<?php if (!\Core\Session::isLoggedIn()): ?>
						<li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
						<li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
					<?php else: ?>
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">(You)</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="/logout">Logout</a>
							</div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>

		<main role="main" class="container">