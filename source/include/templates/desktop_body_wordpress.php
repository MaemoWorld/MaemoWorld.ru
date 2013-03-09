<? if (have_posts()) { ?>
	<? while (have_posts()) : the_post(); ?>
		<? $forum_topicId = get_post_meta(get_the_ID(), 'forum_topicId', true) ?>
		<? $title = get_the_title()?>
		<? $permalink = get_permalink()?>
		<? ob_start() ?>
			<h1><a href="<? the($permalink) ?>" title="Постоянная ссылка: <? the($title) ?>"><? the($title) ?></a></h1>
			<? page_sharemenu($permalink, $title) ?>
			<? edit_post_link(''); ?>
			<address><? the_author () ?></address>
			<time pubdate><? the_time('d M Y') ?></time>
		<? $bodybox_top = ob_get_clean() ?>
		<? ob_start() ?>
			<? the_content('Читать полностью &raquo;'); ?>
		<? $bodybox_body = ob_get_clean() ?>
		<? ob_start() ?>
			<nav class="categories">
				<h1>Рубрики</h1>
				<? the_category(', ') ?>
			</nav>
			<? if ($forum_topicId) { ?>
				<a class="comments-link" href = "<? the($permalink)?>#comments">Комментарии</a>
			<? } ?>
		<? $bodybox_bottom = ob_get_clean() ?>
		<? page_bodybox($bodybox_top, $bodybox_body, $bodybox_bottom, 'article', array('id' => 'post-'.get_the_ID())) ?>
	<? endwhile; ?>
	<?global $wp_query ?>
	<? $max_num_pages = $wp_query->max_num_pages ?>
	<? if($max_num_pages > 1) { ?>
		<? ob_start() ?>
			<? next_posts_link('&laquo; Предыдущая страница') ?>
			<? previous_posts_link('Следующая страница &raquo;') ?>
		<? $bodybox_body = ob_get_clean() ?>
		<? page_bodybox(false, $bodybox_body, false, 'nav') ?>
	<? } ?>
<? } else { ?>
	<? ob_start() ?>
		<p>К сожалению, по вашему запросу ничего не найдено.</p>
	<? $bodybox_body = ob_get_clean() ?>
	<? bodybox('<h1>Не найдено</h1>', $bodybox_body, false, 'section') ?>
<? } ?>
