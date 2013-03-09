<?php
/*******************************************************************************
*                                                                              *
*  Класс, инкапсулирующий работу с каталогои на narod.yandex.ru.               *
*  v1.01                                                                       *
*  Совместимость: PHP 5                                                        *
*  by Кирилл Чувилин aka KiRiK (kirik-ch.ru)                                   *
*                                                                              *
*  Реализован в рамках проекта MaemoWorld.ru                                   *
*                                                                              *
*  Запрещено использование библиотеки или ее фрагментов:                       *
*  - в коммерческих проектах                                                   *
*  - без указания информации об авторстве                                      *
*                                                                              *
*  Для поддержки развития проекта или  просто благодарности можете пополнить   *
*  яндекс-счет 41001384352607.                                                 *
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
?>
