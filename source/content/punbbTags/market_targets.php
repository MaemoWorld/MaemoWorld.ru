<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['market_targets'] = array ( // описание группы тэгов
	'name' => 'Тип товаров', // имя группы
	'tags' => array( // тэги
		838, // Устройства
		855, // Аксессуары
		1133, // Комплектующие
		1132 //  Программное обеспечение
	)
);
