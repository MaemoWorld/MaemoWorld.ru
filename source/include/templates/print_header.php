<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="<?php page_description() ?>">
		<meta name="keywords" content="<?php page_key_words() ?>">
		<meta name="author" content="<? portal_name() ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php page_title() ?></title>
		<link rel="stylesheet" href="<? css_file_url('print') ?>" />
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
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div style="display: none;">
<!--LiveInternet counter--><script><!--
new Image().src = "http://counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+
";"+Math.random();//--></script><!--/LiveInternet-->
		</div>

		<header>
			<a id="logo" title="<? portal_name().' - '.portal_subject() ?>" href="<? host_url() ?>"><img src="<? host_url() ?>/style/images/desktop_logo.gif"></a>
			<hgroup id="title-headers">
				<h1><? page_title() ?></h1>
				<h2><? page_description() ?></h2>
			</hgroup>
		</header>