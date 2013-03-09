<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'game_genres.php';
require_once $config['punbb_tags_dir'].'game_controls.php';
require_once $config['punbb_tags_dir'].'game_multiplayer.php';
require_once $config['punbb_tags_dir'].'game_graphics.php';

General::$data['punbb_catalogs']['nitdroid_games'] = array ( // описание каталога
	'name'                => 'Игры для NITDroid (Google Android)', // имя каталога
	'description'         => 'Скачать бесплатно игры для NITDroid (Google Android)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'софт', 'программы', 'игры',
		'NITDroid', 'Google Android',
		'Nokia N900'
	),
	'forum'               => 7, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		4412, // правила раздела
		4414 // о навигаторе
	),
	'required_tag_groups' => array (), // группы тэгов, которые должны быть представлены
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'genres'      => General::$data['punbb_tag_groups']['game_genres'],
		'controls'    => General::$data['punbb_tag_groups']['game_controls'],
		'multiplayer' => General::$data['punbb_tag_groups']['game_multiplayer'],
		'graphics'    => General::$data['punbb_tag_groups']['game_graphics']
	)
);
