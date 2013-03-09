<?php
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
