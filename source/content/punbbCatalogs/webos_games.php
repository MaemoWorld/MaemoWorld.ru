<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'game_genres.php';
require_once $config['punbb_tags_dir'].'webos_distribution.php';
require_once $config['punbb_tags_dir'].'game_controls.php';
require_once $config['punbb_tags_dir'].'game_multiplayer.php';
require_once $config['punbb_tags_dir'].'game_graphics.php';

General::$data['punbb_catalogs']['webos_games'] = array ( // описание каталога
	'name'                => 'Игры WebOS для MeeGo и Maemo', // имя каталога
	'description'         => 'Скачать бесплатно игры WebOS (Palm Pre) для устройств на Maemo 5 (Nokia N900)', // описание
	'key_words'           => 	array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'игры',
		'WebOS', 'Palm Pre',
		'MeeGo', 'Maemo',
		'Nokia N9',
		'Nokia N900', 'Nokia N810', 'Nokia N800', 'Nokia 770',
	),
	'forum'               => 43, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		3132, // правила раздела
		4413, // о навигаторе
		3760 // ищем ipk-файлы
	),
	'required_tag_groups' => array ( // группы тэгов, которые должны быть представлены
	),
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'distribution' => General::$data['punbb_tag_groups']['webos_distribution'],
		'genres'       => General::$data['punbb_tag_groups']['game_genres'],
		'controls'     => General::$data['punbb_tag_groups']['game_controls'],
		'multiplayer'  => General::$data['punbb_tag_groups']['game_multiplayer'],
		'graphics'     => General::$data['punbb_tag_groups']['game_graphics']
	)
);
