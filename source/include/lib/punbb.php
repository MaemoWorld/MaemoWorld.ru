<?php
/*******************************************************************************
*                                                                              *
*  Класс для работы с PunBB.                                                   *
*                                                                              *
*  Copyright (C) 2010-2012 Kirill Chuvilin.                                    *
*  Contact: Kirill Chuvilin (kirill.chuvilin@gmail.com, kirill.chuvilin.pro)   *
*                                                                              *
*  This file is a part of the MaemoWorld.ru project.                           *
*  https://github.com/MaemoWorld/MaemoWorld.ru                                 *
*                                                                              *
*  $QT_BEGIN_LICENSE:GPL$                                                      *
*                                                                              *
*  GNU General Public License Usage                                            *
*  Alternatively, this file may be used under the terms of the GNU General     *
*  Public License version 3.0 as published by the Free Software Foundation     *
*  and appearing in the file LICENSE.GPL included in the packaging of this     *
*  file. Please review the following information to ensure the GNU General     *
*  Public License version 3.0 requirements will be met:                        *
*  http://www.gnu.org/copyleft/gpl.html.                                       *
*                                                                              *
*  This file is distributed in the hope that it will be useful, but WITHOUT    *
*  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or       *
*  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for    *
*  more details.                                                               *
*                                                                              *
*  $QT_END_LICENSE$                                                            *
*                                                                              *
*******************************************************************************/

require_once 'general.php';
require_once 'db/DbMysql.php'; // работа с MySQL

if (!isset($config['punbb'])) exit('Punbb config must be loaded.'); // выйти, если не загружены настройки

/*!
 * \brief Класс пользователя punbb.
 */
class PunbbUser {
	/*!
	 * \brief Конструктор.
	 * \param userData ассоциативный массив с данными пользователя
	 */
	public function __construct($userData) {
		$this->id = $userData['id'];
		$this->groupId = $userData['group_id'];
		$this->username = $userData['username'];
		$this->password = $userData['password'];
		$this->salt = $userData['salt'];
		$this->email = $userData['email'];
		$this->logged = $userData['logged'];
		$this->csrfToken = $userData['csrf_token'];
		$this->prevUrl = $userData['prev_url'];
		$this->lastVisit = $userData['last_visit'];
		$this->idle = $userData['idle'];
		$this->numPosts = $userData['num_posts'];
	}


	/*!
	 * \brief Проверить является ли пользователем по-умолчанию.
	 * \return true, если пользователь по-умолчанию, иначе false
	 */
	public function isDefault() {return $this->id == 1;}


	/*!
	 * \brief Проверить является ли гостем.
	 * \return true, если гость, иначе false
	 */
	public function isGuest() {return $this->id == 1;}


	/*!
	 * \brief Проверить является ли администратором.
	 * \return true, если администратор, иначе false
	 */
	public function isAdmin() {return $this->id == 2;}


	public $id; // id пользователя
	public $groupId; // id группы пользователя
	public $username; // имя пользователя
	public $password; // хэш пароля
	public $salt; // шум для хэша
	public $email; // e-mail пользователя
	public $logged; // время аунтификации
	public $csrfToken; // ???
	public $prevUrl; // последный URL
	public $lastVisit; // время последнего посещения
	public $idle; // ???
	public $numPosts; // количество сообщений
}


/*!
 * \brief Пространство имен для работы с punbb.
 */
class Punbb {
	/*!
	 * \brief Генерирует зашумленный SHA1 хэш для строки.
	 * \return сгенерированныу хэш-строку
	 * \param str строка
	 * \param salt шум
	 */
	public static function hash($str, $salt) {return sha1($salt.sha1($str));}


	/*!
	 * \brief Установить куки.
	 * \param name имя
	 * \param value значение
	 * \param expire время устаревания
	 */
	public static function setCookie($name, $value, $expire) {
		global $config;
		General::setCookie($name, $value, $expire, $config['punbb']['cookie']['path'], null, $config['punbb']['cookie']['secure']);
	}
	

