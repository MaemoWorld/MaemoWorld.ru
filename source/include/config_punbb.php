<?php
/*******************************************************************************
*                                                                              *
*  Настройки PunBB.                                                            *
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

require_once 'config_general.php';
$config['punbb'] = array( // настройки punbb
	'url' => $config['host_url'].'/forum', // ссылка на punbb
	'dir' => $config['$root_dir'].'/forum' // каталог punbb
);
@include_once '.'.$config['punbb']['dir'].'/config.php'; // файл с настройками punbb
@include_once '.'.$config['punbb']['dir'].'/cache/cache_config.php'; // файл с кэшем punbb
// todo: где-то баг с определением путей, поэтому первый вариант не подхватывается
@include_once '..'.$config['punbb']['dir'].'/config.php'; // файл с настройками punbb
@include_once '..'.$config['punbb']['dir'].'/cache/cache_config.php'; // файл с кэшем punbb
$config['punbb']['db'] = array( // настройки для подключения к БД
	'host'     => $db_host,     // сервер
	'name'     => $db_name,     // имя базы данных
	'user'     => $db_username, // имя пользователя
	'password' => $db_password, // пароль
	'prefix'   => $db_prefix    // префикс, используемый для имен таблиц
);
$config['punbb']['cookie'] = array( // настройки для работы с куки
	'name'   => $cookie_name, // имя куки для punbb
	'expire' => $config['cookie']['expire'], // время устаревания куки
	'domain' => $cookie_domain, // домен куки
	'path'   => $cookie_path, // путь к куки
	'secure' => $cookie_secure // безопасны ли куки
);
$config['punbb']['timeout_visit'] = $forum_config['o_timeout_visit']; // таймаут посещения
