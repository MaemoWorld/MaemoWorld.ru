<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'platforms.php';
require_once $config['punbb_tags_dir'].'app_genres.php';
require_once $config['punbb_tags_dir'].'app_types.php';
require_once $config['punbb_tags_dir'].'maintainers.php';

General::$data['punbb_catalogs']['apps'] = array ( // описание каталога
	'name'                => 'Программы для MeeGo и Maemo', // имя каталога
	'description'         => 'Скачать бесплатно приложения для устройств на MeeGo (Nokia N9) и Maemo (Nokia N900, Nokia N810, Nokia N800, Nokia 770)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'приложения',
		'MeeGo', 'Maemo',
		'Nokia N9',
		'Nokia N900', 'Nokia N810', 'Nokia N800', 'Nokia 770',
	),
	'forum'               => 12, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		54, // правила раздела
		1607, // о навигаторе
		157 // сайты - источники приложений
	),
	'required_tag_groups' => array (), // группы тэгов, которые должны быть представлены
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
 		'platforms'   => General::$data['punbb_tag_groups']['platforms'],
		'genres'      => General::$data['punbb_tag_groups']['app_genres'],
		'types'       => General::$data['punbb_tag_groups']['app_types'],
		'maintainers' => General::$data['punbb_tag_groups']['maintainers']
	)
);
