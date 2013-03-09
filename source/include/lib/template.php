<?php
/*******************************************************************************
*                                                                              *
* Библиотека для обработки шаблонов.                                           *
*  v1.01                                                                       *
*  Совместимость: PHP 5                                                        *
*  by Кирилл Чувилин aka KiRiK (kirik-ch.ru)                                   *
*                                                                              *
*  Реализован в рамках проекта MaemoWorld.ru                                   *
*                                                                              *
*  Запрещено использование библиотеки или ее фрагментов:                       *
*  - в коммерческих проектах                                                   *
*  - без указания информации об авторстве                                      *
*                                                                              *
*  Для поддержки развития проекта или  просто благодарности можете пополнить   *
* яндекс-счет 41001384352607.                                                  *
*                                                                              *
*******************************************************************************/

require_once 'general.php'; // общий подключаемый файл

class Template { // пространство имен шаблонов
//	public static $pageAddToHead = "\n" ; // что нужно добавить в тег head
//	public static $pageAddToFooter = "\n" ; // что нужно добавить перед </body></html>
//	public static $pageAddToSidebar = "\n" ; // что нужно добавить в общую боковую панель

	private static $pageType; // тип страницы
	private static $pageSubtype; // подтип страницы
	private static $pageHeadExtra = ''; // ополнительное содержание head
	private static $pageSidebarExtra = ''; // ополнительное содержание боковой панели

	// для работы с sharemenu
	public static $sharemenu_url; // ссылка
	public static $sharemenu_title; // заголовок
	public static $sharemenu_tags; // строка тэгов
	public static $sharemenu_description; // описание

	// для работы с bodybox
	public static $bodybox_header; // шапка
	public static $bodybox_body; // тело
	public static $bodybox_footer; // подвал
	public static $bodybox_type; // тип
	public static $bodybox_params; // дополнительные параметры тэга бокса в виде ассоциативного массиваы

	// для работы с sidebox
	public static $sidebox_title; // заголовок
	public static $sidebox_body; // тело
	public static $sidebox_type; // тип
	public static $sidebox_params; // дополнительные параметры тэга бокса в виде ассоциативного массиваы

	// для работы с комментариями
	public static $comments_topicId; // идентификатор топика комментариев
	
	/*!
	 * \brief Получить тип страницы.
	 */
	public static function getPageType() {return Template::$pageType;}


	/*!
	 * \brief Получить подтип страницы.
	 */
	public static function getPageSubtype() {return Template::$pageSubtype;}


	/*!
	 * \brief Добавить дополнительное содержание к тэгу head.
	 * \param html код содержания
	 */
	public static function addPageHeadExtra($html) {Template::$pageHeadExtra .= $html;}


	/*!
	 * \brief Добавить дополнительное содержание к боковой панели страницы.
	 * \param html код содержания
	 */
	public static function addPageSidebarExtra($html) {Template::$pageSidebarExtra .= $html;}


	/*!
	 * \brief Получить путь к файлу шаблона.
	 * \param template название шаблона
	 */
	public static function getFilePath($template) {
		global $config;
		return $config['templates']['dir'].General::getViewport().'_'.$template.'.php';
	}


	/*!
	 * \brief Подключить файл шаблона.
	 * \param template название шаблона
	 */
	public static function insert($template) {include Template::getFilePath($template);}


	/*!
	 * \brief Сгенерировать страницу.
	 * \param pageType тип страницы
	 * \param pageSubtype подтип страницы
	 */
	public static function generatePage($pageType, $pageSubtype = false) {
		Template::$pageType = $pageType;
		Template::$pageSubtype = $pageSubtype;
		Template::insert('page');	}


	/*!
	 * \brief Получить шаблон тела страницы.
	 * \return имя шаблона
	 */
	public static function getPageBodyTemplate() {
		if (Template::$pageSubtype) { // если указана подстраница
			return 'body_'.Template::$pageType.'_'.Template::$pageSubtype;
		} else { // если подстраница не указана
			return 'body_'.Template::$pageType;
		}
	}


	/*!
	 * \brief Получить шаблон боковой панели страницы.
	 * \return имя шаблона
	 */
	public static function getPageSidebarTemplate() {return 'sidebar_'.Template::$pageType;}


