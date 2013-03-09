<? ob_start() ?>
	<p>
		Для распознавания картинки воспользуйтесь камерой и программой:
		на&nbsp;устройствах с <strong>Harmattan</strong> - <a href="<? forum_post_url(98833) ?>">MeeScan</a> или <a href="<? forum_post_url(107655) ?>">UpCode</a>,
		на&nbsp;мобильных компьютерах с <strong>Maemo</strong> - <a href="<? forum_post_url(13141) ?>">mBarcode</a>,
		на&nbsp;смартфонах <strong>Symbian S60</strong> и <strong>Symbian^3</strong> - <a href="http://forum.nokia5800.ru/viewtopic.php?pid=84733#p84733">UpCode</a> или <a href="http://forum.nokia5800.ru/viewtopic.php?pid=84756#p84756">BeeTagg</a>,
		на&nbsp;коммуникаторах <strong>Windows Mobile</strong> - <a href="http://www.quickmark.com.tw/En/basic/download.asp">QuickMark Mobile Barcode</a>,
		на&nbsp;телефонах <strong>iPhone</strong>, планшетах <strong>iPad</strong> и устройствах с <strong>Android</strong> поможет поиск по магазинам приложений.
	</p>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox(false, $bodybox_body, false) ?>
<? ob_start() ?>
	<? page_sharemenu(page_url(false), page_title(false), page_key_words(false), page_description(false)) ?>
<? $bodybox_header = ob_get_clean() ?>
<? ob_start() ?>
	<? if (data('barcode/action') == 'url') { ?>
		<a href="<? data('barcode/value', true) ?>"><img id="barcode-image" src="<? data('barcode/image_url', true) ?>"></a>
	<? } elseif(data('barcode/action') == 'text')  { ?>
		<img id="barcode-image" src="<? data('barcode/image_url', true) ?>">
	<? } ?>
	<form action="" accept-charset="utf-8" method="get">
		<input type="text" required name="url" value="<? data('barcode/value', true) ?>" maxlength="512" size="50">
		<input type="submit" value="получить изображение ссылки">
	</form>
	<? page_comments(1482) ?>
<? $bodybox_body = ob_get_clean() ?>
<? page_bodybox($bodybox_header, $bodybox_body, false) ?>
