<?php

class Auth extends Controller
{
	public function __construct(){}

	public function index()
	{
		App::redirect(SS::isLoggedIn() ? "" : "auth/login");
	}

	public function login()
	{
		if (SS::isLoggedIn())
			App::redirect();

		$invalid = false;

		if (!empty($_POST)) {
			$this->loadModel('Auth');

			if (!$this->model->login()) {
				$invalid = true;
				$errors = $this->model->getErrors();

				foreach ($errors as $e)
					SS::addFlash('danger', $e);
			}
			else {
				App::redirect();
			}
		}

		$this->setVars(["invalid" => $invalid]);
		$this->render('login');
	}

	public function register()
	{
		if (SS::isLoggedIn())
			App::redirect();

		$invalid = false;

		if (!empty($_POST)) {
			$this->loadModel('Auth');

			if (!$this->model->register()) {
				$invalid = true;
				$errors = $this->model->getErrors();

				foreach ($errors as $e)
					SS::addFlash('danger', $e);
			}
			else {
				SS::addFlash('success', "Registration successful.");
				App::redirect();
			}
		}

		$this->setVars(["invalid" => $invalid]);
		$this->render('register');
	}

	public function logout()
	{
		SS::delete('auth');
		App::redirect();
	}
}