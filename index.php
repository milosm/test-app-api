<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->contentType('application/json');

const STORAGE_NAME = "test-app-data";

session_start();

$app->get('/', function () {
	if (isset($_SESSION[STORAGE_NAME])) {
		echo json_encode($_SESSION[STORAGE_NAME]);
	} else {
		echo json_encode(array());
	}
});

$app->get('/list', function () {
	if (isset($_SESSION[STORAGE_NAME])) {
		echo json_encode($_SESSION[STORAGE_NAME]);
	} else {
		echo json_encode(array());
	}
});

$app->get('/list/:id', function ($id) {
	if (isset($_SESSION[STORAGE_NAME]) && array_key_exists($id, $_SESSION[STORAGE_NAME]) && !empty($_SESSION[STORAGE_NAME][$id])) {
		echo json_encode($_SESSION[STORAGE_NAME][$id]);
	} else {
		echo json_encode(array());
	}
});

$app->post('/list/add', function () use ($app) {
	$name         = $app->request()->post('name');
	$email        = $app->request()->post('email');
	$role         = $app->request()->post('role');
	$creationDate = new \DateTime("now", new \DateTimeZone("Europe/Ljubljana"));

	if (!empty($name) && !empty($email) && !empty($role)) {
		if (!array_key_exists(STORAGE_NAME, $_SESSION)) {
			$_SESSION[STORAGE_NAME] = array();
			$lastKey = 0;
		} else {
			if (empty($_SESSION[STORAGE_NAME])) {
				$lastKey = 0;
			} else {
				$lastKey = max(array_keys($_SESSION[STORAGE_NAME]));
			}
		}

		$newKey  = $lastKey + 1;

		$_SESSION[STORAGE_NAME][$newKey] = array(
			"id"           => $newKey,
			"name"         => $name,
			"email"        => $email,
			"role"         => $role,
			"creationDate" => $creationDate
		);

		echo json_encode(array(
			"success" => true,
			"id"      => $newKey
		));
	} else {
		echo json_encode(array(
			"success" => false
		));
	}
});

$app->put('/list/:id', function ($id) use ($app) {
	$name  = $app->request()->post('name');
	$email = $app->request()->post('email');
	$role  = $app->request()->post('role');

	if (!empty($name) &&
		!empty($email) &&
		!empty($role) &&
		array_key_exists(STORAGE_NAME, $_SESSION) &&
		array_key_exists($id, $_SESSION[STORAGE_NAME])
	) {

		$_SESSION[STORAGE_NAME][$id]['name']  = $name;
		$_SESSION[STORAGE_NAME][$id]['email'] = $email;
		$_SESSION[STORAGE_NAME][$id]['role']  = $role;

		echo json_encode(array(
			"success" => true,
			"id"      => $id
		));

	} else {
		echo json_encode(array(
			"success" => false
		));
	}
});

$app->delete('/list/:id', function ($id) {
	if (array_key_exists(STORAGE_NAME, $_SESSION) &&
		array_key_exists($id, $_SESSION[STORAGE_NAME])
	) {
		unset($_SESSION[STORAGE_NAME][$id]);

		echo json_encode(array(
			"success" => true
		));
	} else {
		echo json_encode(array(
			"success" => false
		));
	}
});

$app->run();
