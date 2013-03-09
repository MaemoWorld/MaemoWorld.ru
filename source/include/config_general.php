<?php
/*******************************************************************************
*                                                                              *
*  Общие настроки.                                                             *
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

$config = array ( // ассоциативнй массив настроек
	'portal'              => array ( // информация о портале
		'name'            => 'MaemoWorld.ru', // имя сайта
		'subject'         => 'Firefox OS, Tizen, Mer, MeeGo, Maemo, WebOS', // тема сайта
		'description'     => 'MaemoWorld.ru - Nokia N9, Nokia N950, Nokia N900, Firefox OS, Tizen, Mer, Nemo, MeeGo, Harmattan, Maemo, WebOS, NITDroid, форум, обзоры, новости, программы, игры, цены, купить, отзывы, софт, фильмы, темы, обои, помощь' // описание сайта
	),
	'domain'              => $_SERVER['HTTP_HOST'], // домен
	'domain_aliases'      => array ('MaemoWorld.ru', 'meegos.ru', 'maemo.su'), // алиасы домена
	'cookie'              => array ( // настройки куки
		'expire'          => 1209600, // время устаревания в секундах
		'path'            => '/', // путь
		'secure'          => false // использовать ли безопасное соединение
	),
	'host_url'            => 'http://'.$_SERVER['HTTP_HOST'], // ссылка на хост
	'root_dir'            => $_SERVER['DOCUMENT_ROOT'], // корневой каталог
	'templates'           => array ( // параметры шаблонов
		'dir'             => $_SERVER['DOCUMENT_ROOT'].'/include/templates/' // каталог с шаблонами
	),
	'cache'               => array ( // настройки кэширования
		'dir'             => $_SERVER['DOCUMENT_ROOT'].'/cache' // каталог для кэша
	),
	'punbb_catalogs_dir'  => $_SERVER['DOCUMENT_ROOT'].'/content/punbbCatalogs/', // описание каталогов punbb
	'punbb_tags_dir'      => $_SERVER['DOCUMENT_ROOT'].'/content/punbbTags/', // описание тэгов punbb
	'yandex_catalogs_dir' => $_SERVER['DOCUMENT_ROOT'].'/content/yandexCatalogs/', // описание каталогов yandex	
);
