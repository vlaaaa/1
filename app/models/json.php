<?php

	namespace vl\app\models;

	class json
	{
        // Селект инфы игры по типу
		public static function selectGameByType($type, $db)
        {
            $sql = 'SELECT * FROM games WHERE type = :type';
            $result = $db->prepare($sql);
            $result->bindParam(':type', $type, \PDO::PARAM_INT);
            $result->execute();
            $info = $result->fetch();
            if ($info) {
                return $info;
            }
            return false;
        }

        // Селект пользователей актуальной игры по идентификатору актуальной игры
        public static function selectPlayersById($id, $db)
        {
            if ($id === null) {
                return false;
            }
            $sql = 'SELECT * FROM players WHERE id_games = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, \PDO::PARAM_INT);
            $result->execute();
            $row = false;
            while ($info = $result->fetch()) {
                $row[] = $info;
            }
            if ($row) {
                return $row;
            }
            return false;
        }

        // Селект инфы пользователей актуальной игры по идентификатору пользователей
        public static function selectPlayerById($id, $db)
        {
            if (!$id) {
                return false;
            }
            $sql = 'SELECT login,color FROM users WHERE id = :id';
            $result = $db->prepare($sql);
            $row = false;
            for ($i=0; $i <= 4; $i++) {
                $result->bindParam(':id', $id[$i]['id_player'], \PDO::PARAM_INT);
                $result->execute();
                if ($info = $result->fetch()) {
                    $row[] = $info;
                }
            }
            if ($row) {
                return $row;
            }
            return false;
        }

        public static function outputInfoGamesJson($game, $players, $info_player){
					for ($i=0; $i <= 4; $i++) {
						if (isset($players[$i]['date'])) {
							$setTime = (int)((time() - $players[$i]['date']) / 60);
							if ($setTime >= 60) {
								$setTime = $setTime.' час(а) назад';
							}
							elseif ($setTime<60 && $setTime>0) {
                                $setTime = $setTime.' мин. назад';
							}
                            else{
                                $setTime = 'меньше минуты назад';
                            }
							$players[$i]['date'] = $setTime;
						}
					}
            $result = [
                    'id' => $game['id'] ?? '',
                    'min' => $game['min'] ?? '',
                    'players' => $game['players'] ?? '',
                    'max_players' => $game['max_players'] ?? '',

                    'id_1' => $players[0]['id'] ?? '+',
                    'login_1' => $info_player[0]['login'] ?? '+',
                    'color_1' => $info_player[0]['color'] ?? '475c70',
                    'date_1' => $players[0]['date'] ?? '',

                    'id_2' => $players[1]['id'] ?? '+',
                    'login_2' => $info_player[1]['login'] ?? '+',
                    'color_2' => $info_player[1]['color'] ?? '475c70',
                    'date_2' => $players[1]['date'] ?? '',

                    'id_3' => $players[2]['id'] ?? '+',
                    'login_3' => $info_player[2]['login'] ?? '+',
                    'color_3' => $info_player[2]['color'] ?? '475c70',
                    'date_3' => $players[2]['date'] ?? '',

                    'id_4' => $players[3]['id'] ?? '+',
                    'login_4' => $info_player[3]['login'] ?? '+',
                    'color_4' => $info_player[3]['color'] ?? '475c70',
                    'date_4' => $players[3]['date'] ?? '',

                    'id_5' => $players[4]['id'] ?? '+',
                    'login_5' => $info_player[4]['login'] ?? '+',
                    'color_5' => $info_player[4]['color'] ?? '475c70',
                    'date_5' => $players[4]['date'] ?? '',
            ];
            return json_encode($result);
        }
	}
