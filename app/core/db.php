<?php

	namespace vl\app\core;

	/**
	* DB CONNECT (PDO)
	*/

	class db
	{
		
		public static function getConnection()
		{
			$params = require_once '../app/config/db_params.php';

			$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
			$db = new \PDO($dsn, $params['user'], $params['password']);
        	$db->exec("set names utf8");
        	
			return $db;
		}
	}