	/*!
	 * \brief Установить куки для известного пользователя.
	 * \param user объект пользователя
	 * \param expire время устаревания
	 */
	public static function setUserCookie($user, $expire) {
		global $config;
		$expire = intval($expire); // должно быть целым для корректного задания куки
		Punbb::setCookie($config['punbb']['cookie']['name'], base64_encode($user->id.'|'.$user->password.'|'.$expire.'|'.sha1($user->salt.$user->password.Punbb::hash($expire, $user->salt))), $expire);
	}

	
	/*!
	 * \brief Получить пользователя форума по указанному идентификатору.
	 * \return объект пользователя или null, если нет такого пользователя
	 * \param userId идентификатор пользователя
	 */
	public static function getUserById($userId) {
		if (!is_int($userId)) return null;
		Punbb::$db->query(Punbb::getDbQueryBaseForUser().' WHERE users.id='.$userId); // выполнить запрос
		$userFromDb = Punbb::$db->resultLineWithKeys(); // получить строку результата
		if (!$userFromDb) return null;
		return new PunbbUser($userFromDb);
	}

	
	/*!
	 * \brief Получить пользователя форума по указанному e-mail.
	 * \return объект пользователя или null, если нет такого пользователя
	 * \param userEmail e-mail пользователя
	 */
	public static function getUserByEmail($userEmail) {
		Punbb::$db->query(Punbb::getDbQueryBaseForUser().' WHERE LOWER(users.email)=LOWER(\''.Punbb::$db->escape($userEmail).'\')'); // выполнить запрос
		$userFromDb = Punbb::$db->resultLineWithKeys(); // получить строку результата
		if (!$userFromDb) return null;
		return new PunbbUser($userFromDb);
	}

	
	/*! getUsersById($userIds)
	 * \brief Получить пользователей форума по указанным идентификаторам.
	 * \return ассоциативный массив вида id => punbb_user
	 * \param userIds список интересующих идентификаторов пользователей, если не указан, будут считываться все
	 */
	public static function getUsersById() {
		global $config;
		$userIds = General::argArray(func_num_args(), func_get_args()); // получить массив параметров
		$query = Punbb::getDbQueryBaseForUser(); // основа запроса к БД
		if ($userIds) { // если указаны интересующие идентификаторы
			$query .= ' WHERE id IN ('.implode(',', $userIds).')';
		}
		punbb::$db->query($query); // выполнить запрос
		$usersFromDb = punbb::$db->resultArrayWithKeys(); // получить таблицу пользователей
		$users = array(); // массив пользователей
		foreach ($usersFromDb as $userFromDb) { // по всем тэгам
			$users[$userFromDb['id']] = new PunbbUser($userFromDb); // добавить имя по идентификатору
		}
		return $users;
	}


	/*!
	 * \brief Получить пользователя по-уморчанию (гостя).
	 * \return объект пользователя по-умолчанию
	 */
	public static function getDefaultUser() {return Punbb::getUserById(1);}
	
	
	/*!
	 * \brief Распознать пользователя.
	 * \return объект пользователя
	 * \param userInfo id или e-mail пользователя
	 * \param password данные о пароле
	 * \param isPasswordHashed является пароль в password кэшированым или нет
	 */
	public static function getAuthenticatedUser($userInfo, $password, $isPasswordHashed = false) {
		if (is_int($userInfo)) { // если передан id пользователя
			$user = Punbb::getUserById($userInfo);
		} else { // если передан e-mail пользователя
			$user = Punbb::getUserByEmail($userInfo);
		}
		if (!user) return Punbb::getDefaultUser(); // вернуть гостя, если не удалось получить пользователя
		if ($isPasswordHashed) { // если пароль захэширован
			if ($password != $user->password) return Punbb::getDefaultUser(); // вернуть гостя, если пароль не подошел
		} else { // если пароль не захэширован
			if (Punbb::hash($password, $user->salt) != $user->password) return Punbb::getDefaultUser(); // вернуть гостя, если пароль не подошел
		}
		return $user;
	}

	
	/*!
	 * \brief Аунтифицировать пользователя по-умолчанию.
	 */
	public static function authenticateDefaultUser() {
		global $config;
		Punbb::$user = Punbb::getDefaultUser(); // получить пользователя по-умолчанию
		$query = 'SELECT users.*, groups.*, online.logged, online.csrf_token, online.prev_url, online.last_post, online.last_search FROM '.$config['punbb']['db']['prefix'].'users AS users INNER JOIN '.$config['punbb']['db']['prefix'].'groups AS groups ON groups.g_id=users.group_id LEFT JOIN '.$config['punbb']['db']['prefix'].'online AS online ON online.ident=\''.Punbb::$db->escape(General::getRemoteAddr()).'\' WHERE users.id=1';
		Punbb::$db->query($query); // выполнить запрос
		$userFromDb = Punbb::$db->resultLineWithKeys(); // получить строку результата
		if (!$userFromDb) exit('Unable to fetch guest information. The table \''.$config['punbb']['db']['prefix'].'users\' must contain an entry with id = 1 that represents anonymous users.');
		Punbb::$user = new PunbbUser($userFromDb); // сгенерировать объект пользователя
		Punbb::$user->logged = time(); // время авторизации
		Punbb::$user->csrf_token = General::randomKey(40, false, true);
		Punbb::$user->prevUrl = General::getUrl(); // предыдущий url
//		$query = 'REPLACE  INTO '.$config['punbb']['db']['prefix'].'online (user_id, ident, logged, csrf_token, prev_url) VALUES (1, \''.Punbb::$db->escape(General::getRemoteAddr()).'\', '.Punbb::$user->logged.', \''.Punbb::$user->csrfToken.'\', \''.Punbb::$db->escape(Punbb::$user->prevUrl).'\') UNIQUE user_id=1 AND ident=\''.Punbb::$db->escape(General::getRemoteAddr()).'\'';
		$query = 'REPLACE  INTO '.$config['punbb']['db']['prefix'].'online (user_id, ident, logged, csrf_token, prev_url) VALUES (1, \''.Punbb::$db->escape(General::getRemoteAddr()).'\', '.Punbb::$user->logged.', \''.Punbb::$user->csrfToken.'\', \''.Punbb::$db->escape(Punbb::$user->prevUrl).'\')';
		Punbb::$db->query($query); // выполнить запрос
	}


