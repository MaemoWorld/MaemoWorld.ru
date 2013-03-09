<? if (data('user/is_guest')) { ?>
	<? ob_start() ?>
		<ul>
			<li><a title="IP" href="<? wiki_page_url('User:'.remote_addr(false)) ?>">Ваш IP: <? remote_addr() ?></a></li>
			<li><a title="Войти" href="<? login_url('in') ?>">Войти</a></li>
			<li><a title="Зарегистрироваться" href="<? register_url('in') ?>">Зарегистрироваться</a></li>
		</ul>
	<? $sidebox_body = ob_get_clean() ?>
	<? page_sidebox('Вы не представились', $sidebox_body, 'nav') ?>
<? } else { ?>
	<? ob_start() ?>
		<ul>
			<li><a title="Профиль" href="<? profile_url(data('user/id')) ?>">Профиль</a></li>
			<li><a title="Выйти" href="<? login_url('out') ?>">Выйти</a></li>
		</ul>
	<? $sidebox_body = ob_get_clean() ?>
	<? page_sidebox('Добро пожаловать, '.data('user/username'), $sidebox_body, 'nav') ?>
<? } ?>
<? page_barcode_sidebox() ?>
<? ob_start() ?>
	<ul>
		<li><a title="Nokia N9 - купить" href="<? host_url() ?>/navigator.php?catalog=market&amp;tags[]=833&amp;tags[]=838&amp;tags[]=1501">Купить</a></li>
		<li><a title="Nokia N9 - форум, обсуждение" href="<? forum_url() ?>/viewforum.php?id=36">Обсуждение</a></li>
		<li><a title="Nokia N9 - приложения, программы, софт" href="<? host_url() ?>/navigator.php?catalog=apps_nokia_n9">Приложения</a></li>
		<li><a title="Nokia N9 - игры, программы, софт" href="<? host_url() ?>/navigator.php?catalog=games_nokia_n9">Игры</a></li>
		<li><a title="Nokia N9 - видео, фильмы, мультфильмы, сериалы" href="<? host_url() ?>/navigator.php?catalog=video">Фильмы и сериалы</a></li>
		<li><a title="Nokia N9 - темы" href="<? forum_url() ?>/viewforum.php?id=18">Темы</a></li>
		<li><a title="Nokia N9 - обои" href="<? forum_url() ?>/viewforum.php?id=20">Обои</a></li>
	</ul>
<? $sidebox_body = ob_get_clean() ?>
<? // page_sidebox('Nokia N9', $sidebox_body, 'nav') ?>
<? ob_start() ?>
	<ul>
		<li><a title="Nokia N900 - купить" href="<? host_url() ?>/navigator.php?catalog=market&amp;tags[]=833&amp;tags[]=838&amp;tags[]=67">Купить</a></li>
		<li><a title="Nokia N900 - отзывы" href="<? forum_url() ?>/viewtopic.php?id=6">Отзывы</a></li>
		<li><a title="Nokia N900 - форум, обсуждение" href="<? forum_url() ?>/viewforum.php?id=6">Обсуждение</a></li>
		<li><a title="Nokia N900 - FAQ, помощь" href="<? wiki_url() ?>/index.php/Nokia_N900/FAQ">FAQ</a></li>
		<li><a title="Nokia N900 - приложения, программы, софт" href="<? host_url() ?>/navigator.php?catalog=apps_nokia_n900">Приложения</a></li>
		<li><a title="Nokia N900 - игры, программы, софт" href="<? host_url() ?>/navigator.php?catalog=games_nokia_n900">Игры</a></li>
		<li><a title="Nokia N900 - видео, фильмы, мультфильмы, сериалы" href="<? host_url() ?>/navigator.php?catalog=video">Фильмы и сериалы</a></li>
		<li><a title="Nokia N900 - темы" href="<? forum_url() ?>/viewforum.php?id=18">Темы</a></li>
		<li><a title="Nokia N900 - обои" href="<? forum_url() ?>/viewforum.php?id=20">Обои</a></li>
		<li><a title="Nokia N900 - прошивки" href="<? forum_url() ?>/viewtopic.php?id=676">Прошивки</a></li>
		<li><a title="Nokia N900 - NITDroid (Google Android)" href="<? wiki_url() ?>/index.php/NITDroid/Nokia_N900">Google Android (NITDroid)</a></li>
	</ul>
<? $sidebox_body = ob_get_clean() ?>
<? // page_sidebox('Nokia N900', $sidebox_body, 'nav') ?>
<? page_rss_sidebox('Новое на форуме', forum_url(false).'/extern.php?action=feed&type=rss', 10, 60, './rss_punbb.txt') ?>
<? page_rss_sidebox('Свежие новости', blog_url(false).'/index.php?feed=rss2', 5, 600, './rss_wordpress.txt') ?>
