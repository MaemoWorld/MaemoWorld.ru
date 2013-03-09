<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'app_genres.php';
require_once $config['punbb_tags_dir'].'app_types.php';
require_once $config['punbb_tags_dir'].'maintainers.php';

General::$data['punbb_catalogs']['apps_nokia_n9'] = array ( // описание каталога
	'name'                => 'Программы для Nokia N9 (MeeGO 1.2 Harmattan)', // имя каталога
	'description'         => 'Скачать бесплатно приложения для Nokia N9 (MeeGO 1.2 Harmattan)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'приложения',
		'MeeGo', 'MeeGo 1.2', 'Harmattan', 'Maemo 6', 'Nokia N9', 'Nokia N950'
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
 				2197 // Harmattan
 			)
 		)
 	),
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'genres'      => General::$data['punbb_tag_groups']['app_genres'],
		'types'       => General::$data['punbb_tag_groups']['app_types'],
		'maintainers' => General::$data['punbb_tag_groups']['maintainers']
	)
);
