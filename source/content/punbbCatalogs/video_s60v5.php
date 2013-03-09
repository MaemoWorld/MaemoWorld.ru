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

General::$data['punbb_catalogs']['video_s60v5'] = array ( // описание каталога
	'name'                => 'Видео: фильмы, мультфильмы и сериалы для устройств на Symbian S60v5 и Symbian^3', // имя каталога
	'description'         => 'Скачать бесплатно видео (фильмы, мультфильмы, сериалы, передачи, концерты, клипы) для устройств на Symbian S60v5 (Nokia 5228, Nokia 5230, Nokia 5235, Nokia 5250, Nokia 5530, Nokia 5800, Nokia C6-00, Nokia N97, Nokia N97 mini, Nokia X6)', // описание
	'key_words'           => array ( // ключевые слова
		'скачать бесплатно',
		'Symbian 9.4', 'Symbian S60v5', 'Symbian', 'S60v5', 'Symbian^3', 'Nokia',
		'Nokia 5228', 'Nokia 5230', 'Nokia 5235', 'Nokia 5250', 'Nokia 5530', 'Nokia 5800', 'Nokia C6-00', 'Nokia N97', 'Nokia N97 mini', 'Nokia X6'
	),
	'forum'               => 15, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		106, // правила раздела
		4415, // о навигаторе
		999 // стол заказов
	),
	'required_tag_groups' => array ( // группы тэгов, которые должны быть представлены
		'platforms' => array ( // описание группы тэгов
			'name' => 'Платформы', // имя группы
			'tags' => array ( // тэги
 				362 // S60v5
 			)
		)
	),
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'genres'    => General::$data['punbb_tag_groups']['video_genres'],
		'types'     => General::$data['punbb_tag_groups']['video_types'],
		'qualities' => General::$data['punbb_tag_groups']['video_qualities'],
		'lengths'   => General::$data['punbb_tag_groups']['video_lengths'],
		'directors' => General::$data['punbb_tag_groups']['video_directors'],
		'countries' => General::$data['punbb_tag_groups']['countries'],
		'years'     => General::$data['punbb_tag_groups']['years'],
		'universes' => General::$data['punbb_tag_groups']['video_universes']
	)
);
