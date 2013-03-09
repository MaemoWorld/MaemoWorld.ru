<<? page_bodybox_type() ?> class="box">
	<? if(page_bodybox_header(false)) { ?>
		<header>
			<? page_bodybox_header() ?>
		</header>
	<? } ?>
	<? page_bodybox_body() ?>
	<? if(page_bodybox_footer(false)) { ?>
		<footer>
			<? page_bodybox_footer() ?>
		</footer>
	<? } ?>
</<? page_bodybox_type() ?>>
