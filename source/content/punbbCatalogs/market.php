<?php
if (!isset($config)) exit('Config must be loaded.'); // выйти, если не загружены настройки
require_once $config['punbb_tags_dir'].'cities.php';
require_once $config['punbb_tags_dir'].'market_offers.php';
require_once $config['punbb_tags_dir'].'market_devices.php';
require_once $config['punbb_tags_dir'].'market_targets.php';

General::$data['punbb_catalogs']['market'] = array ( // описание каталога
	'name'                => 'Барахолка: продам, куплю, обменяю', // имя каталога
	'description'         => 'Купить, продать или обменять устройства, аксессары, комплектующие', // описание
	'key_words'           => array ( // ключевые слова
		'MeeGo', 'Maemo',
	),
	'forum'               => 25, // форум, из которого берутся записи
	'exclusion_topics'    => array ( // топики, которые не нужно включать
		3564, // правила раздела
		4416 // о навигаторе
	),
	'required_tag_groups' => array (), // группы тэгов, которые должны быть представлены
	'free_tag_groups'     => array ( // группы тэгов, которые не обязаны быть представлены
		'offers'  => General::$data['punbb_tag_groups']['market_offers'],
		'targets' => General::$data['punbb_tag_groups']['market_targets'],
		'devices' => General::$data['punbb_tag_groups']['market_devices'],
		'cities'  => General::$data['punbb_tag_groups']['cities']
	)
);
