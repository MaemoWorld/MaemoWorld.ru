<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
General::$data['punbb_tag_groups']['market_devices'] = array ( // описание группы тэгов
	'name' => 'Устройства', // имя группы
	'tags' => array( // тэги
		1295, // WeTab
		1836, // Nokia X7
		1200, // Nokia X6
		67,   // Nokia N900
		865,  // Nokia N810
		864,  // Nokia N800
		1202, // Nokia N97 mini
		1203, // Nokia N97
		1501, // Nokia N9
		1193, // Nokia N8
		1318, // Nokia E7-00
		1219, // Nokia C7-00
		1196, // Nokia C6-01
		1304, // Nokia C6-00
		1835, // Nokia C5-03
		858,  // Nokia 5800
		1369, // Nokia 5530
		1380, // Nokia 5250
		1206, // Nokia 5235
		1204, // Nokia 5230
		1205, // Nokia 5228
		2215, // Nokia 701
		2214, // Nokia 700
		2216  // Nokia 600
	)
);
