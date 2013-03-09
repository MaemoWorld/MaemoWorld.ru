<?php
require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb


/*!
 * \brief Проверить наличие тэга среди выбранных.
 * \return true, если тэг выбран, иначе false
 * \param tagId id проверяемого тэга
 */
function isTagSelected($tagId) {
	global $selectedTagIds;
	return in_array($tagId, $selectedTagIds);
}


////////////////////////////////////////////////////////////////////////////////
// предобработка ввода
////////////////////////////////////////////////////////////////////////////////

General::$data['navigator'] = array(); // данные навигатора

if (isset($_GET['catalog'])) { // если указан каталог
	General::$data['navigator']['catalog']['id'] = $_GET['catalog']; // идентификатор каталога
	General::$data['navigator']['action'] = 'catalog'; // действие для обработки ссылки
} else {
	General::$data['navigator']['action'] = null; // действие по умолчанию
}

if (isset($_GET['sort-by'])) { // если указан параметр сортировки
	General::$data['navigator']['sort_by'] = $_GET['sort-by']; // запомнить параметр сортировки
} else { // если не указан параметр сортировки
	General::$data['navigator']['sort_by'] = 'post-id'; // по умолчанию сортировка по номеру сообщения
}

if (isset($_GET['sort-desc'])) { // если указано нужно ли сортировать по убыванию
	General::$data['navigator']['sort_desc'] = $_GET['sort-desc'] == 'true'; // запомнить направление сортировки
} else { // если не указано направление сортировки
	switch (General::$data['navigator']['sort_by']) { // в зависимости от ключа сортировки
	case 'subject':
		General::$data['navigator']['sort_desc'] = false; // по умолчанию сортировка по возрастанию
		break;
	default:
		General::$data['navigator']['sort_desc'] = true; // по умолчанию сортировка по убыванию
	}
}

if (isset($_GET['tags'])) { // если указаны тэги
	$selectedTagIds = $_GET['tags'];
} else { // если тэги не указаны
	$selectedTagIds = array(); // пусой массив тэгов
}

////////////////////////////////////////////////////////////////////////////////
// исполнение скрипта
////////////////////////////////////////////////////////////////////////////////

$catalogFiles = scandir($config['punbb_catalogs_dir']); // список файлов каталога
foreach ($catalogFiles as $fileName) { // по всем файлам каталога
	if (($fileName == '.') || ($fileName == '..') || ($fileName == '.htaccess')) continue; // игнорировать "." и ".."
		include_once $config['punbb_catalogs_dir'].$fileName; // подключить файл с описанием каталога
}
General::$data['navigator']['catalogs'] = General::$data['punbb_catalogs']; // список каталогов


if (!is_null(General::$data['page']['breadcrumbs'])) { // если рассыпаются хлебные крошки
	General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
		'name' => 'Навигатор',
		'link' => navigator_url(false)
	);
}

