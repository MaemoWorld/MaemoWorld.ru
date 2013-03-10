<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="<?php page_description() ?>">
		<meta name="keywords" content="<?php page_key_words() ?>">
		<meta name="author" content="<? portal_name() ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php page_title() ?></title>
		<link rel="stylesheet" href="<? css_file_url('desktop') ?>" />
		<link rel="icon" href="<? host_url() ?>/favicon.ico" /> 
		<link rel="alternate" type="application/rss+xml" title="Новости: RSS 2.0" href="<? blog_rss_url() ?>" />
		<link rel="alternate" type="application/atom+xml" title="Новости: Atom 0.3" href="<? blog_atom_url() ?>" />
		<link rel="alternate" type="application/rsd+xml" title="Новости: RSD" href="<? blog_rsd_url() ?>" />
		<link rel="alternate" type="application/rss+xml" title="Топики форума: RSS" href="<? forum_topics_rss_url() ?>" />
		<link rel="alternate" type="application/atom+xml" title="Топики форума: Atom" href="<? forum_topics_atom_url() ?>" />
		<link rel="alternate" type="application/rss+xml"  title="Сообщения форума: RSS" href="<? forum_posts_rss_url() ?>" />
		<link rel="alternate" type="application/atom+xml"  title="Сообщения форума: Atom" href="<? forum_posts_atom_url() ?>" />
		<link rel="alternate" type="application/rss+xml" title="База знаний: RSS" href="<? wiki_rss_url() ?>" /> 
		<link rel="alternate" type="application/atom+xml" title="База знаний: Atom" href="<? wiki_atom_url() ?>" /> 
		<link rel="index" title="<?php portal_description() ?>" href="<? host_url() ?>/" />
		<link rel="search" title="Поиск в Google" href="<? search_url() ?>" />
		<link rel="search" title="Поиск по новостям" href="<? blog_search_url() ?>" />
		<link rel="search" title="Поиск по форуму" href="<? forum_search_url() ?>" />
		<link rel="search" title="Поиск по базе знаний" href="<? wiki_search_url() ?>" />
		<link rel="author" title="Участники" href="<? users_url() ?>" />
		<script src="<? js_file_url('jquery.min') ?>"></script>
		<? if (user_agent(false) == 'IE') { ?>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<link rel="stylesheet" href="<? css_file_url('ie') ?>" />
		<? } ?>
	</head>
	<body <? if (user_agent(false)) { ?>class="<? user_agent() ?>"<? } ?>>
		<div style="display: none;">
