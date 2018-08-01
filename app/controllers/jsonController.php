<?php

	/**
	 *  Class json
	 */

	class jsonController extends vl\app\core\controller
	{
		public function indexAction($type = 1){
			// Подключение к DB
            $db = \vl\app\core\db::getConnection();

            $selectGameByType = \vl\app\models\json::selectGameByType($type, $db);
            $selectPlayersById = \vl\app\models\json::selectPlayersById($selectGameByType['id'], $db);
            $selectPlayerById = \vl\app\models\json::selectPlayerById($selectPlayersById, $db);
            header('Content-Type: application/json; charset=utf-8');
            echo \vl\app\models\json::outputInfoGamesJson($selectGameByType, $selectPlayersById, $selectPlayerById);
		}
	}