	/*!
	 * \brief Получить адрес, с которого послан запрос к сайту.
	 */
	public static function getRemoteAddr() {return General::getRemoteAddr();}


	/*!
	 * \brief Получить описание программы, через которую запрашивается страница.
	 * \return ассоциативный массив с описанием программы, значение поля массива, если задан ключ, или false, если не удается определить
	 * \param key ключ массива
	 */
	public static function getUserAgent($key = null) {return General::getUserAgent($key);}
	
	
	/*!
	 * \brief Получить ссылку на текущую страницу.
	 */
	public static function getPageUrl() {return General::getUrl();}


	/*!
	 * \brief Получить ссылку на текущую страницу в другом представлении.
	 * \param viewport другое представление
	 */
	public static function getPageViewportUrl($viewport) {
		if (count($_GET) > 0) { // если что-то было передано через строку адреса
			return General::getUrl().'&viewport='.$viewport;
		} else { // если в строке адреса не было параметров
			return General::getUrl().'?viewport='.$viewport;
		}
	}
	
	
	/*!
	 * \brief Получить заголовок страницы.
	 */
	public static function getPageTitle() {
		$pageTitle = Template::getPortalName(); // заголовок страницы
		foreach (General::$data['page']['breadcrumbs'] as $breadcrumb) { // по всем хлебным крошкам
			$pageTitle = $breadcrumb['name'].' « '.$pageTitle;
		}
		return $pageTitle;
	}


	/*!
	 * \brief Получить описание страницы.
	 */
	public static function getPageDescription() {
		global $config;
		return (General::$data['page']['description'] ? General::$data['page']['description'].' - ' : '').$config['portal']['description'];
	}


	/*!
	 * \brief Получить ключевые слова страницы.
	 */
	public static function getPageKeyWords() {
		if (General::$data['page']['key_words'])
			return implode(', ', General::$data['page']['key_words']);
		else
			return '';
	}


	/*!
	 * \brief Получить информацию о механизме страницы.
	 */
	public static function getPagePoweredBy() {
		if (!General::$data['page']['powered_by']) return '<a href="http://MaemoWorld.ru">MaemoWorld.ru</a>';
		return General::$data['page']['powered_by'];
	}


	/*!
	 * \brief Пероверить существование шаблона собственной боковой панели страницы.
	 * \return true, если шаблон, иначе false
	 */
	public static function getPageExistsOwnSidebar() {return file_exists(Template::getFilePath(Template::getPageSidebarTemplate()));}


	/*!
	 * \brief Получить имя сайта.
	 */
	public static function getPortalName() {
		global $config;
		return $config['portal']['name'];
	}


	/*!
	 * \brief Получить тему сайта.
	 */
	public static function getPortalSubject() {
		global $config;
		return $config['portal']['subject'];
	}


	/*!
	 * \brief Получить описание сайта.
	 */
	public static function getPortalDescription() {
		global $config;
		return $config['portal']['description'];
	}


	/*!
	 * \brief Получить ссылку на корень сайта.
	 */
	public static function getHostUrl() {
		global $config;
		return $config['host_url'];
	}


	/*!
	 * \brief Получить url js-файла.
	 * \param scriptName имя скрипта
	 */
	public static function getJsFileUrl($scriptName) {return Template::getHostUrl().'/js/'.$scriptName.'.js';}


	/*!
	 * \brief Получить url css-файла.
	 * \param styleName имя стиля
	 */
	public static function getCssFileUrl($styleName) {return Template::getHostUrl().'/style/'.$styleName.'.css';}


	/*!
	 * \brief Получить url списка пользователей.
	 */
	public static function getUsersUrl() {return Template::getForumUrl().'/userlist';}


	/*!
	 * \brief Получить url поиска.
	 */
	public static function getSearchUrl() {return Template::getHostUrl().'/search';}


	/*!
	 * \brief Получить url блога.
	 */
	public static function getBlogUrl() {return Template::getHostUrl().'/blog';}


	/*!
	 * \brief Получить url поиска по блогу.
	 */
	public static function getBlogSearchUrl() {return Template::getBlogUrl().'/index.php?s=\'\'';}


