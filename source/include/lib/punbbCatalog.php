<?php
/*******************************************************************************
*                                                                              *
*  Класс каталога топиков punbb.                                               *
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
