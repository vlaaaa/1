<?php

	/**
	 *  Class site
	 */

	class siteController extends vl\app\core\controller
	{
		public function indexAction()
		{
			$checkAuth = vl\app\models\site::checkAuth();
			if($checkAuth){
				header("Location: /login");
			}
			// Подключение view
			$this->view('main/index', []);
		}

		public function loginAction($type = 1)
		{
			$checkAuth = vl\app\models\site::checkAuth();
			if(!$checkAuth){
				header("Location: /");
			}

			if (isset($_POST['exit'])) {
				$checkExit = vl\app\models\site::checkExit();
			}

			// Подключение к DB
            $db = \vl\app\core\db::getConnection();

            // Селект инфы о юзере через сессию (логин)
			$infoUser = vl\app\models\user::selectByLogin($_SESSION['login'], $db);

			// Обновление последнего ип
			$updateLastIp = vl\app\models\user::updateLastIp($infoUser['id'], $infoUser['last_ip'], $db);

			// Скрипт на НЕпросмотренные игры
			$selectUnVisGames = vl\app\models\user::selectUnVisGames($infoUser['id'], $db);

			// Селект типа игры
			$checkTypeGame = vl\app\models\game::checkTypeGame($type);

			// Селект инфы игры по типу
			$checkInfoGameByType = vl\app\models\game::checkInfoGameByType($type, $db);

			// Действие при нажати на кнопку "Мне повезет"
			if (isset($_POST['go'])) {
				$type = false;
				$errors = false;

				$type = $checkTypeGame;

				// Проверка на существование игры с таким типом
				if (vl\app\models\game::checkIssetGameByType($type, $db)) {
					$errors[] = 'Игра не найдена';
				}

				// Проверка на занятость игры с таким типом
				if (vl\app\models\game::checkBusyGameByType($checkInfoGameByType, $db)) {
					$errors[] = 'В игре нет мест';
				}

				// Проверка на нахождении игрока в игре с таким типом
				if (vl\app\models\game::checkIssetPlayerGameByType($infoUser['id'], $checkInfoGameByType['id'], $db)) {
					$errors[] = 'Вы уже находитесь в этой игре';
				}

				// Проверка на деньги user.money >= game.money
				if (vl\app\models\game::checkMoneyPlayerforGame($infoUser['money'], $checkInfoGameByType['min'])) {
					$errors[] = 'Не хватает денег';
				}

				if ($errors === false) {
					$addPlayerInGame = \vl\app\models\game::addPlayerInGame($infoUser, $checkInfoGameByType, $db);
				}
			}

			// Проверка на нахождения игрока в игре (для визуального эффекта)
			$checkPlayerToGameVisual = vl\app\models\game::checkIssetPlayerGameByType($infoUser['id'], $checkInfoGameByType['id'], $db);

			// Подключение view
			$this->view('login/index', [
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],
				'type' => $checkTypeGame,

				'selectUnVisGames' => $selectUnVisGames,

				'playerToGame' => $checkPlayerToGameVisual,
			]);
		}

		public function controlPanelAction()
		{
			$checkAuth = vl\app\models\site::checkAuth();
			if(!$checkAuth){
				header("Location: /");
			}

			// Подключение к DB
            $db = \vl\app\core\db::getConnection();

            // Селект инфы о юзере через сессию (логин)
			$infoUser = vl\app\models\user::selectByLogin($_SESSION['login'], $db);

			// Обновление последнего ип
			$updateLastIp = vl\app\models\user::updateLastIp($infoUser['id'], $infoUser['last_ip'], $db);

			// Скрипт на апдейт НЕпросмотренных игр
			$UpdateUnVisGamesForCp = vl\app\models\user::UpdateUnVisGamesForCp($infoUser['id'], $db);

			// Скрипт на НЕпросмотренные игры
			$selectUnVisGames = vl\app\models\user::selectUnVisGames($infoUser['id'], $db);

			// Личная история игр
			$historyGamesForCp = vl\app\models\user::historyGamesForCp($infoUser['id'], $db);

			// Подключение view
			$this->view('login/cp', [
				'id' => $infoUser['id'],
				'login' => $infoUser['login'],
				'email' => $infoUser['email'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,

				'historyGamesForCp' => $historyGamesForCp,
				]);
		}

		public function authAction()
		{
			$checkAuth = vl\app\models\site::checkAuth();
			if($checkAuth){
				header("Location: /login");
			}

			if (isset($_POST['auth'])) {
				$login = $_POST['login'] ?? false;
				$password = $_POST['password'] ?? false;

				$errors = false;

				// Подключение к DB
            	$db = \vl\app\core\db::getConnection();

            	if (!vl\app\models\site::checkName($login)) {
	                $errors[] = 'Имя не должно быть короче 2-х символов';
	            }

	            if (!vl\app\models\site::checkPassword($password)) {
	                $errors[] = 'Пароль не должен быть короче 6-ти символов';
	            }

	            if (!vl\app\models\site::checkLimitLogs($login, $db)) {
	                $errors[] = 'Вы сможете авторизоваться через пару секунд';
	            }

	            if ($errors === false) {
	            	// Проверяем существует ли пользователь
					$userId = vl\app\models\site::checkUserData($login, $password, $db);
					if ($userId) {
						$_SESSION['login'] = $userId;
						header("Location: /login");
					}
	            }
			}
			header("Location: /");
		}

		public function regAction()
		{
			$checkAuth = vl\app\models\site::checkAuth();
			if($checkAuth){
				header("Location: /login");
			}

			if (isset($_POST['reg'])) {
				$login = $_POST['login'] ?? false;
				$password = $_POST['password'] ?? false;
				$email = $_POST['email'] ?? false;
				$response = $_POST['g-recaptcha-response'] ?? false;
				$errors = false;

				// Подключение к DB
            	$db = \vl\app\core\db::getConnection();

				// Валидация полей
	            if (!vl\app\models\site::checkName($login)) {
	                $errors[] = 'Имя не должно быть короче 2-х символов';
	            }
	            else{
	            	// Фильтрация полей
            		$login = vl\app\models\site::htmlentitiesFilter($login);
	            }

	            if (!vl\app\models\site::checkEmail($email)) {
	                $errors[] = 'Неправильный email';
	            }

	            if (!vl\app\models\site::checkPassword($password)) {
	                $errors[] = 'Пароль не должен быть короче 6-ти символов';
	            }
	            else{
	            	$password = vl\app\models\site::hashPassword($password);
	            }

	            if (vl\app\models\site::checkLoginExists($login, $db)) {
                	$errors[] = 'Такой логин уже используется';
            	}

	          	if (vl\app\models\site::checkEmailExists($email, $db)) {
                	$errors[] = 'Такой email уже используется';
            	}

            	if (!vl\app\models\site::checkCaptcha($response)) {
                	$errors[] = 'Капча введена неверно';
            	}

            	if ($errors === false) {
            		$result = vl\app\models\site::register($login, $password, $email, $db);
                	if ($result) {
                		$_SESSION['login'] = $login;
                		header("Location: /login");
                	}
            	}
			}
			header("Location: /");
		}

		public function addMoneyAction(){
			$checkAuth = vl\app\models\site::checkAuth();
			if(!$checkAuth){
				header("Location: /");
			}

			// Подключение к DB
			$db = \vl\app\core\db::getConnection();

			// Селект инфы о юзере через сессию (логин)
			$infoUser = vl\app\models\user::selectByLogin($_SESSION['login'], $db);

			// Обновление последнего ип
			$updateLastIp = vl\app\models\user::updateLastIp($infoUser['id'], $infoUser['last_ip'], $db);

			// Скрипт на НЕпросмотренные игры
			$selectUnVisGames = vl\app\models\user::selectUnVisGames($infoUser['id'], $db);
			if (isset($_POST['pay']) && ((int) $_POST['money'] >= 50)) {
				echo "1";
			}

			// Подключение view
			$this->view('login/add', [
				'id' => $infoUser['id'],
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,
			]);
		}

		public function outputMoneyAction(){
			$checkAuth = vl\app\models\site::checkAuth();
			if(!$checkAuth){
				header("Location: /");
			}

			// Подключение к DB
			$db = \vl\app\core\db::getConnection();

			// Селект инфы о юзере через сессию (логин)
			$infoUser = vl\app\models\user::selectByLogin($_SESSION['login'], $db);

			// Обновление последнего ип
			$updateLastIp = vl\app\models\user::updateLastIp($infoUser['id'], $infoUser['last_ip'], $db);

			// Скрипт на НЕпросмотренные игры
			$selectUnVisGames = vl\app\models\user::selectUnVisGames($infoUser['id'], $db);

			if (isset($_POST['ok'])) {
				$errors = false;

				$money = (int) $_POST['money'] ?? false;
				$wallet = $_POST['wallet'] ?? false;

				if (!vl\app\models\site::checkOutputMoney($money, $infoUser['money'])) {
					$errors[] = 'Не допустимое значение';
				}

				if ($errors === false) {
					$addHistoryOutput = vl\app\models\site::addHistoryOutput($db, $money, $wallet, $infoUser['id'], $infoUser['money']);
				}
			}

			// История заявок на вывод денег
			$historyOutputMoney = vl\app\models\site::historyOutputMoney($db, $infoUser['id']);

			// Подключение view
			$this->view('login/out', [
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,

				'historyOutputMoney' => $historyOutputMoney,
			]);
		}

		public function gameAction(){
			$checkAuth = vl\app\models\site::checkAuth();
			if(!$checkAuth){
				header("Location: /");
			}

			// Подключение к DB
			$db = \vl\app\core\db::getConnection();

			// Селект инфы о юзере через сессию (логин)
			$infoUser = vl\app\models\user::selectByLogin($_SESSION['login'], $db);

			// Обновление последнего ип
			$updateLastIp = vl\app\models\user::updateLastIp($infoUser['id'], $infoUser['last_ip'], $db);

			// Скрипт на НЕпросмотренные игры
			$selectUnVisGames = vl\app\models\user::selectUnVisGames($infoUser['id'], $db);

			// Подключение view
			$this->view('login/game', [
				'id' => $infoUser['id'],
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,
			]);
		}


	}