	/*!
	 * \brief Получить url rss-ленты блога.
	 */
	public static function getBlogRssUrl() {return Template::getBlogUrl().'/index.php?feed=rss2';}


	/*!
	 * \brief Получить url atom-ленты блога.
	 */
	public static function getBlogAtomUrl() {return Template::getBlogUrl().'/feed/atom/';}


	/*!
	 * \brief Получить url rsd-информации блога.
	 */
	public static function getBlogRsdUrl() {return Template::getBlogUrl().'/xmlrpc.php?rsd';}


	/*!
	 * \brief Получить url категории блога.
	 * \param category имя категории
	 */
	public static function getBlogCategoryUrl($category) {return Template::getBlogUrl().'/category/'.strtolower($category);}


	/*!
	 * \brief Получить url форума.
	 */
	public static function getForumUrl() {return Template::getHostUrl().'/forum';}


	/*!
	 * \brief Получить url поиска по форуму.
	 */
	public static function getForumSearchUrl() {return Template::getForumUrl().'/search.php';}


	/*!
	 * \brief Получить url rss-ленты топиков форума.
	 */
	public static function getForumTopicsRssUrl() {return Template::getForumUrl().'/extern.php?action=feed&type=rss';}


	/*!
	 * \brief Получить url atom-ленты топиков форума.
	 */
	public static function getForumTopicsAtomUrl() {return Template::getForumUrl().'/extern.php?action=feed&type=atom';}


	/*!
	 * \brief Получить url rss-ленты сообщений форума.
	 */
	public static function getForumPostsRssUrl() {return Template::getForumUrl().'/extern.php?action=posts_feed&type=rss';}


	/*!
	 * \brief Получить url atom-ленты сообщений форума.
	 */
	public static function getForumPostsAtomUrl() {return Template::getForumUrl().'/extern.php?action=posts_feed&type=atom';}


	/*!
	 * \brief Получить url раздела форума.
	 * \param sectionId идентификатор раздела
	 */
	public static function getForumSectionUrl($sectionId) {return Template::getForumUrl().'/viewforum.php?id='.$sectionId;}


	/*!
	 * \brief Получить url топика форума.
	 * \param topicId идентификатор топика
	 */
	public static function getForumTopicUrl($topicId) {return Template::getForumUrl().'/viewtopic.php?id='.$topicId;}


	/*!
	 * \brief Получить url сообщения форума.
	 * \param postId идентификатор сообщения
	 */
	public static function getForumPostUrl($postId) {return Template::getForumUrl().'/viewtopic.php?pid='.$postId.'#p'.$postId;}


	/*!
	 * \brief Получить url wiki.
	 */
	public static function getWikiUrl() {return Template::getHostUrl().'/wiki';}


	/*!
	 * \brief Получить url поиска по wiki.
	 */
	public static function getWikiSearchUrl() {return Template::getWikiUrl().'/index.php?title=Служебная:Search';}


	/*!
	 * \brief Получить url rss-ленты wiki.
	 */
	public static function getWikiRssUrl() {return Template::getWikiUrl().'/index.php?title=%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:RecentChanges&feed=rss';}


	/*!
	 * \brief Получить url atom-ленты wiki.
	 */
	public static function getWikiAtomUrl() {return Template::getWikiUrl().'/index.php?title=%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:RecentChanges&amp;feed=atom';}


	/*!
	 * \brief Получить url страницы wiki.
	 * \param $page имя страницы
	 */
	public static function getWikiPageUrl($page) {return Template::getWikiUrl().'/index.php/'.$page;}


	/*!
	 * \brief Получить url навигатора.
	 */
	public static function getNavigatorUrl() {return Template::getHostUrl().'/navigator';}


	/*!
	 * \brief Получить url каталога навигатора.
	 * \param $catalog идентификатор каталога
	 */
	public static function getNavigatorCatalogUrl($catalog) {return Template::getNavigatorUrl().'?catalog='.$catalog;}


	/*!
	 * \brief Получить url баркода.
	 */
	public static function getBarcodeUrl() {return Template::getHostUrl().'/barcode';}


	/*!
	 * \brief Получить url страницы авторизации.
	 * \param action тип действия
	 */
	 public static function getLoginUrl($action = 'in') {return Template::getHostUrl().'/login?action='.$action;}


