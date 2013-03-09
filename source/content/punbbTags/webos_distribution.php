<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['webos_distribution'] = array ( // описание группы тэгов
	'name' => 'Распространение', // имя группы
	'tags' => array( // тэги
		541, // deb
		1759 // ipk
	)
);
