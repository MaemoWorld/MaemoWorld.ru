<? ob_start() ?>
	<p>Обсудить навигатор, оставить отзывы и предложения можно <a href="<? forum_post_url(15924) ?>">на форуме</a>.</p>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox(false, $bodybox_body, false) ?>
<? ob_start() ?>
	<h1><? data('navigator/catalog/name', true) ?></h1>
	<? page_sharemenu(page_url(false), page_title(false), page_key_words(false), page_description(false)) ?>
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
