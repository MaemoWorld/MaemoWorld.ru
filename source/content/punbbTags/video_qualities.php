<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['video_qualities'] = array ( // описание группы тэгов
	'name' => 'Качество', // имя группы
	'tags' => array( // тэги
		79,   // HDTV Rip
		76,   // DVD Rip
		391,  // SAT Rip
		1382  // TS
	)
);