	/*!
	 * \brief Аунтифицировать пользователя.
	 * \param user объект пользователя
	 * \param cookieExpire время устаревания куки
	 */
	public static function authenticateUser($user, $cookieExpire) {
		global $config;
		Punbb::$user = $user;
		$cookieExpireTime = General::getStartTime() + $config['punbb']['cookie']['expire']; // время устаревания куки
		if (Punbb::$user->isDefault()) { // если пользователь по-умолчанию
			Punbb::setCookie($config['punbb']['cookie']['name'], base64_encode('1|'.General::randomKey(8, false, true).'|'.$cookieExpireTime.'|'.General::randomKey(8, false, true)), $cookieExpireTime); // установить куки
			return; // выйти
		}
		$cookieExpireTime = (intval($cookieExpire) > General::getStartTime() + $config['punbb']['timeout_visit']) ? General::getStartTime() + $config['punbb']['cookie']['expire'] : General::getStartTime() + $config['punbb']['timeout_visit'];
		Punbb::setUserCookie(Punbb::$user, $cookieExpireTime);
		if (Punbb::$user->logged) { // если пользователь был залогинен
			if (Punbb::$user->logged < (General::getStartTime() - $config['punbb']['timeout_visit'])) { // если пользователь был давно залогинен
				$query = 'UPDATE '.$config['punbb']['db']['prefix'].'users SET last_visit='.Punbb::$user->logged.' WHERE id='.Punbb::$user->id;
				Punbb::$db->query($query);
				Punbb::$user->lastVisit = Punbb::$user->logged;
			}
			$query = 'UPDATE '.$config['punbb']['db']['prefix'].'online SET logged='.General::getStartTime().', prev_url=\''.Punbb::$db->escape(General::getUrl()).'\'';
			if ($forum_user['idle'] == '1')	$query .= ', idle=0';
			$query .= ' WHERE user_id='.Punbb::$user->id;
			Punbb::$db->query($query);
		} else { // если пользователь не был залогинен
			Punbb::$user->logged = General::getStartTime();
			Punbb::$user->csrfToken = General::randomKey(40, false, true);
			Punbb::$user->prevUrl = General::getUrl();
//			$query = 'REPLACE INTO '.$config['punbb']['db']['prefix'].'online (user_id, ident, logged, csrf_token, prev_url) VALUES '.Punbb::$user->id.', \''.Punbb::$db->escape(Punbb::$user->username).'\', '.Punbb::$user->logged.', \''.Punbb::$user->csrfToken.'\', \''.Punbb::$db->escape(Punbb::$user->prevUrl).'\' UNIQUE user_id='.Punbb::$user->id;
			$query = 'REPLACE INTO '.$config['punbb']['db']['prefix'].'online (user_id, ident, logged, csrf_token, prev_url) VALUES ('.Punbb::$user->id.', \''.Punbb::$db->escape(Punbb::$user->username).'\', '.Punbb::$user->logged.', \''.Punbb::$user->csrfToken.'\', \''.Punbb::$db->escape(Punbb::$user->prevUrl).'\')';
			Punbb::$db->query($query);
		}
	}

	
	/*!
	 * \brief Аунтифицировать пользователя через куки.
	 */
	public static function authenticateUserByCookie() {
		global $config;
		$cookie = array('user_id' => 1, 'password_hash' => 'Guest', 'expiration_time' => 0, 'expire_hash' => 'Guest'); // куки для пользователя по-умолчанию
		if (!empty(Punbb::$cookie)) { // если куки punbb не пусты
			$cookie_data = explode('|', base64_decode(Punbb::$cookie)); // раскодировать куки
			if (!empty($cookie_data) && count($cookie_data) == 4) { // если куки раскодированы корректно
				list($cookie['user_id'], $cookie['password_hash'], $cookie['expiration_time'], $cookie['expire_hash']) = $cookie_data;
			}
		}
		if (intval($cookie['user_id']) <= 1 && intval($cookie['expiration_time']) <= General::getStartTime()) { // если куки старое или некорректное
			Punbb::authenticateDefaultUser(); // задать пользователя по-умолчанию
			return;
		}
		$user = Punbb::getAuthenticatedUser(intval($cookie['user_id']), $cookie['password_hash'], true); // аунтифицировать пользователя
		if ($cookie['expire_hash'] !== sha1(Punbb::$user->salt.Punbb::$user->password.Punbb::hash(intval($cookie['expiration_time']), Punbb::$user->salt))) Punbb::authenticateDefaultUser(); // задать пользователя по-умолчанию, если хэш куки не прошел проверку
		Punbb::authenticateUser($user, $cookie['expiration_time']); // аунтифицировать пользователя
	}


