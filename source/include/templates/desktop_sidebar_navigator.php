<? ob_start() ?>
	<form action="<? navigator_url() ?>" method="get" >
		<select name="catalog">
			<? foreach (data('navigator/catalogs') as $catalogId => $catalog) { ?>
				<? if (data('navigator/catalog/id') == $catalogId) { ?>
					<option value="<? the($catalogId) ?>" selected="true"><? the($catalog['name']) ?></option>
				<? } else { ?>
					<option value="<? the($catalogId) ?>"><? the($catalog['name']) ?></option>
				<? } ?>
			<? } ?>
		</select>
		<input type="submit" value="Перейти">
	</form>
<? $sidebox_body = ob_get_clean() ?>
<? page_sidebox('Каталог', $sidebox_body, 'nav') ?>
<? if (page_subtype(false) == 'catalog') { ?>
	<? ob_start() ?>
		<form action="<? navigator_url() ?>" method="get">
			<input type="hidden" name="catalog" value="<? data('navigator/catalog/id', true) ?>">
			<input type="submit" value="Выбрать">
			<select name="sortBy">
				<option value="subject" <? the(data('navigator/sort_by') == 'subject' ? 'selected' : '') ?>>по теме</option>
				<option value="postId" <? the(data('navigator/sort_by') == 'post-id' ? 'selected' : '') ?>>по времени</option>
			</select>
			<select name="sortDesc">
				<option value="true" <? the(data('navigator/sort_dec') ? 'selected' : '') ?>>по убыванию</option>
				<option value="false" <? the(data('navigator/sort_dec') ? '' : 'selected') ?>>по возрастанию</option>
			</select>
			<? foreach (data('navigator/catalog/tag_groups') as $tagGroup) { ?>
				<? if (!$tagGroup['is_required'] || count($tagGroup['tags']) > 1) {?>
					<? if (count($tagGroup['tags']) > 5) { ?>
						<select name="tags[]" size="6" multiple>
					<? } else { ?>
						<select name="tags[]" size="<? the(count($tagGroup['tags'])) ?>" multiple>
					<? } ?>
						<optgroup label="<? the($tagGroup['name']) ?>">
							<? foreach ($tagGroup['tags'] as $tagId => $tagSelected) { ?>
								<? if($tagSelected) { ?>
									<option value="<? the($tagId) ?>" selected><? data('navigator/tags/'.$tagId, true) ?></option>
								<? } else { ?>
									<option value="<? the($tagId) ?>"><? data('navigator/tags/'.$tagId, true) ?></option>
								<? } ?>
							<? } ?>
						</optgroup>
					</select>
				<? } ?>
			<? } ?>
			<input type="submit" value="Выбрать">
		</form>
	<? $sidebox_body = ob_get_clean() ?>
	<? page_sidebox(false, $sidebox_body, 'nav') ?>
<? } ?>
