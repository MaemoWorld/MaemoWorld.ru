<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['video_types'] = array ( // описание группы тэгов
	'name' => 'Типы', // имя группы
	'tags' => array( // тэги
		73, // фильмы
		83 // мультфильмы
	)
);