<!--LiveInternet counter--><script><!--
new Image().src = "http://counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+
";"+Math.random();//--></script><!--/LiveInternet-->
		</div>

		<? if ((page_type(false) == 'punbb') || (page_type(false) == 'mediawiki')) { ?>
			<div id="page" class="wide-page">
		<? }else { ?>
			<div id="page" class="tight-page">
		<? } ?>
			<header id="page-header">
				<hgroup id="title-headers">
					<h1><? page_title() ?></h1>
					<h2><? page_description() ?></h2>
				</hgroup>
				<a id="logo" title="<? portal_name().' - '.portal_subject() ?>" href="<? host_url() ?>"></a>
				<nav id="main-nav">
					<ul>
						<li <? if (page_type(false) == 'wordpress') { ?> class="current"<? } ?>>
							<a title="Новости <? portal_subject() ?>" href="<? blog_url() ?>">Новости</a>
						</li>
						<li <? if (page_type(false) == 'punbb') { ?> class="current"<? } ?>>
							<a title="Форум <? portal_subject() ?>" href="<? forum_url() ?>">Форум</a>
						</li>
						<li <? if (page_type(false) == 'mediawiki') { ?> class="current"<? } ?>>
							<a title="База знаний (FAQ) по <? portal_subject() ?>" href="<? wiki_url() ?>">База знаний</a>
						</li>
						<li <? if (page_type(false) == 'navigator') { ?> class="current"<? } ?>>
							<a title="Навигатор по <? portal_subject() ?>" href="<? navigator_url() ?>">Навигатор</a>
						</li>
						<li <? if (page_type(false) == 'barcode') { ?> class="current"<? } ?>>
							<a title="Баркод" href="<? barcode_url() ?>">Баркод</a>
						</li>
						<li>
							<a title="О сообществе <? portal_name() ?>" href="<? wiki_page_url('Wiki_MeeGo_и_Maemo_в_России:Портал_сообщества') ?>">О сообществе</a>
						</li>
					</ul>
				</nav>
				<aside class="panel">
					<nav id="follow-nav" >
						<h1>Следите за нами</h1>
						<ul>
							<li><a class="jabber" title="Jabber" href="<? wiki_page_url('Help:Jabber-конференция') ?>"></a></li>
							<li><a class="vkontakte" title="ВКонтакте" href="http://vkontakte.ru/maemoworld"></a></li>
							<li><a class="facebook" title="Facebook" href="http://www.facebook.com/MaemoWorld.ru"></a></li>
							<li><a class="twitter" title="Twitter" href="http://twitter.com/MaemoWorld_ru"></a></li>
							<li><a class="livejournal" title="Живой Журнал" href="http://maemoworld.livejournal.com/"></a></li>
							<li><a class="googlebuzz" title="Google Buzz" href="https://profiles.google.com/maemoworld.ru/buzz"></a></li>
							<li><a class="ya" title="Яндекс-блог" href="http://maemoworld-ru.ya.ru/index_blog.xml"></a></li>
						</ul>
					</nav>
					<nav id="rss-nav">
						<h1>Ленты новостей</h1>
						<a class="feed_url" href="<? forum_posts_rss_url() ?>">RSS форума</a>
						<a class="feed_url" href="<? blog_rss_url() ?>">RSS новостей</a>
					</nav>
					<nav role="search" id="search-nav">
						<h1>Поиск</h1>
						<form role="search" action="<? search_url() ?>" accept-charset="utf-8" method="get">
							<input type="hidden" name="location" value="google">
							<input type="search" name="query"    placeholder="Google поиск по сайту" maxlength="100">
							<input type="submit" name="btnG"     value="&gt;&gt;">
						</form>
						<form role="search" action="<? blog_url() ?>/index.php" accept-charset="utf-8" method="get">
							<input type="search" name="s" placeholder="поиск по новостям" maxlength="100">
							<input type="submit"          value="&gt;&gt;">
						</form>
						<form role="search" action="<? forum_search_url() ?>" accept-charset="utf-8" method="get">
							<input type="hidden" name="action"   value="search">
							<input type="hidden" name="sort_dir" value="DESC">
							<input type="hidden" name="show_as"  value="posts">
							<input type="search" name="keywords" placeholder="поиск по форуму" maxlength="100">
							<input type="submit" name="search"   value="&gt;&gt;">
						</form>
						<form role="search" action="<? wiki_url() ?>/index.php" accept-charset="utf-8" method="get">
							<input type="hidden" name="title"  value="Служебная%3ASearch">
							<input type="search" name="search" placeholder="поиск по базе знаний" maxlength="100">
							<input type="submit"               value="&gt;&gt;">
						</form>
					</nav>
				</aside>
				<div class="content">
					<nav id="forums-nav">
						<h1>Обсуждения</h1>
						<ul>
							<li><a href="<? forum_url() ?>/viewforum.php?id=12">Приложения</a></li>
							<li><a href="<? forum_section_url(13) ?>">Игры</a></li>
							<li><a href="<? forum_section_url(43) ?>">Игры WebOS</a></li>
							<li><a href="<? forum_section_url(32) ?>">Эмуляторы</a></li>
							<li><a href="<? forum_section_url(15) ?>">Видео</a></li>
							<li><a href="<? forum_section_url(18) ?>">Темы</a></li>
							<li><a href="<? forum_section_url(20) ?>">Обои</a></li>
							<li><a href="<? forum_section_url(27) ?>">Программы для PC</a></li>
						</ul>
					</nav>
					<nav id="devices-nav">
						<h1>Устройства</h1>
						<ul>
							<li><a href="<? forum_section_url(36) ?>">Nokia N9</a></li>
							<li><a href="<? forum_section_url(6) ?>">Nokia N900</a></li>
							<li><a href="<? forum_section_url(9) ?>">Nokia N810</a></li>
							<li><a href="<? forum_section_url(9) ?>">Nokia N800</a></li>
							<li><a href="<? forum_section_url(9) ?>">Nokia 770</a></li>
						</ul>
					</nav>
					<nav id="navigators-nav">
						<h1>Навигаторы</h1>
						<ul>
							<li><a href="<? navigator_catalog_url('apps') ?>">Приложения</a></li>
							<li><a href="<? navigator_catalog_url('games') ?>">Игры</a></li>
							<li><a href="<? navigator_catalog_url('webos_games') ?>">Игры WebOS</a></li>
							<li><a href="<? navigator_catalog_url('video') ?>">Видео</a></li>
							<li><a href="<? navigator_catalog_url('market') ?>">Барахолка</a></li>
						</ul>
					</nav>
					<nav id="useful-nav">
						<h1>Полезное</h1>
						<ul>
							<li><a href="<? wiki_page_url('База_знаний') ?>">База знаний (FAQ)</a></li>
							<li><a href="<? forum_topic_url(570) ?>">Установка deb-файлов</a></li>
							<li><a href="<? wiki_page_url('Maemo_Flasher/Обновление_прошивки') ?>">Как обновить прошивку</a></li>
						</ul>
					</nav>
					<a id="add-news-button" class="red-button" href="<? wiki_page_url('Help:Блог#.D0.94.D0.BE.D0.B1.D0.B0.D0.B2.D0.BB.D0.B5.D0.BD.D0.B8.D0.B5_.D0.B7.D0.B0.D0.BF.D0.B8.D1.81.D0.B8') ?>">Добавить новость</a>
					<? if (user_agent(false) == 'IE') { ?>
						<div id="browser-notification">
							Для корректного отображения содержимого, пожалуйста, используйте последнюю версию одного из адекватных браузеров:
							<a href="https://www.google.com/intl/ru/chrome/browser/">Chrome</a>,
							<a href="http://mozilla-russia.org/products/firefox/">Firefox</a>,
							<a href="http://ru.opera.com/">Opera</a> или
							<a href="http://www.apple.com/ru/safari/">Safari</a>.
						</div>
					<? } ?>
				</div>
			</header>
			<? page_breadcrumbs() ?>
