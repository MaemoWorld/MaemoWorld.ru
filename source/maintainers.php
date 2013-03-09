<?php
/*******************************************************************************
*                                                                              *
*  Информация о поставщиках софта.                                             *
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

require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb


if (isset($_REQUEST['name'])): // если указано имя
	$tags = Punbb::getTagsbyName($_REQUEST['name']); // идентификатор тэга поставщика
	if (count($tags) > 0) { // если есть тэги с таким id
		$tagIds = array_keys($tags);
		$yagId = $tagIds[0];
	} else { // если нет тэгов с таким id
		$tadId = false;
	}
else:
	$tagId = false;
endif;

if (isset($_REQUEST['catalog'])): // если указан каталог
	$catalog = $_REQUEST['catalog']; // идентификатор каталога
else:
	$catalog = 'apps'; // по умолчанию идем в приложения
endif;

$domain = $_SERVER['HTTP_HOST']; // имя домена
Header('Location: http://'.$domain.'/navigator.php?catalog='.$catalog.'&tags%5B%5D='.$tagId); // редирект
exit;
