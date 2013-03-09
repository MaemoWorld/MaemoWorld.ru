<?php
require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb


if (isset($_REQUEST['name'])): // если указано имя
	$tags = Punbb::getTagsbyName($_REQUEST['name']); // идентификатор тэга поставщика
	if (count($tags) > 0) { // если есть тэги с таким id
		$tagIds = array_keys($tags);
		$yagId = $tagIds[0];
	} else { // если нет тэгов с таким id
		$tadId = false;
	}
else:
	$tagId = false;
endif;

if (isset($_REQUEST['catalog'])): // если указан каталог
	$catalog = $_REQUEST['catalog']; // идентификатор каталога
else:
	$catalog = 'apps'; // по умолчанию идем в приложения
endif;

$domain = $_SERVER['HTTP_HOST']; // имя домена
Header('Location: http://'.$domain.'/navigator.php?catalog='.$catalog.'&tags%5B%5D='.$tagId); // редирект
exit;
