<? ob_start() ?>
	<? if (data('barcode/action') == 'url') { ?>
		<img id="barcode-image" src="<? data('barcode/image_url', true) ?>">
		<p>Закодированная ссылка: <a href="<? data('barcode/value', true) ?>"></a></p>
	<? } elseif (data('barcode/action') == 'text')  { ?>
		<img id="barcode-image" src="<? data('barcode/image_url', true) ?>">
		<p>Закодированный текст:</p>
		<blockquote><? data('barcode/value', true) ?></blockquote>
	<? } ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox(false, $bodybox_body, false) ?>
<? ob_start() ?>
	<? page_comments(1482) ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox('<h1>Обсуждение на форуме</h1>', $bodybox_body, false) ?>
