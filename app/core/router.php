<?php
	namespace vl\app\core;

	class router
	{
		// Массив с подготовленными запросами
		private $routes;

		// Название контроллера
		private $controller = 'siteController';

		// Название метода
		private $method = 'indexAction';

		// Параметры
		private $params = [];

		public function __construct()
		{
			// Подключение массива с подготовленными запросами
			$routes = require_once '../app/config/routes.php';
			$this->routes = $routes;
		}

		public function run()
		{
			// Получение отредактированного URI
			$uri = $this->uri();

				// Перебор и проверка запроса с URI и заготовленных запросов
				foreach ($this->routes as $key => $pattern) {
					if ($uri[0] === $key) {
						// Присваиваем свойству значения
						$pattern = explode('/', $pattern);
						$this->controller = $pattern[0].'Controller';
						$this->method = $pattern[1].'Action';
						// Удаление всего лишнего из запроса URI
						unset($uri[0]);
						break;
					}
				}

			// Подключение файл контроллера
			require_once '../app/controllers/' . $this->controller . '.php';
			// Создание объекта контроллера
			$this->controller = new $this->controller();

			// Возвращает параметры
			$this->param = (!empty($uri)) ? $uri : [];

			call_user_func_array([$this->controller, $this->method], $this->param);

		}

		public function uri()
		{
			// Проверка на существование URI и редактирование

				return explode('/', rtrim(filter_var(($_GET['uri'] ?? ''), FILTER_SANITIZE_URL), '/'));

		}

	}
