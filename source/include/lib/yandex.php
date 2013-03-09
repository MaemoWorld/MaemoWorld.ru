<?php
/*******************************************************************************
*                                                                              *
*  Класс для работы со страницами Yandex.ru.                                   *
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

class Yandex { // класс для работы с Yandex.ru
	/**
		Конструктор.
		@param login      имя пользователя
		@param password   пароль
	*/
	public function __construct($login, $password) {
		$this->login = $login; // имя пользователя
		$this->password = $password; // пароль
		$this->cookieFile = $_SERVER['DOCUMENT_ROOT'].'/cookies.txt'; // полный путь до файла с куки
		$this->retpath = 'http://webmaster.yandex.ru/'; // страница переадресации перед авторизацией
		$this->timestamp = ''; // ???
		$this->twoweeks = 'yes'; // запомнить пользователя на 2 недели :)
		$this->authUrl = 'http://passport.yandex.ru/passport?mode=auth'; // страница авторизации
		$this->inButton = 'Войти'; // кнопка входа
		$this->idkey = '3121235564020nVDfxvth2'; // ???
	}

	/**
		Производит авторизацию.
		@param url страница авторизации
	*/
	function auth() {
		$ch = curl_init($this->authUrl); // получаем дескриптор для обработки ссылки
		curl_setopt($ch, CURLOPT_URL, $this->authUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // будем получать ответ
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)'); // маскируемся под FireFox
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile); // задаем куки
		curl_setopt($ch, CURLOPT_COOKIEJAR,  $this->cookieFile); // задаем куки
		curl_setopt($ch, CURLOPT_POST,1); // будем отправлять POST-запрос
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'idkey='.$this->idkey.'&retpath='.$this->retpath.'&timestamp='.$this->timestamp.'&login='.$this->login.'&passwd='.$this->password.'&twoweeks='.$this->twoweeks.'&In='.$this->inButton); // параметры запроса
		$html = curl_exec($ch); // получаем страницу
		curl_close($ch);
		return $html; // возвращаем страницу
	}

	/**
		Загружает страницу.
		@param url адрес страницы
	*/
	function browser($url) {
		$ch = curl_init($url); // получаем дескриптор для обработки ссылки
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // будем получать ответ
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)'); // маскируемся под FireFox
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile); // задаем куки
		curl_setopt($ch, CURLOPT_COOKIEJAR,  $this->cookieFile); // задаем куки
		$html = curl_exec($ch); // получаем страницу
		curl_close($ch);
		return $html; // возвращаем страницу
	}

	private $login; // имя пользователя
	private $password; // пароль
	private $cookieFile; // полный путь до файла с куки
	private $retpath; // страница переадресации перед авторизацией
	private $timestamp; // ???
	private $twoweeks; // запомнить ли пользователя на 2 недели
	private $authUrl; // страница авторизации
	private $inButton; // кнопка входа
	private $idkey; // ???
}
