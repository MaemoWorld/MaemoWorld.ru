<?php
/*******************************************************************************
*                                                                              *
*  Класс, инкапсулирующий работу с каталогом топиков форума punbb.             *
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
* яндекс-счет 41001384352607.                                                  *
*                                                                              *
*******************************************************************************/

class PunbbCatalog {
	/**
		Конструктор.
		@param name              имя каталога
		@param description       описание
		@param keyWords          ключевые слова
		@param forum             форум, из которого берутся записи
		@param exclusionTopics   топики, которые не нужно включать
		@param requiredTagGroups группы тэгов, которые должны быть представлены
		@param freeTagGroups     группы тэгов, которые не обязаны присутствовать
	*/
	public function __construct($name, $description, $keyWords, $forum, $exclusionTopics, $requiredTagGroups, $freeTagGroups) {
		$this->name = $name; // имя каталога
		$this->description = $description; // описание
		$this->keyWords = $keyWords; // ключевые слова
		$this->forum = $forum; // форум, из которого берутся записи
		$this->exclusionTopics = $exclusionTopics; // топики, которые не нужно включать
		$this->requiredTagGroups = $requiredTagGroups; // группы тэгов, которые должны быть представлены
		$this->freeTagGroups = $freeTagGroups; // группы тэгов, которые не обязаны присутствовать
	}

	/**
		Возвращает имя каталога.
	*/
	public function getName() {		return $this->name;	}

	/**
		Возвращает описание.
	*/
	public function getDescription() {
		return $this->description;
	}

	/**
		Возвращает ключевые слова.
	*/
	public function getKeyWords() {
		return $this->keyWords;
	}

	/**
		Возвращает форум, из которого беутся записи.
	*/
	public function getForum() {		return $this->forum;	}

	/**
		Возвращает топики, которые не нужно включать.
	*/
	public function getExclusionTopics() {
		return $this->exclusionTopics;
	}

	/**
		Возвращает группы тэгов, которые должны быть представлены.
	*/
	public function getRequiredTagGroups() {
		return $this->requiredTagGroups;
	}

	/**
		Возвращает группы тэгов, которые не обязаны присутствовать.
	*/
	public function getFreeTagGroups() {
		return $this->freeTagGroups;
	}


	private $name; // имя каталога
	private $description; // описание
	private $keyWords; // ключевые слова
	private $forum; // форум, из которого берутся записи
	private $exclusionTopics; // топики, которые не нужно включать
	private $requiredTagGroups; // группы тэгов, которые должны быть представлены
	private $freeTagGroups; // группы тэгов, которые не обязаны присутствовать
}