switch (General::$data['navigator']['action']) { // в зависимости от типа действия
case 'catalog': // если нужно показать каталог
	if (array_key_exists(General::$data['navigator']['catalog']['id'], General::$data['navigator']['catalogs'])) { // если есть такой каталог
		$catalog = General::$data['navigator']['catalogs'][General::$data['navigator']['catalog']['id']]; // описание каталога
		General::$data['navigator']['catalog']['name'] = $catalog['name']; // название каталога
		$usedTagIds = array(); // используемые тэги
		foreach ($catalog['required_tag_groups'] as $groupId => $group) { // по всем группам тэгов
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['name'] = $group['name']; // имя группы тэгов
			$usedTagIds = array_merge($usedTagIds, $group['tags']); // добавить тэги группы к используемым
			$tagStates = array_map("isTagSelected", $group['tags']); // состояние выбранности тэгов
			if (!in_array(true, $tagStates)) $tagStates = array_fill(0, count($tagStates), true); // выбрать все, если не выбан ни один тэг
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['tags'] = array_combine($group['tags'], $tagStates); // ассоциативный массив тэгов группы и их состояний
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['is_required'] = true;
		}
		foreach ($catalog['free_tag_groups'] as $groupId => $group) { // по всем группам тэгов
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['name'] = $group['name']; // имя группы тэгов
			$usedTagIds = array_merge($usedTagIds, $group['tags']); // добавить тэги группы к используемым
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['tags'] = array_combine($group['tags'], array_map("isTagSelected", $group['tags'])); // ассоциативный массив тэгов группы и их состояний
			General::$data['navigator']['catalog']['tag_groups'][$groupId]['is_required'] = false;
		}
		General::$data['navigator']['tags'] = Punbb::getTagsById($usedTagIds); // ссоциативный массив идентификаторов и имен используемых тэгов
		// получение записей
		// todo: вернуть тексты сообщений
//		$query = 'SELECT DISTINCT topics.id AS topic_id, posts.id AS post_id, topics.subject AS subject, posts.message AS message FROM '.$config['punbb']['db']['prefix'].'topics AS topics, '.$config['punbb']['db']['prefix'].'posts AS posts'; // начало запроса
		$query = 'SELECT DISTINCT topics.id AS topic_id, posts.id AS post_id, topics.subject AS subject FROM '.$config['punbb']['db']['prefix'].'topics AS topics, '.$config['punbb']['db']['prefix'].'posts AS posts'; // начало запроса
		foreach (General::$data['navigator']['catalog']['tag_groups'] as $tagGroupId => $tagGroup) { // по всем группам тэгов
			if (in_array(true, $tagGroup['tags'])) { // если есть выбранные тэги
				$query .= ', '.$config['punbb']['db']['prefix'].'topic_tags AS '.$tagGroupId.'_tags'; // добавить таблицы для выбора
			}
		}
		$query = $query.' WHERE ( topics.first_post_id = posts.id ) AND ( topics.forum_id = '.$catalog['forum'].' )';
		foreach (General::$data['navigator']['catalog']['tag_groups'] as $tagGroupId => $tagGroup) { // по всем группам тэгов
			$selectedGroupTagIds = array_keys($tagGroup['tags'], true); // все выбранные тэги группы
			if (count($selectedGroupTagIds) > 0) { // если есть выбранные тэги
				$query .= ' AND ( topics.id = '.$tagGroupId.'_tags.topic_id )'; // согласование для тегов с топиком
				$query .= ' AND ( '.$tagGroupId.'_tags.tag_id IN ('.implode(',', $selectedGroupTagIds).') )'; // согласование для id тэгов
			}
		}
		$query .= ' ORDER BY '; // параметр сортировки
		switch (General::$data['navigator']['sort_by']) { // в зависимости от ключа сортировки
		case 'subject': // сортировка по теме
			$query .= 'subject';
			break;
		case 'post-id': // сортировка по id сообщения
		default:
			$query .= 'post_id';
		}
		if (General::$data['navigator']['sort_desc']) $query .= ' DESC'; // если сортировка по убыванию
//		$query .= ' LIMIT 0 , 300';
		Punbb::$db->query($query); // выполнить запрос
		General::$data['navigator']['items'] = Punbb::$db->resultArrayWithKeys(); // возвращаем результат запроса
		switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
		case 'json':
			echo json_encode(General::$data['navigator']); // вывести результат
			exit;
		case 'html':
		default:
			General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
				'name' => General::$data['navigator']['catalog']['name'],
				'link' => navigator_catalog_url(General::$data['navigator']['catalog']['id'], false)
			);
			General::$data['page']['description'] = General::$data['navigator']['catalog']['description']; // описание страницы
			General::$data['page']['key_words'] = array_merge($catalog['key_words'], General::$data['navigator']['tags']); // ключевые слова страницы
			Template::generatePage('navigator', 'catalog'); // сгенерировать страницу
			exit;
		}
	} else { // нет такого каталога
		switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
		case 'json':
			echo json_encode(false); // вывести результат
			exit;
		case 'html':
		default:
			Template::generatePage('404'); // страница с 404
			exit;
		}
	}
	break;
default:
	switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
	case 'json':
		echo json_encode(General::$data['navigator']); // вывести результат
		exit;
	case 'html':
	default:
		Template::generatePage('navigator'); // сгенерировать страницу
		exit;
	}
}
