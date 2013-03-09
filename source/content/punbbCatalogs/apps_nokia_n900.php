<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'app_genres.php';
require_once $config['punbb_tags_dir'].'app_types.php';
require_once $config['punbb_tags_dir'].'maintainers.php';

General::$data['punbb_catalogs']['apps_nokia_n900'] = array ( // описание каталога
	'name'                => 'Программы для Nokia N900 (Maemo 5)', // имя каталога
	'description'         => 'Скачать бесплатно приложения для Nokia N900 (Maemo 5)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'приложения',
		'Maemo', 'Maemo 5', 'Nokia N900'
	),
	'forum'               => 12, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		54, // правила раздела
		1607, // о навигаторе
		157 // сайты - источники приложений
	),
	'required_tag_groups' => array ( // группы тэгов, которые должны быть представлены
 		'platforms' => array ( // описание группы
 			'name' => 'Платформы', // имя группы
 			'tags' => array ( // тэги
 				15 // Maemo 5
 			)
 		)
 	),
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'genres'      => General::$data['punbb_tag_groups']['app_genres'],
		'types'       => General::$data['punbb_tag_groups']['app_types'],
		'maintainers' => General::$data['punbb_tag_groups']['maintainers']
	)
);
