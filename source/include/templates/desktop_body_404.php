<? ob_start() ?>
	<p>Запрашиваемая страница не найдена.</p>
	<p>Попробуйте изменить параметры запроса.</p>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox('<h1>Ошибка 404</h1>', $bodybox_body, false, 'section') ?>