	/*!
	 * \brief Получить url страницы регистрации.
	 */
	 public static function getRegisterUrl() {return Template::getHostUrl().'/register';}


	/*!
	 * \brief Получить url страницы профиля.
	 * \param userId идентификатор пользователя
	 */
	public static function getProfileUrl($userId) {
//		return Template::getHostUrl().'/profile.php?userid='.$userId;
		return Template::getForumUrl().'/profile.php?id='.$userId;
	}
}


/*!
 * \brief Вывести значение.
 * \param value выводимое значение
 */
function the($value) {echo General::htmlencode($value);}


/*!
 * \brief Вывести значение из массива General::$data.
 * \param path путь к выводимому значению в массиве (вложенность отделяется с помощью /)
 * \param echo true - вывести, false - вернуть
 */
function data($path, $echo = false) {
	$pathPoints = explode('/', $path); // точки пути в массиве
	$value = General::$data;
	foreach ($pathPoints as $pathPoint) $value = $value[$pathPoint];
	if ($echo)
		the($value);
	else
		return $value;
}


/*!
 * \brief Получить тип страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_type($echo = true) {if ($echo) echo Template::getPageType(); else return Template::getPageType();}


/*!
 * \brief Получить подтип страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_subtype($echo = true) {if ($echo) echo Template::getPageSubtype(); else return Template::getPageSubtype();}


/*!
 * \brief Получить адрес, с которого послан запрос к сайту.
 * \param echo true - вывести, false - вернуть
 */
function remote_addr($echo = true) {if ($echo) the(Template::getRemoteAddr()); else return Template::getRemoteAddr();}


/*!
 * \brief Получить тип браузера пользователя.
 * \param echo true - вывести, false - вернуть
 */
function user_agent($echo = true) {if ($echo) the(Template::getUserAgent()); else return Template::getUserAgent();}


/*!
 * \brief Получить ссылку на текущую страницу.
 * \param echo true - вывести, false - вернуть
 */
function page_url($echo = true) {if ($echo) echo the(Template::getPageUrl()); else return Template::getPageUrl();}


/*!
 * \brief Получить ссылку на текущую страницу в другом представлении.
 * \param viewport другое представление
 * \param echo true - вывести, false - вернуть
 */
function page_viewport_url($viewport, $echo = true) {if ($echo) echo the(Template::getPageViewportUrl($viewport)); else return Template::getPageViewportUrl($viewport);}


/*!
 * \brief Получить заголовок страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_title($echo = true) {if ($echo) echo Template::getPageTitle(); else return Template::getPageTitle();}


/*!
 * \brief Получить описание страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_description($echo = true) {if ($echo) echo Template::getPageDescription(); else return Template::getPageDescription();}


/*!
 * \brief Получить ключевые слова страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_key_words($echo = true) {if ($echo) echo Template::getPageKeyWords(); else return Template::getPageKeyWords();}


/*!
 * \brief Получить информацию о механизме страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_powered_by($echo = true) {if ($echo) echo Template::getPagePoweredBy(); else return Template::getPagePoweredBy();}


/*!
 * \brief Получить код шапки страницы.
 */
function page_header() {Template::insert('header');}


/*!
 * \brief Получить код подвала страницы.
 */
function page_footer() {Template::insert('footer');}


/*!
 * \brief Получить код хлебных крошек.
 */
function page_breadcrumbs() {Template::insert('breadcrumbs');}


/*!
 * \brief Получить код меню шаринга.
 * \param url ссылка
 * \param title заголовок
 * \param tags строка тэгов
 * \param description описание
 */
function page_sharemenu($url, $title = '', $tags = '', $description = '') {
	Template::$sharemenu_url = $url; // ссылка
	Template::$sharemenu_title = $title; // заголовок
	Template::$sharemenu_tags = $tags; // строка тэгов
	Template::$sharemenu_description = $description; // описание
	Template::insert('sharemenu'); // подключить шаблон
}


/*!
 * \brief Получить код ссылки меню шаринга.
 * \param echo true - вывести, false - вернуть
 */
function page_sharemenu_url($echo = true) {if ($echo) the(Template::$sharemenu_url); else return Template::$sharemenu_url;}


