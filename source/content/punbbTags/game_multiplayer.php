<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['game_multiplayer'] = array ( // описание группы тэгов
	'name' => 'Мультиплеер', // имя группы
	'tags' => array( // тэги
		11, // многопользовательские
		2016 // сетевые
	)
);
