<?php
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