/*!
 * \brief Получить код заголовка меню шаринга.
 * \param echo true - вывести, false - вернуть
 */
function page_sharemenu_title($echo = true) {if ($echo) echo Template::$sharemenu_title; else return Template::$sharemenu_title;}


/*!
 * \brief Получить код тэгов меню шаринга.
 * \param echo true - вывести, false - вернуть
 */
function page_sharemenu_tags($echo = true) {if ($echo) echo Template::$sharemenu_tags; else return Template::$sharemenu_tags;}


/*!
 * \brief Получить код описания меню шаринга.
 * \param echo true - вывести, false - вернуть
 */
function page_sharemenu_description($echo = true) {if ($echo) echo Template::$sharemenu_description; else return Template::$sharemenu_description;}


/*!
 * \brief Получить код бокса тела страницы.
 * \param header содержимое шапки бокса
 * \param body содержимое тела бокса
 * \param footer содержимое подвала бокса
 * \param type тип используемого тэга
 * \param params дополнительные параметры тэга бокса в виде ассоциативного массива
 */
function page_bodybox($header, $body, $footer, $type = 'article', $params = false) {
	Template::$bodybox_header = $header; // шапка
	Template::$bodybox_body = $body; // тело
	Template::$bodybox_footer = $footer; // подвал
	Template::$bodybox_type = $type; // тип
	Template::$bodybox_params = $params; // дополнительные параметры тэга бокса
	Template::insert('bodybox'); // подключить шаблон
}


/*!
 * \brief Получить код шапки бокса тела страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_bodybox_header($echo = true) {if ($echo) echo Template::$bodybox_header; else return Template::$bodybox_header;}


/*!
 * \brief Получить код тела бокса тела страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_bodybox_body($echo = true) {if ($echo) echo Template::$bodybox_body; else return Template::$bodybox_body;}


/*!
 * \brief Получить код подвала бокса тела страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_bodybox_footer($echo = true) {if ($echo) echo Template::$bodybox_footer; else return Template::$bodybox_footer;}


/*!
 * \brief Получить код типа бокса тела страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_bodybox_type($echo = true) {if ($echo) echo Template::$bodybox_type; else return Template::$bodybox_type;}


/*!
 * \brief Получить код дополнительных параметров тэга бокса тела страницы.
 * \param echo true - вывести, false - вернуть
 */
function page_bodybox_params($echo = true) {
	if ($echo) {
		if (Template::$bodybox_params) {
			foreach (Template::$bodybox_params as $paramKey => $paramValue)	{
				the(' '.$paramKey);
				if (!is_null($paramValue)) the('="'.$paramValue.'"');
			}
		}
	} else {
		return Template::$bodybox_params;
	}
}


/*
 * \brief Получить код тела страницы.
 */
function page_body() {Template::insert(Template::getPageBodyTemplate());}


/*!
 * \brief Получить код бокса боковой панели.
 * \param title заголовок бокса
 * \param body содержимое тела бокса
 * \param type тип тэга боковой панели ('nav', 'section')
 * \param params дополнительные параметры тэга бокса в виде ассоциативного массива
 */
function page_sidebox($title, $body, $type='section', $params = false) {
	Template::$sidebox_title = $title; // название
	Template::$sidebox_body = $body; // тело
	Template::$sidebox_type = $type; // тип
	Template::$sidebox_params = $params; // дополнительные параметры тэга бокса
	Template::insert('sidebox'); // подключить шаблон
}


/*!
 * \brief Получить код заголовка бокса боковой панели.
 * \param echo true - вывести, false - вернуть
 */
function page_sidebox_title($echo = true) {if ($echo) echo Template::$sidebox_title; else return Template::$sidebox_title;}


/*!
 * \brief Получить код содержимого тела бокса боковой панели.
 * \param echo true - вывести, false - вернуть
 */
function page_sidebox_body($echo = true) {if ($echo) echo Template::$sidebox_body; else return Template::$sidebox_body;}


/*!
 * \brief Получить код типа бокса боковой панели.
 * \param echo true - вывести, false - вернуть
 */
function page_sidebox_type($echo = true) {if ($echo) echo Template::$sidebox_type; else return Template::$sidebox_type;}


