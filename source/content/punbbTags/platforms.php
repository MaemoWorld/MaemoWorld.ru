<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['platforms'] = array ( // описание группы тэгов
	'name' => 'Платформы', // имя группы
	'tags' => array( // тэги
		2197, // Harmattan
		2198, // MeeGo 1
		15, // Maemo 5
		5, // OS2008
		4, // OS2007
		3 // OS2006
	)
);
