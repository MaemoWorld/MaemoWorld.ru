			<? page_breadcrumbs() ?>
			<footer id="page-footer" role="contentinfo">
				<small id="copyright">
					<a href="http://creativecommons.org/licenses/by-sa/3.0/deed.ru"><img id="license-logo" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png"></a>
					2009-<? the(date('Y'))?> <? portal_name() ?>
					<br>
					При использовании материалов ресурса обязательно указание активной индексируемой ссылки на <a href="<? host_url() ?>"><? portal_name() ?></a> как источник.
					<address>
						Обратная связь: <a href="mailto:MaemoWorld.ru@gmail.com?subject=Обратная%20связь%20через%20<? page_title() ?>">MaemoWorld.ru@gmail.com</a>.
					</address>
				</small>
				<aside id="counters">
					<!--LiveInternet logo-->
					<a href="http://www.liveinternet.ru/click" target="_blank"><img src="http://counter.yadro.ru/logo?22.1" title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня" alt="" border="0" width="88" height="31"></a>
					<!--/LiveInternet-->
				</aside>
				<nav id="viewport-nav">
					<h1>Другие представления страницы</h1>
					<ul>
						<li><a id="print-ref" href="<? page_viewport_url('print') ?>">Версия для печати</a></li>
						<li><a id="mobile-ref" href="<? page_viewport_url('mobile') ?>">Мобильная версия</a></li>
					</ul>
				</nav>
			</footer>
		</div>
		<small id="powered" role="contentinfo">
			Создатель сайта и оформления <a href="http://kirill.chuvilin.pro">Кирилл Чувилин aka KiRiK</a>, на странице использованы скрипты проекта <? page_powered_by() ?>.
		</small>
	</body>
</html>
