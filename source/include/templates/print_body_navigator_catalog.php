<? ob_start() ?>
	<h1><? data('navigator/catalog/name', true) ?></h1>
<? $bodybox_top = ob_get_clean() ?>
<? ob_start() ?>
	<? if (count(data('navigator/items')) > 0) { ?>
		<ul>
			<? foreach (data('navigator/items') as $item) { ?>
				<li><a href="<? forum_post_url($item['post_id']) ?>"><? the($item['subject']) ?></a></li>
			<? } ?>
		</ul>
	<? } else { ?>
		<p>Подходящих записей не найдено. Попробуйте задать более мягкие условия фильтра.</p>
	<? } ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox($bodybox_top, $bodybox_body, false) ?>
<? ob_start() ?>
	<? page_comments(1629) ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox('<h1>Обсуждение на форуме</h1>', $bodybox_body, false) ?>
