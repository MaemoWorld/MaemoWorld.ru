<?php
require_once 'config_general.php';
$config['punbb'] = array( // настройки punbb
	'url' => $config['host_url'].'/forum', // ссылка на punbb
	'dir' => $config['$root_dir'].'/forum' // каталог punbb
);
include_once $config['punbb']['dir'].'/config.php'; // файл с настройками punbb
include_once $config['punbb']['dir'].'/cache/cache_config.php'; // файл с кэшем punbb
$config['punbb']['db'] = array( // настройки для подключения к БД
	'host'     => $db_host,     // сервер
	'name'     => $db_name,     // имя базы данных
	'user'     => $db_username, // имя пользователя
	'password' => $db_password, // пароль
	'prefix'   => $db_prefix    // префикс, используемый для имен таблиц
);
$config['punbb']['cookie'] = array( // настройки для работы с куки
	'name'   => $cookie_name, // имя куки для punbb
	'expire' => $config['cookie']['expire'], // время устаревания куки
	'domain' => $cookie_domain, // домен куки
	'path'   => $cookie_path, // путь к куки
	'secure' => $cookie_secure // безопасны ли куки
);
$config['punbb']['timeout_visit'] = $forum_config['o_timeout_visit']; // таймаут посещения
