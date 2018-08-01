<?php
	
	session_start();

	// Вывод ошибок
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	// Константа (защита init.php)
	define('INIT', 1);

	// Подключение init.php
	require_once '../app/init.php';