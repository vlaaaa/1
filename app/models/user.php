<?php

	namespace vl\app\models;

	class user
	{
        // Селект инфы по логину
		public static function selectByLogin($login, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT id, login, email, money, color, last_ip FROM users WHERE login = :login';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, \PDO::PARAM_STR);
            $result->execute();
            $user = $result->fetch();
            return $user;
        }

        // Обновление последнего IP
        public static function updateLastIp($id_user, $last_ip, $db)
        {
            if ($last_ip != $_SERVER['REMOTE_ADDR']) {
                $last_ip_update = $_SERVER['REMOTE_ADDR'];
                $sql = 'UPDATE users SET last_ip = :last_ip WHERE id = :id_user';
                $result = $db->prepare($sql);
                $result->bindParam(':last_ip', $last_ip_update, \PDO::PARAM_STR);
                $result->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
                $result->execute();
            }
        }

        // Кол-во новых игр
        public static function selectUnVisGames($id_player, $db)
        {
            $sql = 'SELECT COUNT(h.vis) FROM `players` p JOIN `history_games` h ON (h.id_game=p.id_games) WHERE p.id_player = :id_player AND vis = 0';
            $result = $db->prepare($sql);
            $result->bindParam(':id_player', $id_player, \PDO::PARAM_INT);
            $result->execute();
            if($r = $result->fetchColumn()) return $r;
            return 0;

        }

        // Апдейт НЕпросмотренных игр
        public static function UpdateUnVisGamesForCp($id_player, $db)
        {
            $r = false;
            $sql = 'SELECT h.id FROM `players` p JOIN `history_games` h ON (h.id_game=p.id_games) WHERE (p.id_player = :id_player) ORDER BY id DESC LIMIT 5';
            $result = $db->prepare($sql);
            $result->bindParam(':id_player', $id_player, \PDO::PARAM_INT);
            $result->execute();
            while ($info = $result->fetch(\PDO::FETCH_ASSOC)) {
                $r[] = $info;
            }

            if ($r) {
                for ($i=0; $i < count($r); $i++) { 
                    $sql = 'UPDATE history_games SET vis = 1 WHERE id = :id_history AND vis = 0';
                    $result = $db->prepare($sql);
                    $result->bindParam(':id_history', $r[$i]['id'], \PDO::PARAM_INT);
                    $result->execute();
                }
            }
            return false;
        }

        // ИСТОРИЯ ИГР

        public static function historyGames($db)
        {
            $r = false;
            $i = 0;
            $sql = 'SELECT id_winner, date, min, max_players FROM history_games ORDER BY id DESC';
            $result = $db->prepare($sql);
            $result->execute();

            while ($info = $result->fetch(\PDO::FETCH_ASSOC)) {
                $r[] = $info;

                $sql = 'SELECT login FROM users WHERE id = :id_player';
                $q = $db->prepare($sql);
                $q->bindParam(':id_player', $r[$i]['id_winner'], \PDO::PARAM_INT);
                $q->execute();
                $r[$i]['id_winner'] = $q->fetch()['login'];
                $i++;
            }

            return $r;
        }

        // ИСТОРИЯ ИГР ДЛЯ ЛИЧНОГО КАБИНЕТА

        public static function historyGamesForCp($id_player, $db)
        {
            $r = false;
            $sql = 'SELECT h.* FROM `players` p JOIN `history_games` h ON (h.id_game=p.id_games) WHERE (p.id_player = :id_player) ORDER BY id DESC LIMIT 5';
            $result = $db->prepare($sql);
            $result->bindParam(':id_player', $id_player, \PDO::PARAM_INT);
            $result->execute();
            while ($info = $result->fetch(\PDO::FETCH_ASSOC)) {
                $r[] = $info;
            }
            return $r;
        }

	}
