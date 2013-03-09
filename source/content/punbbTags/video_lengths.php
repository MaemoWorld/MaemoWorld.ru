<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['video_lengths'] = array ( // описание группы тэгов
	'name' => 'Продолжительность', // имя группы
	'tags' => array( // тэги
		80, // сериалы
		90 // короткометражки
	)
);