/*!
 * \brief Получить код дополнительных параметров тга бокса боковой панели.
 * \param echo true - вывести, false - вернуть
 */
function page_sidebox_params($echo = true) {
	if ($echo) {
		if (Template::$sidebox_params) {
			foreach (Template::$sidebox_params as $paramKey => $paramValue)	{
				the(' '.$paramKey);
				if (!is_null($paramValue)) the('="'.$paramValue.'"');
			}
		}
	} else {
		return Template::$sidebox_params;
	}
}


/*!
 * \brief Получить код общей боковой панели.
 */
function page_sidebar() {Template::insert('sidebar');}


/*!
 * \brief Пероверить существование шаблона собственной боковой панели страницы.
 * \return true, если шаблон есть, иначе false
 */
function page_exists_own_sidebar() {return Template::getPageExistsOwnSidebar();}


/*!
 * \brief Получить код собственной боковой панели.
 */
function page_own_sidebar() {Template::insert(Template::getPageSidebarTemplate());}


/*!
 * \brief Получить имя сайта.
 * \param echo true - вывести, false - вернуть
 */
function portal_name($echo = true) {if ($echo) echo Template::getPortalName(); else return Template::getPortalName();}


/*!
 * \brief Получить тему сайта.
 * \param echo true - вывести, false - вернуть
 */
function portal_subject($echo = true) {if ($echo) echo Template::getPortalSubject(); else return Template::getPortalSubject();}


/*!
 * \brief Получить описание сайта.
 * \param echo true - вывести, false - вернуть
 */
function portal_description($echo = true) {if ($echo) echo Template::getPortalDescription(); else return Template::getPortalDescription();}


/*!
 * \brief Получить ссылку на корень сайта.
 * \param echo true - вывести, false - вернуть
 */
function host_url($echo = true) {if ($echo) the(Template::getHostUrl()); else return Template::getHostUrl();}


/*!
 * \brief Получить url js-файла.
 * \param scriptName имя скрипта
 * \param echo true - вывести, false - вернуть
 */
function js_file_url($scriptName, $echo = true) {if ($echo) the(Template::getJsFileUrl($scriptName)); else return Template::getJsFileUrl($scriptName);}


/*!
 * \brief Получить url css-файла.
 * \param styleName имя стиля
 * \param echo true - вывести, false - вернуть
 */
function css_file_url($styleName, $echo = true) {if ($echo) the(Template::getCssFileUrl($styleName)); else return Template::getCssFileUrl($styleName);}


/*!
 * \brief Получить url списка пользователей.
 * \param echo true - вывести, false - вернуть
 */
function users_url($echo = true) {if ($echo) the(Template::getUsersUrl()); else return Template::getUsersUrl();}


/*!
 * \brief Получить url поиска.
 * \param echo true - вывести, false - вернуть
 */
function search_url($echo = true) {if ($echo) the(Template::getSearchUrl()); else return Template::getSearchUrl();}


/*!
 * \brief Получить url блога.
 * \param echo true - вывести, false - вернуть
 */
function blog_url($echo = true) {if ($echo) the(Template::getBlogUrl()); else return Template::getBlogUrl();}


/*!
 * \brief Получить url поиска по блогу.
 * \param echo true - вывести, false - вернуть
 */
function blog_search_url($echo = true) {if ($echo) the(Template::getBlogSearchUrl()); else return Template::getBlogSearchUrl();}


/*!
 * \brief Получить url rss-ленты блога.
 * \param echo true - вывести, false - вернуть
 */
function blog_rss_url($echo = true) {if ($echo) the(Template::getBlogRssUrl()); else return Template::getBlogRssUrl();}


/*!
 * \brief Получить url atom-ленты блога.
 * \param echo true - вывести, false - вернуть
 */
function blog_atom_url($echo = true) {if ($echo) the(Template::getBlogAtomUrl()); else return Template::getBlogAtomUrl();}


/*!
 * \brief Получить url rsd-информации блога.
 * \param echo true - вывести, false - вернуть
 */
function blog_rsd_url($echo = true) {if ($echo) the(Template::getBlogRsdUrl()); else return Template::getBlogRsdUrl();}


/*!
 * \brief Получить url категории блога.
 * \param category имя категории
 * \param echo true - вывести, false - вернуть
 */
