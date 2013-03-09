<?php
/*******************************************************************************
*                                                                              *
*  Класс каталога файлов на narod.yandex.ru.                                   *
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

class YandexCatalog {
	/**
		Конструктор.
		@param name     название каталога
		@param login    логин
		@param password пароль
		@param fileList список файлов
	*/
	public function __construct($name, $login, $password, $fileList) {
		$this->name = $name; // название каталога
		$this->login = $login; // имя пользователя
		$this->password = $password; // пароль
		$this->fileList = $fileList; // массив файлов
	}

	/**
		Возвращает название.
	*/
	public function getName() {
		return $this->name;
	}

	/**
		Возвращает логин.
	*/
	public function getLogin() {
		return $this->login;
	}

	/**
		Возвращает пароль.
	*/
	public function getPassword() {
		return $this->password;
	}

	/**
		Возвращает список файлов.
	*/
	public function getFileList() {
		return $this->fileList;
	}


	private $name; // название каталога
	private $login; // имя пользователя
	private $password; // пароль
	private $fileList; // массив файлов
}
