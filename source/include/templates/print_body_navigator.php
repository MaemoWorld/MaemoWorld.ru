<? ob_start() ?>
	<h1>Каталоги</h1>
<? $bodybox_top = ob_get_clean() ?>
<? ob_start() ?>
	<p>Пожалуйста, выберите один из каталогов:</p>
	<ul>
		<? foreach (data('navigator/catalogs') as $catalogId => $catalog) { ?>
			<li><a href="<? navigator_catalog_url($catalogId) ?>"><? the($catalog['name']) ?></a></li>
		<? } ?>
	</ul>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox($bodybox_top, $bodybox_body, false) ?>
<? ob_start() ?>
	<? page_comments(1629) ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox('<h1>Обсуждение на форуме</h1>', $bodybox_body, false) ?>
