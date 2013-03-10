<?php
/*******************************************************************************
*                                                                              *
*  Библиотека с общими функциями.                                              *
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

if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки


/*!
 * \brief Пространство имен общих переменных и функций.
 */
class General {
	public static $data = array(); // публичные данные

	/*!
	 * \brief Инициализировать.
	 */
	public static function initialize() {
		General::$startTime = microtime(true); // текущее время
	
		General::$redirectUrl = $_GET['redirect']; // адрес перенаправления из запроса
		if (!General::$redirectUrl) General::$redirectUrl = $_COOKIE['redirect']; // адрес перенаправления из куки, если не удалось получить из запроса
		if (!General::$redirectUrl) General::$redirectUrl = $config['host_url']; // адрес перенаправления на хост, если не удалось получить и из куки
		General::setCookie('redirect', false); // удалить значение из куки

		switch ($_GET['content-type']) { // в зависимости от указанного типа запрашиваемых данных
			case 'html':
			case 'embedded-html':
			case 'json':
				General::$contentType = $_GET['content-type']; // указанный корректный тип данных
				break;
			default:
				General::$contentType = 'html'; // тип данных по-умолчанию
		}

		switch ($_GET['viewport']) { // в зависимости от указанного в запросе типа отображения
			// todo: вернуть mobile
			case 'desktop':
		//	case 'mobile':
				setCookie('viewport', $_GET['viewport']); // установить cookie
			case 'print':
				General::$viewport = $_GET['viewport']; // указанный корректный тип отображения
				break;
			default: // если в запросе тип отображения указан некорректно или не указан вовсе
				switch ($_COOKIE['viewport']) { // в зависимости от указанного в куки типа отображения
				case 'desktop':
		//		case 'mobile':
					General::$viewport = $_COOKIE['viewport']; // указанный корректный тип отображения
					break;
				default: // если в куки тип отображения указан некорректно или не указан вовсе
					General::$viewport = General::getUserAgent('viewport');
			}
		}
	}

	
	/*!
	 * \brief Получить ссылку на запрашиваемую страницу.
	 * \return строка с ссылкой
	 */
	public static function getUrl() {
		if (is_null(General::$url))	{ // если ссылка еще не вычислена
			General::$url = ((!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) == 'off') ? 'http://' : 'https://').$_SERVER['SERVER_NAME'].((isset($_SERVER['SERVER_PORT']) && (($_SERVER['SERVER_PORT'] != '80' && $protocol == 'http://') || ($_SERVER['SERVER_PORT'] != '443' && $protocol == 'https://')) && strpos($_SERVER['HTTP_HOST'], ':') === false) ? ':'.$_SERVER['SERVER_PORT'] : '').$_SERVER['REQUEST_URI'];
		}
		return General::$url;
	}	


	/*!
	 * \brief Получить адрес, с которого запрашивается страница.
	 * \return строка с адресом
	 */
	public static function getRemoteAddr() {
		if (is_null(General::$remoteAddr)) { // если адрес еще не вычислен
			General::$remoteAddr = $_SERVER['REMOTE_ADDR'];
		}
		return General::$remoteAddr;
	}


	/*!
	 * \brief Получить описание программы, через которую запрашивается страница.
	 * \return ассоциативный массив с описанием программы, значение поля массива, если задан ключ, или false, если не удается определить
	 * \param key ключ массива
	 */
	public static function getUserAgent($key = null) {
		if (is_null(General::$userAgent)) { // если описание программы еще не вычислено
			General::$userAgent = array();
			if ( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
				General::$userAgent['name'] = 'IE';
			} else if (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
				General::$userAgent['name'] = 'Chrome';
			} elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
				General::$userAgent['name'] = 'Firefox';
			} elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
				General::$userAgent['name'] = 'Opera';
			} elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
				General::$userAgent['name'] = 'Safari';
			} else {
				General::$userAgent = false;
			}
			General::$userAgent['viewport'] = 'desktop';
		}
		if (is_null($key)) {
			return General::$userAgent;
		} else {
			return General::$userAgent[$key];
		}
	}
	

	/*!
	 * \brief Получить время начала выполнения скрипта.
	 * \return количество секунд (с точностью до микросекунд), прошедших с начала Эпохи Unix (The Unix Epoch, 1 января 1970, 00:00:00 GMT)
	 */
	public static function getStartTime() {return General::$startTime;}


	/*!
	 * \brief Получить адрес перенаправления.
	 * \return строка с адресом
	 */
	private static function getRedirectUrl() {return General::$redirectUrl;}

	
	/*!
	 * \brief Задать адрес перенаправления, который будет актуален на следующей странице.
	 * \param url строка с адресом
	 */
	public static function setNextRedirectUrl($url) {General::setCookie('redirect', $url, false);}


	/*!
	 * \brief Получить тип запрашиваемых данных.
	 * \return строка с типом
	 */
	public static function getContentType() {return General::$contentType;}


	/*!
	 * \brief Получить тип отображения.
	 * \return строка с типом
	 */
	public static function getViewport() {return General::$viewport;} 


	/*!
	 * \brief Перенаправить на указанный url с помощью заголовка.
	 * \param url адрес для перенаправления, если null, то адрес берется из переменной $redirect
	 */
	public static function redirect($url = null) {
		if (!$url) $url = General::$redirectUrl;
		header('Location: '.General::htmlencode($url));
		exit;
	}


	/*!
	 * \brief Установить куки.
	 * \param name имя куки
	 * \param value значение
	 * \param expire время устаревания, если null, то куки будет ставить с периодом из настроек
	 * \param path путь, если null, то будет взят из настроек
	 * \param domain имя домена, если null, то используется все алиасы текущего домена
	 * \param secure передавать ли через защищенное соединение, если null, то будет считано из настроек
	 */
	public static function setCookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null) {
		global $config;
		header('P3P: CP="CUR ADM"'); // включить отправку заголовков P3P
		if ($expire == null) {
			$expire = time() + $config['cookie']['expire'];
		} else {
			$expire = intval($expire);
		}
		if ($path == null) $path = $config['cookie']['path'];
		if ($secure == null) $secure = $config['cookie']['secure'];
		if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
			if ($domain) {
				return setcookie($name, $value, $expire, $path, $domain, $secure, true);
			} else {
				$result = setcookie($name, $value, $expire, $path, false, $secure, true);
//				foreach ($config['domain_aliases'] as $domain) { // по всем алиасам
//					if (!setcookie($name, $value, $expire, $path, $domain, $secure, true)) $result = false;
//				}
				return $result;
			}
		} else {
			if ($domain) {
				return setcookie($name, $value, $expire, $path.'; HttpOnly', $domain, $secure);
			} else {
				$result = true;
				foreach ($config['domain_aliases'] as $domain) { // по всем алиасам
					if (!setcookie($name, $value, $expire, $path.'; HttpOnly', $domain, $secure)) $result = false;
				}
				return $result;
			}
		}
	}


	/*!
	 * \brief Получить массив параметров.
	 * \return массив с параметрами функции или null, если его нет
	 * \param argc количество параметров
	 * \param argv набор параметров, первый из которых может быть массивом
	 */
	public static function argArray($argc, $argv) {
		if ($argc == 0) return null; // выйти, если нет параметров
		if ($argc == 1 && is_array(&$argv[0])) { // если параметр один и он массив
			$result = &$argv[0]; // вернуть первый параметр
		} else { // если параметр не одby или он - не массив
			$result = &$argv; // вернуть массив параметров
		}
		return $result;
	}


	/*!
	 * \brief Экранировать символы в строке.
	 * \return строка с экранированными символами
	 * \param str строка с символами для экранирования
	 */
	public static function escape($str) {return str_replace(array('%40', '%2A', '%2B', '%2F'), array('@', '*', '+', '/'), rawurlencode($str));} 


	/*!
	 * \brief Разэкранировать символы в строке.
	 * \return строка с символами без экранирования
	 * \param str строка с экранированными символами
	 */
	public static function unescape($str) {return rawurldecode(str_replace(array('@', '*', '+', '/'), array('%40', '%2A', '%2B', '%2F'), $str));} 


	/*!
	 * \brief Закодировать строку для безовасного вывода в формате XML/HTML.
	 * \return перекодированная строка
	 * \param str строка для кодирования
	 */
	public static function htmlencode($str) {return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');}
	
	
	/*!
	 * \brief Усечь строку с концов до значимой части.
	 * \return обрезанная строка
	 * \param str строка для обрезания
	 * \param charlist множество символов, которые могут быть отрезаны
	 */
	public static function trim($str, $charlist = " \t\n\r\0\x0B\xC2\xA0") {
	    if (!$charlist) return trim($str);
		$charlist = preg_quote($charlist, '#');
		return preg_replace('#^['.$charlist.']+|['.$charlist.']+$#u', '', $str);
	}
	
	
	/*!
	 * \brief Сгенерировать случайный ключ указанной длины.
	 * \return сгенерированный ключ
	 * \param len требуемая длина
	 * \param isReadable должен ли ключ состоять из букв и цифр
	 * \param isHash должен ли ключ быть куском хэша
	 */
	public static function randomKey($len, $isReadable = false, $isHash = false) {
		$key = '';
		if ($isHash) {
			$key = substr(sha1(uniqid(rand(), true)), 0, $len);
		} elseif ($isReadable) {
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			for ($i = 0; $i < $len; ++$i) $key .= substr($chars, (mt_rand() % strlen($chars)), 1);
		} else {
			for ($i = 0; $i < $len; ++$i) $key .= chr(mt_rand(33, 126));
		}
		return $key;
	}
	
	/*!
	 * \brief Сгенерировать ссылку на картинку баркода, кодирующего переданное значение.
	 * \return сгенерированная ссылка
	 * \param value значение, которое нужно закодировать
	 */
	public static function barcodeImageUrl($value) {return 'http://qrcode.kaywa.com/img.php?s=8&d='.General::escape($value);}


	private static $url = null; // ссылка на запрашиваемую страницу
	private static $remoteAddr = null; // адрес, с которого запрашивается страница
	private static $userAgent = null; // ассоциативный массив с описанием программы, через которую запрашивается страница
	private static $startTime; // время начала выполнения скрипта
	private static $redirectUrl; // адрес перенаправления
	private static $contentType; // тип запрашиваемых данных
	private static $viewport; // тип отображения
}

General::initialize();

// Отключение кэширования.
header('Expires: Thu, 19 Feb 1998 13:24:18 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Информация о типе содержимого.
switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
case 'json':
	// todo: вернуть правильный заголовок
//	header('Content-type: text/json; charset=utf-8');
	header('Content-type: text/html; charset=utf-8');
	break;
case 'html':
case 'embedded_html':
default:
	header('Content-type: text/html; charset=utf-8');
	include_once 'Template.php'; // подключить библиотеку шаблонов
	General::$data['page']['breadcrumbs'] = array (); // хлебные крошки
}
