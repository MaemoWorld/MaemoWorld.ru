<?php
/*******************************************************************************
*                                                                              *
*  Управление авторизацией.                                                    *
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

require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb


switch ($_GET['action']) { // в зависимости от указанного типа действия
	case 'in':
	case 'out':
		$action = $_GET['action']; // указанный корректный тип действия
		break;
	default:
		$action = null; // нет действия
}


$userEmail = General::trim($_GET['email']); // e-mail для логина
$userPassword = General::trim($_GET['password']); // пароль для логина


switch ($action) { // в зависимости от типа действия
case 'in':
	if (Punbb::$user->isGuest()) Punbb::authenticateUser(Punbb::getAuthenticatedUser($userEmail, $userPassword)); // получить подходящего пользователя, если пользователь еще не авторизован
	switch (General::$contentType) { // в зависимости от типа запрашиваемых данных
	case 'json':
		echo json_encode(Punbb::$user->isGuest() ? false : Punbb::$user); // вывести результат авторизации
		exit;
	case 'html':
	default:
		if (Punbb::$user->isGuest()) { // если авторизация прошла неуспешно
			General::setNextRedirect(General::$redirect); // в следующий раз адрес перенаправления будет тот же
			Templates::$page = 'login'; // страница авторизации
			Templates::generatePage(); // сгенерировать страницу
		} else { // если авторизация успешна
			General::redirect(); // перейти по редиректу
		}
	}
	break;
case 'out':
//		if (Punbb::$user->isGuest()) General::redirect(); // перейти по редиректу, если пользователь не авторизован
	break;
default:
//		if (!Punbb::$user->isGuest()) General::redirect(); // перейти по редиректу, если пользователь уже авторизован
	switch (General::$contentType) {
	case 'json':
		echo json_encode(Punbb::$user);
		break;
	case 'html':
	default:
		// todo
	}
}