function blog_category_url($category, $echo = true) {if ($echo) the(Template::getBlogCategoryUrl($category)); else return Template::getBlogCategoryUrl($category);}


/*!
 * \brief Получить url форума.
 * \param echo true - вывести, false - вернуть
 */
function forum_url($echo = true) {if ($echo) the(Template::getForumUrl()); else return Template::getForumUrl();}


/*!
 * \brief Получить url поиска по форуму.
 * \param echo true - вывести, false - вернуть
 */
function forum_search_url($echo = true) {if ($echo) the(Template::getForumSearchUrl()); else return Template::getForumSearchUrl();}


/*!
 * \brief Получить url rss-ленты топиков форума.
 * \param echo true - вывести, false - вернуть
 */
function forum_topics_rss_url($echo = true) {if ($echo) the(Template::getForumTopicsRssUrl()); else return Template::getForumTopicsRssUrl();}


/*!
 * \brief Получить url atom-ленты топиков форума.
 * \param echo true - вывести, false - вернуть
 */
function forum_topics_atom_url($echo = true) {if ($echo) the(Template::getForumTopicsAtomUrl()); else return Template::getForumTopicsAtomUrl();}


/*!
 * \brief Получить url rss-ленты сообщений форума.
 * \param echo true - вывести, false - вернуть
 */
function forum_posts_rss_url($echo = true) {if ($echo) the(Template::getForumPostsRssUrl()); else return Template::getForumPostsRssUrl();}


/*!
 * \brief Получить url atom-ленты сообщений форума.
 * \param echo true - вывести, false - вернуть
 */
function forum_posts_atom_url($echo = true) {if ($echo) the(Template::getForumPostsAtomUrl()); else return Template::getForumPostsAtomUrl();}


/*!
 * \brief Получить url раздела форума.
 * \param sectionId идентификатор раздела
 * \param echo true - вывести, false - вернуть
 */
function forum_section_url($sectionId, $echo = true) {if ($echo) the(Template::getForumSectionUrl($sectionId)); else return Template::getForumSectionUrl($sectionId);}


/*!
 * \brief Получить url топика форума.
 * \param topicId идентификатор топика
 * \param echo true - вывести, false - вернуть
 */
function forum_topic_url($topicId, $echo = true) {if ($echo) the(Template::getForumTopicUrl($topicId)); else return Template::getForumTopicUrl($topicId);}


/*!
 * \brief Получить url сообщения форума.
 * \param postId идентификатор сообщения
 * \param echo true - вывести, false - вернуть
 */
function forum_post_url($postId, $echo = true) {if ($echo) the(Template::getForumPostUrl($postId)); else return Template::getForumPostUrl($postId);}


/*!
 * \brief Получить url wiki.
 * \param echo true - вывести, false - вернуть
 */
function wiki_url($echo = true) {if ($echo) the(Template::getWikiUrl()); else return Template::getWikiUrl();}


/*!
 * \brief Получить url поиска по wiki.
 * \param echo true - вывести, false - вернуть
 */
function wiki_search_url($echo = true) {if ($echo) the(Template::getWikiSearchUrl()); else return Template::getWikiSearchUrl();}


/*!
 * \brief Получить url rss-ленты wiki.
 * \param echo true - вывести, false - вернуть
 */
function wiki_rss_url($echo = true) {if ($echo) the(Template::getWikiRssUrl()); else return Template::getWikiRssUrl();}


/*!
 * \brief Получить url atom-ленты wiki.
 * \param echo true - вывести, false - вернуть
 */
function wiki_atom_url($echo = true) {if ($echo) the(Template::getWikiAtomUrl()); else return Template::getWikiAtomUrl();}


/*!
 * \brief Получить url страницы wiki.
 * \param page имя страницы
 * \param echo true - вывести, false - вернуть
 */
function wiki_page_url($page, $echo = true) {if ($echo) the(Template::getWikiPageUrl($page)); else return Template::getWikiPageUrl($page);}


/*!
 * \brief Получить url навигатора.
 * \param echo true - вывести, false - вернуть
 */
function navigator_url($echo = true) {if ($echo) the(Template::getNavigatorUrl()); else return Template::getNavigatorUrl();}


