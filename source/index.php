<?php
require_once './include/config.php';
require_once './include/lib/punbb.php';

switch (General::$contentType) { // в зависимости от типа запрашиваемых данных
case 'json':
	echo 'content-type: '.general::$contentType.', viewport: '.general::$viewport.', redirect: '.general::$redirect.'<br><br>';
	echo json_encode(Punbb::$user).'<br><br>';
	echo json_encode($_COOKIE);
	exit;
case 'html':
default:
	Template::generatePage('index'); // сгенерировать страницу
}
