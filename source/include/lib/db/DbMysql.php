<?php
/*******************************************************************************************************************************
*                                                                                                                              *
*  Класс, реализующий работу с MySQL.                                                                                          *
*  v1.00                                                                                                                       *
*  Совместимость: PHP 5                                                                                                        *
*  by Кирилл Чувилин aka KiRiK (kirik-ch.ru)                                                                                   *
*                                                                                                                              *
*  Реализован в рамках проекта MaemoWorld.ru                                                                                   *
*                                                                                                                              *
*  Запрещено использование библиотеки или ее фрагментов:                                                                       *
*  - в коммерческих проектах                                                                                                   *
*  - без указания информации об авторстве                                                                                      *
*                                                                                                                              *
*  Для поддержки развития проекта или  просто благодарности можете пополнить яндекс-счет 41001384352607.                       *
*                                                                                                                              *
*******************************************************************************************************************************/

require_once 'DbException.php'; // класс для исключений

class DbMysql {
	private $dbid;   // идентификатор для доступа к базе данных
	private $dbname; // имя базы данных
	private $result; // результат запроса

	/*!
	 * \brief Конструктор.
	 * \param connectInfo информация для доступа к базе данных - массив с ключами
			host     адрес сервера
			user     имя пользователя
			password пароль
			name     имя базы данных
	 */
	public function __construct($connectInfo) {
		if (!($this->dbid = @mysql_connect($connectInfo['host'], $connectInfo['user'], $connectInfo['password']))): // если не удалось подключиться к базе данных
			throw new DbException(mysql_error(), DbException::CONNECTION);
		endif;
		$this->dbname = $connectInfo['name']; // запоминаем имя базы данных
		$this->selectDB(); // проверяем возможность выбора базы
		unset($this->result); // нет результата пока
	}

	/*! query($query, $arg1, $arg2...)
	 * \brief Выполнить запрос к базе данных.
	 * \return результат запроса
	 * \param query шаблон запроса
	 * \param arg1, arg2... параметры запроса
	 */
	public function query() {
		$this->selectDB(); // выбираем нужную базу
		$argv = func_get_args(); // получаем все параметры функции
		$argc = func_num_args(); // количество параметров функции
		$qArgs[0] = $argv[0]; // шаблон запроса
		$qArgs[0] = str_replace('%', '%%', $qArgs[0]); // чтобы % не потерялся
		$qArgs[0] = str_replace('?', '%s', $qArgs[0]); // места вставки параметров
		for ($i = 1; $i < $argc; $i++) { // по всем параметрам запроса
			if (is_int($argv[$i])): // если параметр - целое число
				$qArgs[] = $argv[$i]; // не экранируем
			else:
				$qArgs[] = '\''.$this->escape($argv[$i]).'\''; // экранируем спецсимволы
			endif;
		}
		for ($i = $argc; $i < $argc + 10; $i++) { // на всякий случай, если не все параметры внесены
			$qArgs[] = 'UNKNOWN_ARG_'.$i - 1; // неизвестный параметр
		}
		$query = call_user_func_array('sprintf', $qArgs); // создаем строку запроса
		if ($this->result = @mysql_query($query, $this->dbid)): // если запрос выполнен корректно
			return $this->result;
		else:
			throw new DbException(mysql_error(), DbException::QUERY);
		endif;
	}

