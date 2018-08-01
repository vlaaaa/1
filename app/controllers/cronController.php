<?php

	/**
	 *  Class cron
	 */

	class cronController extends vl\app\core\controller
	{
		public function indexAction(){

			// Подключение к DB
            $db = \vl\app\core\db::getConnection();

            // Вывод всех актуальных игр
            $selectAllGames = vl\app\models\game::selectAllGames($db);

            // Вывод заполненных игр
            $selectBusyGames = vl\app\models\game::selectBusyGames($selectAllGames);

            // Определение победителя и рерол игры
           	$operGame = vl\app\models\game::operGame($selectBusyGames, $db);
		}
	}
