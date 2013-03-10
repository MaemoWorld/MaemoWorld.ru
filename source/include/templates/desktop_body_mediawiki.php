<? if(data('wiki/sitenotice')) { ?>
	<? ob_start() ?>
		<div class="entry">
			<? data('wiki/sitenotice', true) ?>
		</div>
	<? $bodybox_body = ob_get_clean() ?>
	<? bodybox(false, $bodybox_body, false) ?>
<? } ?>

<? ob_start() ?>
	<div class="entry">
		<? foreach(data('wiki/content_actions') as $key => $tab) { ?>
			<a id="<? the(Sanitizer::escapeId( "ca-$key" )) ?>"
			<? if( $tab['class'] ) { ?>
				class="<? the(htmlspecialchars($tab['class'])) ?>"
			<? } ?>
			href="<? the($tab['href']) ?>"
			<? if( in_array( $action, array('edit', 'submit' )) && in_array( $key, array( 'edit', 'watch', 'unwatch' ))) {
				the(data('wiki/skin')->tooltip('ca-$key'));
			} else {
				the(data('wiki/skin')->tooltipAndAccesskey('ca-$key'));
			} ?>
			><? the(htmlspecialchars($tab['text'])) ?></a>
		<? } ?>
	</div>
<? $bodybox_body = ob_get_contents() ?>
<? ob_end_clean() ?>
<? page_bodybox(false, $bodybox_body, false) ?>

<? ob_start() ?>
	<h1><? if (data('wiki/displaytitle') != "") {echo data('wiki/title');} else {data('wiki/title', true);} ?></h1>
	<? page_sharemenu(page_url(false), data('wiki/pagetitle')) ?>
	<a class="edit" title="<? data('wiki/content_actions/edit/text', true) ?>" href="<? data('wiki/content_actions/edit/href', true) ?>"></a>
<? $bodybox_top = ob_get_clean() ?>
<? ob_start() ?>
	<? if(data('wiki/undelete')) { ?><div id="contentSub2"><? data('wiki/undelete', true) ?></div><? } ?>
	<? if(data('wiki/newtalk')) { ?><div class="usermessage"><? data('wiki/newtalk', true)  ?></div><? } ?>
	<!-- start content -->
	<? echo data('wiki/bodytext') ?>
	<? if(data('wiki/catlinks')) { echo data('wiki/catlinks'); } ?>
	<!-- end content -->
	<? if(data('wiki/dataAfterContent')) { data('wiki/dataAfterContent', true); } ?>
	<div id="comments"></div>
<? $bodybox_body = ob_get_clean() ?>
<? ob_start() ?>
	<? if( !is_null( data('wiki/viewcount')) && data('wiki/viewcount') ) { ?>
		<div id="viewcount">
			<? data('wiki/viewcount', true) ?>
		</div>
	<? } ?>
	<? if( !is_null( data('wiki/lastmod')) && data('wiki/lastmod') ) { ?>
		<div id="lastmod">
			<? data('wiki/lastmod', true) ?>
		</div>
	<? } ?>
<? $bodybox_bottom = ob_get_contents() ?>
<? ob_end_clean() ?>
<? page_bodybox($bodybox_top, $bodybox_body, $bodybox_bottom) ?>