	/*!
	 * \brief Выполнить запрос к базе данных.
	 * \return результат запроса
	 * \param query шаблон запроса
	 * \param argv массив параметров запроса
	*/
	public function queryArray($query, $argv) {
		$this->selectDB(); // выбираем нужную базу
		$argc = count($argv); // количество параметров функции
		$qArgs[0] = $query; // шаблон запроса
		$qArgs[0] = str_replace('%', '%%', $qArgs[0]); // чтобы % не потерялся
		$qArgs[0] = str_replace('?', '%s', $qArgs[0]); // места вставки параметров
		for ($i = 0; $i < $argc; $i++) { // по всем параметрам запроса
			if (is_int($argv[$i])): // если параметр - целое число
				$qArgs[] = $argv[$i]; // не экранируем
			else:
				$qArgs[] = '\''.$this->escape($argv[$i]).'\''; // экранируем спецсимволы
			endif;
		}
		for ($i = $argc; $i < $argc + 10; $i++) { // на всякий случай, если не все параметры внесены
			$qArgs[] = 'UNKNOWN_ARG_'.$i; // неизвестный параметр
		}
		$query = call_user_func_array('sprintf', $qArgs); // создаем строку запроса
		if ($this->result = @mysql_query($query, $this->dbid)): // если запрос выполнен корректно
			return $this->result;
		else:
			throw new DbException(mysql_error(), DbException::QUERY);
		endif;
	}

	
	/*!
	 * \brief Определить идентификатор автоинкрементного поля.
	 * \return идентификатор автоинкрементного поля записи, полученной последней командой INSERT
	 */
	public function getInsertID() {
		return mysql_insert_id($this->dbid);
	}

	
	/*! resultLine($result)
	 * \brief Получить одну строку результата.
	 * \return неассоциативный массив очередной строки; false, если строки кончились
	 * \param result дескриптор результата; если не указан, используется стандартный
	 */
	public function resultLine() {
		$argc = func_num_args(); // количество параметров функции
		if ($argc == 0): // если нет параметров
			return mysql_fetch_row($this->result);
		else: // если есть параметр
			$argv = func_get_args(); // получаем все параметры функции
			return mysql_fetch_row($argv[0]);
		endif;
	}

	/*! resultLineWithKeys($result)
	 * \brief Получить одну строку результата.
	 * \return ассоциативный массив очередной строки; false, если строки кончились
	 * \param result дескриптор результата; если не указан, используется стандартный
	 */
	public function resultLineWithKeys() {
		$argc = func_num_args(); // количество параметров функции
		if ($argc == 0): // если нет параметров
			return mysql_fetch_assoc($this->result);
		else: // если есть параметр
			$argv = func_get_args(); // получаем все параметры функции
			return mysql_fetch_assoc($argv[0]);
		endif;
	}

	/*! resultArray($result)
	 * \brief Получить двумерный массив результата.
	 * \return массив неассоциативных массивов строк результата
	 * \param result дескриптор результата; если не указан, используется стандартный
	 */
	public function resultArray() {
		$argc = func_num_args(); // количество параметров функции
		if ($argc == 0): // если нет параметров
			$result = &$this->result;
		else: // если есть параметр
			$argv = func_get_args(); // получаем все параметры функции
			$result = &$argv[0];
		endif;
		$resultArray = array();
		for ( ; $line = mysql_fetch_row($result); $resultArray[] = $line); // пока получаются линии добавляем их
		return $resultArray;
	}

	/*! resultArrayWithKeys($result)
	 * \brief Получить двумерный массив результата.
	 * \return массив ассоциативных массивов строк результата
	 * \param result дескриптор результата; если не указан, используется стандартный
	 */
	public function resultArrayWithKeys() {
		$argc = func_num_args(); // количество параметров функции
		if ($argc == 0): // если нет параметров
			$result = &$this->result;
		else: // если есть параметр
			$argv = func_get_args(); // получаем все параметры функции
			$result = &$argv[0];
		endif;
		$resultArray = array();
		for ( ; $line = mysql_fetch_assoc($result); $resultArray[] = $line); // пока получаются линии добавляем их
		return $resultArray;
	}

	/*!
	 * \brief Выбрать базу данных для работы.
	 */
	protected function selectDB() {
		if (!@mysql_select_db($this->dbname, $this->dbid)) { // если не удалось выбрать нужную базу данных
			throw new DbException(mysql_error($this->dbid), DbException::SELECT_DB);
		}
	}

	/*!
	 * \brief Экранировать символы в параметре запроса.
	 * \return строка с экранированными символами
	 * \param str строка символов для экранирования
	 */
	public function escape($str) {
		if (function_exists('mysql_real_escape_string')) return mysql_real_escape_string($str, $this->dbid);
		return mysql_escape_string($str);
	}
}