	/*!
	 * \brief Проверить пользователя на блокировки.
	 * \param user проверяемый пользователь
	 */
	public function checkForBans($user) {
		// todo
	}


	/*! getTagsById($tagIds)
	 * \brief Получить тэги форума.
	 * \return ассоциативный массив вида id => имя
	 * \param tagIds список интересующих идентификаторов тэгов, если не указан, будут считываться все
	 */
	public static function getTagsById() {
		global $config;
		$tagIds = General::argArray(func_num_args(), func_get_args()); // получить массив параметров
		$query = 'SELECT id, tag FROM '.$config['punbb']['db']['prefix'].'tags'; // запрос к БД
		if ($tagIds) { // если указаны интересующие идентификаторы
			$query .= ' WHERE id IN ('.implode(',', $tagIds).')';
		}
		Punbb::$db->query($query); // выполнить запрос
		$tagsFromDb = Punbb::$db->resultArrayWithKeys(); // получить таблицу тэгов
		$tags = array(); // массив тэгов
		foreach ($tagsFromDb as $tagFromDb) { // по всем тэгам
			$tags[$tagFromDb['id']] = $tagFromDb['tag']; // добавить имя по идентификатору
		}
		return $tags;
	}


	/*! getTagsByName($tagNamess)
	 * \brief Получить тэги форума.
	 * \return ассоциативный массив вида id => имя
	 * \param tagName список интересующих имен, если не указан, будут считываться все
	 */
	public static function getTagsByName() {
		global $config;
		$tagNames = General::argArray(func_num_args(), func_get_args()); // получить массив параметров
		$query = 'SELECT id, tag FROM '.$config['punbb']['db']['prefix'].'tags'; // запрос к БД
		if ($tagNames) { // если указаны интересующие идентификаторы
			$query .= ' WHERE tag IN ('.implode(',', Punbb::$db->escape($tagNames)).')';
		}
		Punbb::$db->query($query); // выполнить запрос
		$tagsFromDb = Punbb::$db->resultArrayWithKeys(); // получить таблицу тэгов
		$tags = array(); // массив тэгов
		foreach ($tagsFromDb as $tagFromDb) { // по всем тэгам
			$tags[$tagFromDb['id']] = $tagFromDb['tag']; // добавить имя по идентификатору
		}
		return $tags;
	}


	/*!
	 * \brief Получить url для просмотра сообщения форума.
	 * \return url сообщения
	 */
	public static function getForumPostUrl($postId) {return $config['punbb']['url'].'/viewtopic.php?pid='.$postId.'#p'.$postId;}

	
	/*!
	 * \brief Получить основу запроса к БД для извлечения пользователя.
	 * \return строка запроса
	 */
	private function getDbQueryBaseForUser() {
		global $config;
		return 'SELECT users.*, groups.*, online.logged, online.idle, online.csrf_token, online.prev_url FROM '.$config['punbb']['db']['prefix'].'users AS users INNER JOIN '.$config['punbb']['db']['prefix'].'groups AS groups ON groups.g_id=users.group_id LEFT JOIN '.$config['punbb']['db']['prefix'].'online AS online ON online.user_id=users.id';
	}

	// todo: сделать приватным
	public static $db; // объект для доступа к БД форума	
	public static $cookie; // куки для punbb
	public static $user; // пользователь punbb
}


Punbb::$db = new DbMysql($config['punbb']['db']); // объект для доступа к БД форума
Punbb::$db->query('SET NAMES utf8'); // выбрать кодировку
Punbb::$db->query('SET SQL_BIG_SELECTS=1'); // разрешить длинные запросы
Punbb::$cookie = $_COOKIE[$config['punbb']['cookie']['name']]; // куки для punbb
Punbb::authenticateUserByCookie(); // аунтифицировать пользователя punbb


General::$data['user'] = array( // описание пользователя
	'is_guest' => Punbb::$user->isGuest()
);
if (!Punbb::$user->isGuest()) { // если пользователь - не гость
	General::$data['user']['id'] = Punbb::$user->id;
	General::$data['user']['username'] = Punbb::$user->username;
}
