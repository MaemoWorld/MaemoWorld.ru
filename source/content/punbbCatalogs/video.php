<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'countries.php';
require_once $config['punbb_tags_dir'].'video_directors.php';
require_once $config['punbb_tags_dir'].'video_genres.php';
require_once $config['punbb_tags_dir'].'video_lengths.php';
require_once $config['punbb_tags_dir'].'video_platforms.php';
require_once $config['punbb_tags_dir'].'video_qualities.php';
require_once $config['punbb_tags_dir'].'video_types.php';
require_once $config['punbb_tags_dir'].'video_universes.php';
require_once $config['punbb_tags_dir'].'years.php';

General::$data['punbb_catalogs']['video'] = array ( // описание каталога
	'name'                => 'Видео: фильмы, мультфильмы и сериалы', // имя каталога
	'description'         => 'Скачать бесплатно видео (фильмы, мультфильмы, сериалы, передачи, концерты, клипы)', // описание
	'key_words'           => 	array ( // ключевые слова
		'скачать бесплатно',
		'MeeGo', 'Maemo', 'Symbian^3', 'Symbian',
		'Nokia N9',
		'Nokia N900', 'Nokia N810', 'Nokia N800', 'Nokia 770',
		'Nokia N8', 'Nokia C6-01', 'Nokia C7-00', 'Nokia E7'
	),
	'forum'               => 15, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		106, // правила раздела
		4415, // о навигаторе
		999 // стол заказов
	),
	'required_tag_groups' => array (), // группы тэгов, которые должны быть представлены
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'genres'    => General::$data['punbb_tag_groups']['video_genres'],
		'types'     => General::$data['punbb_tag_groups']['video_types'],
		'qualities' => General::$data['punbb_tag_groups']['video_qualities'],
		'lengths'   => General::$data['punbb_tag_groups']['video_lengths'],
		'directors' => General::$data['punbb_tag_groups']['video_directors'],
		'countries' => General::$data['punbb_tag_groups']['countries'],
		'years'     => General::$data['punbb_tag_groups']['years'],
		'universes' => General::$data['punbb_tag_groups']['video_universes'],
		'platforms' => General::$data['punbb_tag_groups']['video_platforms']
	)
);
