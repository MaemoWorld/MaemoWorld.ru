<?php
	echo 'htaccess: '.((!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) == 'off') ? 'http://' : 'https://').$_SERVER['SERVER_NAME'].((isset($_SERVER['SERVER_PORT']) && (($_SERVER['SERVER_PORT'] != '80' && $protocol == 'http://') || ($_SERVER['SERVER_PORT'] != '443' && $protocol == 'https://')) && strpos($_SERVER['HTTP_HOST'], ':') === false) ? ':'.$_SERVER['SERVER_PORT'] : '').$_SERVER['REQUEST_URI'];
	
/*	require_once 'include.php'; // пути для подключаемых файлов
	require_once 'lib/templates.php'; // работа с шаблонами

	if (isset($_REQUEST['page'])): // если указана страница
		$page = $_REQUEST['page']; // куда идем
		//401
		//403
		//500
		if ($page == '404') {
			templates::$pageTitle = 'Страница не найдена - MaemoWorld.ru'; // задаем заголовок страницы
			templates::page('404'); // страница с ошибкой 404
		} else {
			templates::$pageTitle = 'Страница не найдена - MaemoWorld.ru'; // задаем заголовок страницы
			templates::page('404'); // страница с ошибкой 404
		}
	else: // страница не указана
//		if (($_SERVER['REQUEST_URI'] == '') || ($_SERVER['REQUEST_URI'] == '/') || ($_SERVER['REQUEST_URI'] == '/index.php')):
//			Header('Location: '.config::$hostUrl.'/navigator.php'); // переходим в навигатор
//		else:
			Header('Location: '.config::$hostUrl.'/blog'.$_SERVER['REQUEST_URI']); // переходим в блог
//		endif;
		exit;
	endif;
*/
