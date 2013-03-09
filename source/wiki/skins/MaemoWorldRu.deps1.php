<?php
// This file exists to ensure that base classes are preloaded before
// MonoBook.php is compiled, working around a bug in the APC opcode
// cache on PHP 5, where cached code can break if the include order
// changed on a subsequent page view.
// see http://lists.wikimedia.org/pipermail/wikitech-l/2006-January/021311.html

exit;
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

require_once( dirname( dirname( __FILE__ ) ) . '/includes/SkinTemplate.php');

if (!defined('PATHS_SEPARATOR')): // если не определен разделитель путей
	define('PATHS_SEPARATOR', getenv('COMSPEC') ? ';' : ':'); // если винда, то ';', линукс - ':'
endif;
ini_set('include_path', ini_get('include_path').PATHS_SEPARATOR.'..'.PATHS_SEPARATOR.'../content'.PATHS_SEPARATOR.'../include'); // добавляем каталоги 'include' и 'content'
//require_once 'config_general.php'; // найтройки 
//echo $config['root_dir'];
//require_once 'lib/punbb.php'; // работа с punbb
//$config['templates_dir'] = '../include/templates/';
