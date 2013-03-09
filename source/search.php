<?php
/*******************************************************************************
*                                                                              *
*  Скрипт поиска.                                                              *
*                                                                              *
*  Copyright (C) 2012 Kirill Chuvilin.                                         *
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

$domain = $_SERVER['HTTP_HOST']; // имя домена

if (isset($_REQUEST['location'])): // если указана область поиска
	$location = strtolower($_REQUEST['location']); // область поиска
else:
	$location = 'google'; // область поиска по умолчанию
endif;

if ($location == 'google'): // если поиск в google
	if (isset($_REQUEST['site'])): // если указан сайт на котором искать
		$site = $_REQUEST['site']; // сайт
	else:
		$site = $domain	; // ищем в текущем домене
	endif;
endif;

$query = $_REQUEST['query']; // запрос поиска

if ($location == 'google'): // если поиск в google
//	Header('Location: http://www.google.ru/search?q='.$query.' site:'.$site.'&ie=utf-8&oe=utf-8&aq=t&rls='.$domain); // редирект
	Header('Location: http://www.google.com/webhp?rls='.$domain.'&domains='.$site.'&ie=UTF-8&oe=UTF-8&sitesearch='.$site.'#sclient=psy-ab&sitesearch='.$site.'&q='.$query.'&cx=partner-pub-0247061343724296:9160314993');
	exit;
//http://www.google.com/webhp?domains=http://meegos.ru&ie=UTF-8&oe=UTF-8&btnG=Search&sitesearch=http://meegos.ru#sclient=psy-ab&domains=http:%2F%2Fmeegos.ru&q=request&sitesearch=http:%2F%2Fmeegos.ru&fp=1
endif;
?>