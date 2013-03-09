<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['market_offers'] = array ( // описание группы тэгов
	'name' => 'Предложения', // имя группы
	'tags' => array( // тэги
		833, // Продам
		832, // Куплю
		857 // Обменяю
	)
);
