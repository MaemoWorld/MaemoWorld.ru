<?php
////////////////////////////////////////////////////////////////
// Настроки путей для подключаемых файлов.
////////////////////////////////////////////////////////////////
if (!defined('PATHS_SEPARATOR')): // если не определен разделитель путей
	define('PATHS_SEPARATOR', getenv('COMSPEC') ? ';' : ':'); // если винда, то ';', линукс - ':'
endif;
ini_set('include_path', ini_get('include_path').PATHS_SEPARATOR.'./content'.PATHS_SEPARATOR.'./include'); // добавляем каталоги 'include' и 'content'
?>