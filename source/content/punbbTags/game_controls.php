<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['game_controls'] = array ( // описание группы тэгов
	'name' => 'Управление', // имя группы
	'tags' => array( // тэги
		26, // акселерометр
		115, // клавиатура
		1602, // синглтач
		2487 // мультитач
	)
);
