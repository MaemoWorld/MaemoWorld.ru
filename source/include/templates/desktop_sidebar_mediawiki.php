<? ob_start();?>
	<ul>
		<? foreach(data('wiki/personal_urls') as $key => $item) { ?>
			<li id="<? the(Sanitizer::escapeId( 'pt-'.$key )) ?>"
			<? if ($item['active']) { ?>
				class="active"
			<? } ?>
			><a href="<? the($item['href']) ?>"<? the(data('wiki/skin')->tooltipAndAccesskey('pt-'.$key)) ?>
			<? if(!empty($item['class'])) { ?>
				class="<? the($item['class']) ?>"
			<? } ?>
			><? the($item['text']) ?></a></li>
		<? } ?>
	</ul>
<? $sidebox_body = ob_get_clean() ?>
<? page_sidebox('Личные инструменты', $sidebox_body, 'nav', array('id' => 'p-personal')) ?>

<?
	// генерация бокового меню
	$sidebar = data('wiki/sidebar');
	if ( !isset( $sidebar['SEARCH'] ) ) $sidebar['SEARCH'] = true;
	if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
	if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;
?>
<? foreach ($sidebar as $boxName => $cont) { ?>
	<? if ( $boxName == 'SEARCH' ) { ?>
		<? global $wgUseTwoButtonsSearchForm; ?>
		<? ob_start() ?>
			<label for="searchInput">Поиск</label>
		<? $sidebox_name = ob_get_clean() ?>
		<? ob_start() ?>
			<div id="searchBody">
				<form action="<? data('wiki/wgScript', true) ?>" id="searchform">
					<input type='hidden' name="title" value="<? data('wiki/searchtitle', true) ?>"/>
					<input id="searchInput" name="search" type="text"<? the(data('wiki/skin')->tooltipAndAccesskey('search')) ?>
					<? if( !is_null( data('wiki/search') ) ) { ?>
						value="<? data('wiki/search') ?>"
					<? } ?>
					/>
					<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="Перейти" <? the(data('wiki/skin')->tooltipAndAccesskey( 'search-go' )) ?> />
					<? if ($wgUseTwoButtonsSearchForm) { ?>
						<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="Найти" <? the(data('wiki/skin')->tooltipAndAccesskey( 'search-fulltext' )) ?> />
					<? } else { ?>
						<div><a href="<? data('wiki/searchaction', true) ?>" rel="search">Поиск</a></div>
					<? } ?>
				</form>
			</div>
		<? $sidebox_body = ob_get_contents() ?>
		<? ob_end_clean() ?>
		<? page_sidebox($sidebox_name, $sidebox_body, 'nav', array('id' => 'p-search')) ?>
	<? } elseif ( $boxName == 'TOOLBOX' ) { ?>
		<? ob_start() ?>
			Инструменты
		<? $sidebox_name = ob_get_contents() ?>
		<? ob_end_clean() ?>
		<? ob_start() ?>
			<ul>
				<? if(data('wiki/notspecialpage')) { ?>
					<li id="t-whatlinkshere"><a href="<? data('wiki/nav_urls/whatlinkshere/href', true) ?>"<? the(data('wiki/skin')->tooltipAndAccesskey('t-whatlinkshere')) ?>>Ссылки на страницу</a></li>
					<? if( data('wiki/nav_urls/recentchangeslinked') ) { ?>
						<li id="t-recentchangeslinked"><a href="<? data('wiki/nav_urls/recentchangeslinked/href', true) ?>"<? the(data('wiki/skin')->tooltipAndAccesskey('t-recentchangeslinked')) ?>>Последние изменения</a></li>
					<? } ?>
				<? } ?>
				<? if(!is_null(data('wiki/nav_urls/trackbacklink'))) { ?>
					<li id="t-trackbacklink"><a href="<? data('wiki/nav_urls/trackbacklink/href', true) ?>"<? the(data('wiki/skin')->tooltipAndAccesskey('t-trackbacklink')) ?>>Обратные ссылки</a></li>
				<? } ?>
				<? if(data('wiki/feeds')) { ?>
					<li id="feedlinks">
						<? foreach(data('wiki/feeds') as $key => $feed) { ?>
							<a id="<? the(Sanitizer::escapeId("feed-$key")) ?>" href="<? the(htmlspecialchars($feed['href'])) ?>" rel="alternate" type="application/<?php echo $key ?>+xml" class="feedlink" <? data('wiiki/skin')->tooltipAndAccesskey('feed-'.$key) ?>><? the(htmlspecialchars($feed['text'])) ?></a>&nbsp;
						<? } ?>
					</li>
				<? } ?>
				<? foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) { ?>
					<? if(data('wiki/nav_urls/'.$special)) { ?>
						<li id="t-<?php the($special) ?>"><a href="<? data('wiki/nav_urls/'.$special.'/href') ?>"<?php the(data('wiki/skin')->tooltipAndAccesskey('t-'.$special)) ?>>Специальные страницы</a></li>
					<? } ?>
				<? } ?>
				<? if(!is_null(data('wiki/nav_urls/permalink/href'))) { ?>
					<li id="t-permalink"><a href="<? data('wiki/nav_urls/permalink/href') ?>"<? the(data('wiki/skin')->tooltipAndAccesskey('t-permalink')) ?>>Постоянная ссылка</a></li>
				<? } elseif (data('wiki/nav_urls/permalink/href') === '') { ?>
					<li id="t-ispermalink"<? the(data('wiki/skin')->tooltip('t-ispermalink')) ?>><? templates::$generator->msg('permalink') ?></li>
				<? } ?>
				<? //wfRunHooks( 'MaemoWorldRuTemplateToolboxEnd', array( &templates::$generator ) ); ?>
				<? //wfRunHooks( 'SkinTemplateToolboxEnd', array( &templates::$generator ) ); ?>
			</ul>
		<? $sidebox_body = ob_get_contents() ?>
		<? ob_end_clean() ?>
		<? page_sidebox($sidebox_name, $sidebox_body, 'nav', array('id' => 'p-tb')) ?>
	<? } elseif ( $boxName == 'LANGUAGES' ) { ?>
		<? if( data('wiki/language_urls') ) { ?>
			<? ob_start() ?>
				<? templates::$generator->msg('otherlanguages') ?>
			<? $sidebox_name = ob_get_contents() ?>
			<? ob_end_clean() ?>
			<? ob_start() ?>
				<ul>
					<? foreach(data('wiki/language_urls') as $langlink) { ?>
						<li class="<? the(htmlspecialchars($langlink['class']))?>"><a href="<? the(htmlspecialchars($langlink['href'])) ?>"><? the($langlink['text']) ?></a></li>
					<? } ?>
				</ul>
			<? $sidebox_body = ob_get_contents() ?>
			<? ob_end_clean() ?>
			<? page_sidebox($sidebox_name, $sidebox_body, 'nav', array('id' => 'p-lang')) ?>
		<? } ?>
	<? } else { ?>
		<? 
			$sidebox_id = Sanitizer::escapeId('p-'.$boxName); // + '"' + templates::$generator->skin->tooltip('p-'.$boxName)
			$out = wfMsg($boxName);
			if (wfEmptyMsg($boxName, $out))
				$sidebox_name = $boxName;
			else
				$sidebox_name= $out;
		?>
		<? ob_start() ?>
			<? if (is_array($cont)) { ?>
				<ul>
					<? foreach($cont as $key => $val) { ?>
						<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<? $val['active'] ? the('class="active"') : the('') ?>>
							<a href="<? the(htmlspecialchars($val['href'])) ?>"<? the(data('wiki/skin')->tooltipAndAccesskey($val['id'])) ?>><? the(htmlspecialchars($val['text'])) ?></a>
						</li>
					<? } ?>
				</ul>
			<? } else { ?>
				<? the($cont) ?>
			<? } ?>
		<? $sidebox_body = ob_get_contents() ?>
		<? ob_end_clean() ?>
		<? page_sidebox($sidebox_name, $sidebox_body, 'nav', array('id' => $sidebox_id)) ?>
	<? } ?>
<? } ?>