/*!
 * \brief Получить url каталога навигатора.
 * \param $catalog идентификатор каталога
 * \param echo true - вывести, false - вернуть
 */
function navigator_catalog_url($catalog, $echo = true) {if ($echo) the(Template::getNavigatorCatalogUrl($catalog)); else return Template::getNavigatorCatalogUrl($catalog);}


/*!
 * \brief Получить url баркода.
 * \param echo true - вывести, false - вернуть
 */
function barcode_url($echo = true) {if ($echo) the(Template::getBarcodeUrl()); else return Template::getBarcodeUrl();}


/*!
 * \brief Получить url страницы авторизации.
 * \param action тип действия
 * \param echo true - вывести, false - вернуть
 */
function login_url($action, $echo = true) {if ($echo) the(Template::getLoginUrl($action)); else return Template::getLoginUrl($action);}


/*!
 * \brief Получить url страницы регистрации.
 * \param echo true - вывести, false - вернуть
 */
function register_url($echo = true) {if ($echo) the(Template::getRegisterUrl()); else return Template::getRegisterUrl();}


/*!
 * \brief Получить url страницы профиля.
 * \param userId идентификатор пользователя
 * \param echo true - вывести, false - вернуть
 */
function profile_url($userId, $echo = true) {if ($echo) the(Template::getProfileUrl($userId)); else return Template::getProfileUrl($userId);}



/*!
 * \brief Получить код бокса боковой панели с баркодом текущей страницы.
 */
function page_barcode_sidebox() {
	page_sidebox(false,'<a href="'.barcode_url(false).'?url='.page_url(false).'"><img src="'.General::barcodeImageUrl(page_url(false)).'"></a>');
}


/*!
 * \brief Получить код бокса боковой панели с записями из rss-ленты.
 * \param name название бокса
 * \param url ссылка на ленту
 * \param count количесво выводимых записей
 * \param updateTime количество времени в секундах, через которое обновляется
 * \param fileName файл, в который сохраняется кеш
 */
function page_rss_sidebox($name, $url, $count, $updateTime = 0, $fileName = 0) {
	global $config;
	$filePath = $config['cache']['dir'].'/'.$fileName; // полный путь к файлу
	if ($updateTime && file_exists($filePath) && (date('U') - filemtime($filePath) < $updateTime)) { // если указано время обновления и файл создавался недавно
		$file = fopen($filePath, 'r'); // открываем файл
		$rssItems = unserialize(fread($file, filesize($filePath))); // читаем список из файла
		fclose($file);
	} else {
		$rss = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA); // объект XML-файла
        $rssResult['title'] = $rss->xpath("/rss/channel/item/title"); // список заголовков
        $rssResult['link'] = $rss->xpath("/rss/channel/item/link"); // скисок ссылок
		$rssItems = array(); // список элементов rss
        foreach($rssResult as $key => $attribute) {
            $nItems = 0;
            foreach($attribute as $element) {
				if ($nItems > $count) break;
                $rssItems[$nItems][$key] = (string)$element;
                $nItems++;
            }
        }
		if ($fileName) { // если указано имя файла
			$file = fopen($filePath, 'w'); // открываем файл
			fwrite($file, serialize($rssItems)); // записываем список в файл
			fclose($file);
		}
	}
	$body = '<ul>'."\n"; // список записей
	foreach ($rssItems as $item) {
		if ($item['link'] == page_url(false)) {
			$body = $body.'	<li>'.$item['title'].'</li>'."\n";
		} else {
			$body = $body.'	<li><a href="'.$item['link'].'">'.$item['title'].'</a></li>'."\n";
		}
	}
	$body .= '</ul>'."\n";
	page_sidebox($name, $body, 'nav');
}


/*!
 * \brief Получить код комментариев с форума.
 * \param topicId идентификатор топика
 */
function page_comments($topicId) {
	Template::$comments_topicId = $topicId; // идентификатор топика
	Template::insert('comments'); // подключаем шаблон
}


/*!
 * \brief Получить код идентификатора топика комментариев с форума.
 * \param echo true - вывести, false - вернуть
 */
function page_comments_topic_id($echo = true) {if ($echo) echo Template::$comments_topicId; else return Template::$comments_topicId;}
