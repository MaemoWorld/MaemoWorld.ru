<?php
////////////////////////////////////////////////////////////////
// Настроки путей для подключаемых файлов.
////////////////////////////////////////////////////////////////
if (!defined('PATHS_SEPARATOR')): // если не определен разделитель путей
	define('PATHS_SEPARATOR', getenv('COMSPEC') ? ';' : ':'); // если винда, то ';', линукс - ':'
endif;
ini_set('include_path', ini_get('include_path').PATHS_SEPARATOR.'..'.PATHS_SEPARATOR.'../content'.PATHS_SEPARATOR.'../include'); // добавляем каталоги 'include' и 'content'

require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb
$config['templates']['dir'] = '../include/templates/';

$data['page']['powered_by'] = '<a href="http://wordpress.org/">WordPress</a>';
General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
	'name' => 'Новости',
	'link' => blog_url(false)
);
if ( is_archive() ) {
	General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
		'name' => 'Архив',
		'link' => null
	);
}
$wpTitle = wp_title('', false, 'right');
if ($wpTitle) {
	General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
		'name' => $wpTitle,
		'link' => null
	);
}
// templates::$pageTitle = get_bloginfo('name'); // получаем имя блога
// templates::$pageDescription = get_bloginfo('description'); // получаем описание страницы
ob_start();
	the('<link rel="pingback" href="'.blog_url(false).'/xmlrpc.php" />'."\n");
//	the('<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />'."\n");
	// wp_get_archives('type=monthly&format=link');
	// wp_head();
Template::addPageHeadExtra(ob_get_clean());
//ob_start();
//	if (is_user_logged_in()) {
//		the(get_num_queries().' queries in '); timer_stop(1); the(' seconds.');
//	}
//templates::$pageAddToFooter = ob_get_contents();
//ob_end_clean();
ob_start();
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) :
	endif;
Template::addPageSidebarExtra(ob_get_clean());
