<?php
	namespace vl\app\core;
	
	class controller
	{
		
		// Подключение файла с View
		public function view($nameView, $data = [])
		{
			require_once '../app/views/' . $nameView . '.php';
		}
	}