<nav class="breadcrumbs">
	<h1>Хлебные крошки</h1>
	<ul>
		<? $iBreadcrumb = count(data('page/breadcrumbs')) ?>
		<? if ($iBreadcrumb > 0) { ?>
			<li><a href="<? host_url() ?>"><? portal_name() ?></a></li>
		<? } else { ?>
			<li class="current"><span class="current"><? portal_name() ?></span></li>
		<? } ?>
		<? $iBreadcrumb-- ?>
		<? foreach (data('page/breadcrumbs') as $breadcrumb) { ?>
			<? if ($iBreadcrumb <= 0) { ?>
				<li class="current"><span><? the($breadcrumb['name']) ?></span></li>
			<? } else if ($breadcrumb['link']) { ?>
				<li><a href="<? the($breadcrumb['link']) ?>"><? the($breadcrumb['name']) ?></a></li>
			<? } else { ?>
				<li><span><? the($breadcrumb['name']) ?></span></li>
			<? } ?>
			<? $iBreadcrumb-- ?>
		<? } ?>
	</ul>
</nav>
