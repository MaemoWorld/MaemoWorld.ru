<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['app_types'] = array ( // описание группы тэгов
	'name' => 'Типы', // имя группы
	'tags' => array( // тэги
		18, // апплеты
		22, // виджеты
		309 // плагины
	)
);
