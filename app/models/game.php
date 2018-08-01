<?php

	namespace vl\app\models;

	class game
	{
        public static function checkTypeGame($type)
        {
            return (int) $type;
        }

        public static function checkInfoGameByType($type, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT * FROM games WHERE type = :type';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':type', $type, \PDO::PARAM_INT);
            $result->execute();
            $info = $result->fetch();
            if ($info) {
                return $info;
            }
            return false;
        }

        public static function checkIssetGameByType($type, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT COUNT(*) FROM games WHERE type = :type';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':type', $type, \PDO::PARAM_INT);
            $result->execute();
            if ($result->fetchColumn())
                return false;
            return true;
        }

        public static function checkBusyGameByType($infoGame, $db)
        {
            if ($infoGame['players'] == $infoGame['max_players']) {
                return true;
            }
            return false;
        }

        public static function checkIssetPlayerGameByType($id_player, $id_game, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT COUNT(*) FROM players WHERE id_player = :id_player AND id_games = :id_game';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':id_player', $id_player, \PDO::PARAM_INT);
            $result->bindParam(':id_game', $id_game, \PDO::PARAM_INT);
            $result->execute();
            if ($result->fetchColumn())
                return true;
            return false;
        }

        public static function checkMoneyPlayerforGame($money_player, $money_game)
        {
            if ($money_player >= $money_game) {
                return false;
            }
            return true;
        }

        public static function addPlayerInGame($infoUser, $infoGame, $db)
        {
            $date = time();
            $update_money = $infoUser['money'] - $infoGame['min'];

            $sql = 'UPDATE users SET money = :money WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':money', $update_money, \PDO::PARAM_INT);
            $result->bindParam(':id', $infoUser['id'], \PDO::PARAM_INT);
            $result->execute();

            unset($result);

            // Текст запроса к БД
            $sql = 'INSERT INTO players (id_games, id_player, date) VALUES (:id_games, :id_player, :date)';
            $result = $db->prepare($sql);
            $result->bindParam(':id_games', $infoGame['id'], \PDO::PARAM_INT);
            $result->bindParam(':id_player', $infoUser['id'], \PDO::PARAM_INT);
            $result->bindParam(':date', $date, \PDO::PARAM_INT);
            $result->execute();

            unset($result);

            $count_players = $infoGame['players'] + 1;

            // Текст запроса к БД
            $sql = 'UPDATE games SET players = :players WHERE id = :id_games';
            $result = $db->prepare($sql);
            $result->bindParam(':players', $count_players, \PDO::PARAM_INT);
            $result->bindParam(':id_games', $infoGame['id'], \PDO::PARAM_INT);
            $result->execute();
        }

        // CRON ПРОВЕРКИ

        public static function selectAllGames($db)
        {
            $r = false;
            $sql = 'SELECT * FROM games';
            $result = $db->prepare($sql);
            $result->execute();
            while($info = $result->fetch(\PDO::FETCH_ASSOC)){
                $r[] = $info;
            }
            return $r;
        }

        public static function selectBusyGames($selectAllGames)
        {
            if ($selectAllGames === false)
                return false;

            $selectBusyGames = false;

            for ($i=0; $i < count($selectAllGames); $i++) {
                if ($selectAllGames[$i]['players'] === $selectAllGames[$i]['max_players']) {
                    $selectBusyGames[] = $selectAllGames[$i];
                }
            }
            return $selectBusyGames;
        }

        public static function operGame($selectBusyGames, $db)
        {
            if ($selectBusyGames === false)
                return false;

            for ($i=0; $i < count($selectBusyGames); $i++) {

                $r = false;
                $result = false;

                $sql = 'SELECT id_player FROM players WHERE id_games = :id_games';
                $result = $db->prepare($sql);
                $result->bindParam(':id_games', $selectBusyGames[$i]['id'], \PDO::PARAM_INT);
                $result->execute();

                while($info = $result->fetch(\PDO::FETCH_ASSOC)){
                    $r[] = $info;
                }

                $random_winner = random_int(0, count($r) - 1);

                // Текст запроса к БД
                $sql = 'SELECT money FROM users WHERE id = :id_winner';
                // Получение результатов. Используется подготовленный запрос
                $result = $db->prepare($sql);
                $result->bindParam(':id_winner', $r[$random_winner]['id_player'], \PDO::PARAM_INT);
                $result->execute();
                $money_winner = $result->fetch();

                $update_money = $money_winner['money'] + $selectBusyGames[$i]['min'] * $selectBusyGames[$i]['max_players'];

                unset($result);

                $sql = 'UPDATE users SET money = :money WHERE id=:id_winner';
                $result = $db->prepare($sql);
                $result->bindParam(':money', $update_money, \PDO::PARAM_INT);
                $result->bindParam(':id_winner', $r[$random_winner]['id_player'], \PDO::PARAM_INT);
                $result->execute();

                $date = date("Y-m-d G:i:s");
                $vis = 0;

                unset($result);

                // Текст запроса к БД
                $sql = 'INSERT INTO history_games (type, min, max_players, id_game, id_winner, date, vis) VALUES (:type, :min, :max_players, :id_game, :id_winner, :date, :vis)';
                $result = $db->prepare($sql);
                $result->bindParam(':type', $selectBusyGames[$i]['type'], \PDO::PARAM_INT);
                $result->bindParam(':min', $selectBusyGames[$i]['min'], \PDO::PARAM_INT);
                $result->bindParam(':max_players', $selectBusyGames[$i]['max_players'], \PDO::PARAM_INT);
                $result->bindParam(':id_game', $selectBusyGames[$i]['id'], \PDO::PARAM_INT);
                $result->bindParam(':id_winner', $r[$random_winner]['id_player'], \PDO::PARAM_INT);
                $result->bindParam(':date', $date, \PDO::PARAM_STR);
                $result->bindParam(':vis', $vis, \PDO::PARAM_INT);
                $result->execute();

                unset($result);

                $sql = 'DELETE FROM games WHERE id = :id';
                $result = $db->prepare($sql);
                $result->bindParam(':id', $selectBusyGames[$i]['id'], \PDO::PARAM_INT);
                $result->execute();

                unset($result);

                $players = 0;

                // Текст запроса к БД
                $sql = 'INSERT INTO games (type, min, players, max_players) VALUES (:type, :min, :players, :max_players)';
                $result = $db->prepare($sql);
                $result->bindParam(':type', $selectBusyGames[$i]['type'], \PDO::PARAM_INT);
                $result->bindParam(':min', $selectBusyGames[$i]['min'], \PDO::PARAM_INT);
                $result->bindParam(':players', $players, \PDO::PARAM_INT);
                $result->bindParam(':max_players', $selectBusyGames[$i]['max_players'], \PDO::PARAM_INT);
                $result->execute();
            }
            return false;
        }

	}
