<? if (have_posts()) { ?>
	<? while (have_posts()) : the_post(); ?>
		<? $forum_topicId = get_post_meta(get_the_ID(), 'forum_topicId', true) ?>
		<? $title = get_the_title()?>
		<? $permalink = get_permalink()?>
		<? ob_start() ?>
			<h1><? the($title) ?></h1>
			<? page_sharemenu($permalink, $title) ?>
			<? edit_post_link(''); ?>
			<address><? the_author () ?></address>
			<time pubdate><? the_time('d M Y') ?></time>
		<? $bodybox_top = ob_get_clean() ?>
		<? ob_start() ?>
			<? the_content('Читать полностью &raquo;'); ?>
			<? link_pages('<p><strong>Страницы:</strong> ', '</p>', 'number'); ?>
			<? if ($forum_topicId) { ?>
				<? page_comments($forum_topicId) ?>
			<? } ?>
		<? $bodybox_body = ob_get_clean() ?>
		<? if ($forum_topicId) { ?>
			<? ob_start() ?>
			<a class="comments-link" href = "<? forum_topic_url($forum_topicId)?>">Обсуждение</a>
			<? $bodybox_bottom = ob_get_clean() ?>
		<? } else { ?>
			<? $bodybox_bottom = false ?>
		<? } ?>
		<? page_bodybox($bodybox_top, $bodybox_body, $bodybox_bottom, 'article', array('id' => 'page-'.get_the_ID())) ?>
	<? endwhile; ?>
<? } else { ?>
	<? ob_start() ?>
		<p>К сожалению, по вашему запросу ничего не найдено.</p>
	<? $bodybox_body = ob_get_clean() ?>
	<? bodybox('<h1>Не найдено</h1>', $bodybox_body, false, 'section') ?>
<? } ?>
