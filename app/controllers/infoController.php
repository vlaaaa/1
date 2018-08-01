<?php

	/**
	 *  Class info
	 */

	class infoController extends vl\app\core\controller
	{
		public function faqAction(){
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
			$this->view('login/faq', [
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,
			]);
		}

		public function historyAction(){
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

			// История игр
			$historyGames = vl\app\models\user::historyGames($db);

			// Подключение view
			$this->view('login/history', [
				'login' => $infoUser['login'],
				'money' => $infoUser['money'],
				'ico' => substr($infoUser['login'], 0, 1),
				'color' => $infoUser['color'],

				'selectUnVisGames' => $selectUnVisGames,

				'historyGames' => $historyGames,
			]);
		}

	}
