<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'game_genres.php';
require_once $config['punbb_tags_dir'].'game_controls.php';
require_once $config['punbb_tags_dir'].'game_multiplayer.php';
require_once $config['punbb_tags_dir'].'game_graphics.php';
require_once $config['punbb_tags_dir'].'maintainers.php';

General::$data['punbb_catalogs']['games_nokia_n900'] = array ( // описание каталога
	'name'                => 'Игры для Nokia N900 (Maemo 5)', // имя каталога
	'description'         => 'Скачать бесплатно игры для Nokia N900 (Maemo 5)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'игры',
		'Maemo', 'Maemo 5', 'Nokia N900'
	),
	'forum'               => 13, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		26, // правила раздела
		1609, // о навигаторе
		158 // сайты - источники игр
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
		'genres'      => General::$data['punbb_tag_groups']['game_genres'],
		'controls'    => General::$data['punbb_tag_groups']['game_controls'],
		'multiplayer' => General::$data['punbb_tag_groups']['game_multiplayer'],
		'graphics'    => General::$data['punbb_tag_groups']['game_graphics'],
		'maintainers' => General::$data['punbb_tag_groups']['maintainers']
	)
);
