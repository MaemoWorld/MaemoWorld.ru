<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'platforms.php';
require_once $config['punbb_tags_dir'].'game_genres.php';
require_once $config['punbb_tags_dir'].'game_controls.php';
require_once $config['punbb_tags_dir'].'game_multiplayer.php';
require_once $config['punbb_tags_dir'].'game_graphics.php';
require_once $config['punbb_tags_dir'].'maintainers.php';

General::$data['punbb_catalogs']['games'] = array ( // описание каталога
	'name'                => 'Игры для MeeGo и Maemo', // имя каталога
	'description'         => 'Скачать бесплатно игры для устройств на MeeGo (Nokia N9) и Maemo (Nokia N900, Nokia N810, Nokia N800, Nokia 770)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'игры',
		'MeeGo', 'Maemo',
		'Nokia N9',
		'Nokia N900', 'Nokia N810', 'Nokia N800', 'Nokia 770',
	),
	'forum'               => 13, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		26, // правила раздела
		1609, // о навигаторе
		158 // сайты - источники игр
	),
	'required_tag_groups' => array (), // группы тэгов, которые должны быть представлены
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
 		'platforms'   => General::$data['punbb_tag_groups']['platforms'],
		'genres'      => General::$data['punbb_tag_groups']['game_genres'],
		'controls'    => General::$data['punbb_tag_groups']['game_controls'],
		'multiplayer' => General::$data['punbb_tag_groups']['game_multiplayer'],
		'graphics'    => General::$data['punbb_tag_groups']['game_graphics'],
		'maintainers' => General::$data['punbb_tag_groups']['maintainers']
	)
);
