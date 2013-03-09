<? page_header() ?>
<? if (page_exists_own_sidebar()) { ?>
	<div id="content" class="content-with-sidebar <? page_type() ?>">
		<aside id="own-sidebar" class="sidebar">
			<? page_own_sidebar() ?>
		</aside>
<? } else { ?>
	<div id="content" class="content-without-sidebar <? page_type() ?>">
<? } ?>
	<aside id="general-sidebar" class="sidebar">
		<? page_sidebar() ?>
	</aside>
	<div id="body" role="main">
		<? page_body() ?>
	</div>
</div>
<? page_footer() ?>
