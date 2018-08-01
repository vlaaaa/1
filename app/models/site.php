<?php

	namespace vl\app\models;

	class site
	{
        // Проверка на авторизацию
		public static function checkAuth()
        {
            if (isset($_SESSION['login'])) {
                return true;
            }
            return false;
        }

        // Выход
        public static function checkExit()
        {
            session_unset();
            header("Location: /");
        }

        // Лимит на авторизацию
        public static function checkLimitLogs($login, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT * FROM users WHERE login = :login';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, \PDO::PARAM_STR);
            $result->execute();
            $user = $result->fetch();

            $time = time();

            if (($user['limit_logs'] == 0) || (($time - $user['limit_logs']) >= 5)) {

                $sql = 'UPDATE users SET limit_logs = :limit_logs WHERE login = :login';
                $result = $db->prepare($sql);
                $result->bindParam(':limit_logs', $time, \PDO::PARAM_INT);
                $result->bindParam(':login', $login, \PDO::PARAM_STR);
                $result->execute();
                return true;
            }
            return false;
        }


        // ФИЛЬТРАЦИЯ XSS
        public static function htmlentitiesFilter($input)
        {
           return htmlentities($input);
        }

        // Валидация данных на длину логина
        public static function checkName($name)
        {
            if (strlen($name) >= 2) {
                return true;
            }
            return false;
        }

        // Валидация данных на правильность e-mail
        public static function checkEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }

        // Валидация данных на длину пароля
        public static function checkPassword($password)
        {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
        }

        // Преобразвание в hash пароль
        public static function hashPassword($password)
        {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        // Проверка логина на занятость
        public static function checkLoginExists($login, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT COUNT(*) FROM users WHERE login = :login';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, \PDO::PARAM_STR);
            $result->execute();
            if ($result->fetchColumn())
                return true;
            return false;
        }

        // Проверка e-mail на занятость
        public static function checkEmailExists($email, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':email', $email, \PDO::PARAM_STR);
            $result->execute();
            if ($result->fetchColumn())
                return true;
            return false;
        }

        // Проверка капчи
        public static function checkCaptcha($response)
        {

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => [
                    'secret' => '6LcCLA4UAAAAAEwmD6NhiwRugBmqBQ_YdzfgvYiy',
                    'response' => $response
                    ]
                ]);

            $response = json_decode(curl_exec($curl));

            return $response->success;
        }

        // Метод регистрации
        public static function register($login, $password, $email, $db)
        {
            $date = date("Y-m-d G:i:s");
            $ip = $_SERVER['REMOTE_ADDR'];
            $money = 0;
            $color = mt_rand(100000,999999);
            // Текст запроса к БД
            $sql = 'INSERT INTO users (login, password, email, money, date, ip, last_ip, color) '
                    . 'VALUES (:login, :password, :email, :money, :date, :ip, :last_ip, :color)';
            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, \PDO::PARAM_STR);
            $result->bindParam(':password', $password, \PDO::PARAM_STR);
            $result->bindParam(':email', $email, \PDO::PARAM_STR);
            $result->bindParam(':money', $money, \PDO::PARAM_INT);
            $result->bindParam(':date', $date, \PDO::PARAM_STR);
            $result->bindParam(':ip', $ip, \PDO::PARAM_STR);
            $result->bindParam(':last_ip', $ip, \PDO::PARAM_STR);
            $result->bindParam(':color', $color, \PDO::PARAM_INT);
            return $result->execute();
        }

        // Метод авторизации
        public static function checkUserData($login, $password, $db)
        {
            // Текст запроса к БД
            $sql = 'SELECT * FROM users WHERE login = :login';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, \PDO::PARAM_STR);
            $result->execute();
            $user = $result->fetch();
            if (password_verify($password, $user['password'])) {
                return $user['login'];
            }
            return false;
        }

				// Проверка на деньги (вывод)
        public static function checkOutputMoney($money, $money_user)
        {
            if (($money >= 50) && ($money <= $money_user)) {
            	return true;
            }
						return false;
        }

				// Добавление заявки в БД на выплату денег и списывание денег со счета пользователя
        public static function addHistoryOutput($db, $money, $wallet, $id_user, $money_user)
        {
					$date = date("Y-m-d G:i:s");
					$ip = $_SERVER['REMOTE_ADDR'];

					// Текст запроса к БД
					$sql = 'INSERT INTO history_output (id_user, money, wallet, date, ip) '
									. 'VALUES (:id_user, :money, :wallet, :date, :ip)';
					// Получение и возврат результатов. Используется подготовленный запрос
					$result = $db->prepare($sql);
					$result->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
					$result->bindParam(':money', $money, \PDO::PARAM_INT);
					$result->bindParam(':wallet', $wallet, \PDO::PARAM_STR);
					$result->bindParam(':date', $date, \PDO::PARAM_STR);
					$result->bindParam(':ip', $ip, \PDO::PARAM_STR);
					if ($result->execute()) {
						$setMoney = $money_user - $money;
						$sql = 'UPDATE users SET money = :set_money WHERE id = :id_user';
						$result = $db->prepare($sql);
						$result->bindParam(':set_money', $setMoney, \PDO::PARAM_INT);
						$result->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
						if ($result->execute()) {
							return true;
						}
					}
					return false;
        }

				// ИСТОРИЯ ЗАЯВОК НА ВЫВОД ДЕНЕГ

				public static function historyOutputMoney($db, $id_user)
				{
						$r = false;
						$sql = 'SELECT * FROM history_output WHERE id_user = :id_user';
						$result = $db->prepare($sql);
						$result->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
						$result->execute();
						while ($info = $result->fetch(\PDO::FETCH_ASSOC)) {
								$r[] = $info;
						}
						return $r;
				}

	}
