<?php
	if (!defined('INIT')) {
		die;
	}

	// Подключение autoload
	require_once '../vendor/autoload.php';

	// Подключение класса роутера
	//require_once '../app/core/router.php';

	// Подключение класса контролера
	//require_once '../app/core/controller.php';

	// Создание объекта роутера
	$router = new vl\app\core\router();

	$run = $router->run();
