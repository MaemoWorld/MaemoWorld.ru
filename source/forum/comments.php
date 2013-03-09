<?php
define('FORUM_QUIET_VISIT', 1);

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';

($hook = get_hook('ex_start')) ? eval($hook) : null;

// The length at which topic subjects will be truncated (for HTML output)
if (!defined('FORUM_EXTERN_MAX_SUBJECT_LENGTH'))
    define('FORUM_EXTERN_MAX_SUBJECT_LENGTH', 30);

// If we're a guest and we've sent a username/pass, we can try to authenticate using those details
if ($forum_user['is_guest'] && isset($_SERVER['PHP_AUTH_USER']))
	authenticate_user($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

if ($forum_user['g_read_board'] == '0')
{
	http_authenticate_user();
	exit($lang_common['No view']);
}

//
// Sends the proper headers for Basic HTTP Authentication
//
function http_authenticate_user()
{
	global $forum_config, $forum_user;

	if (!$forum_user['is_guest'])
		return;

	header('WWW-Authenticate: Basic realm="'.$forum_config['o_board_title'].' External Syndication"');
	header('HTTP/1.0 401 Unauthorized');
}

/*
  Вывод в HTML для комменатиев.
*/
function output_comments($feed)
{
	global $tid; // ID топика
	global $cur_topic; // информация о топике
	global $forum_user; // информация о пользователе
	global $forum_url; // ссылки форума

	// Отправляем заголовочную информацию.
	header('Content-type: text/html; charset=utf-8');
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

//	foreach($cur_topic as $key => $value)
//	foreach($forum_url as $key => $value)
//	foreach($forum_user as $key => $value)
//		echo $key.' => '.$value.'<br>';
//	exit;
	
	if ($forum_user['g_read_board'] == '0') { // если пользователь не может читать форум
		echo '<div class="message">Для чтения комментариев с форума необходимо <a href="'.forum_link($forum_url['login']).'">пройти авторизацию</a>.</div>'."\n";
		exit;
	}

//	echo 'title: '.forum_htmlencode($feed['title']).'<br>'."\n";
//	echo 'description: '.forum_htmlencode($feed['description']).'<br>'."\n";
//	echo 'link: '.forum_htmlencode($feed['link']).'<br>'."\n";

	echo '<header>'."\n";
	echo '	<h1><a href="'.forum_link($forum_url['topic'], $tid).'">'.$cur_topic['subject'].'</a></h1>'."\n";
	echo '	<a href="'.forum_link($forum_url['topic_rss'], $tid).'" class="rss-url">RSS-лента комментариев</a>'."\n";
	echo '</header>'."\n";

	echo '<section id="reply">'."\n";
	if ($forum_user['is_guest']) { // если гость смотрит
		echo '	<p>Для того, чтобы оставить комментарий, необходимо <a href="'.forum_link($forum_url['login']).'">авторизоваться на форуме</a>.</p>';
	} else { // если не гость смотрит
		echo '	<form method="post" accept-charset="utf-8" action="'.forum_link($forum_url['new_reply'], $tid).'">'."\n";
		echo '		<input name="form_sent" value="1" type="hidden">'."\n";
		echo '		<input name="form_user" value="'.$forum_user['username'].'" type="hidden">'."\n";
		echo '		<input name="csrf_token" value="'.generate_form_token(forum_link($forum_url['new_reply'], $tid)).'" type="hidden">'."\n";
		echo '		<div class="textarea"><textarea name="req_message" rows="7" required></textarea></div>'."\n";
		echo '		<p>Перед отправкой убедитесь, что соблюдаете <a href="'.forum_link($forum_url['rules']).'">правила</a>!</p>'."\n";
		echo '		<input name="submit" value="Отправить" type="submit" class="default">'."\n";
		echo '		<input name="preview" value="Предпросмотр" type="submit">'."\n";
		echo '	</form>'."\n";
	}
	echo '</section>'."\n";

	foreach ($feed['items'] as $item)
	{
		echo '<article>'."\n";
		echo '	<header>'."\n";
		echo '		<a href="'.$item['link'].'"><time pubdate>'.date('H:i:s j M Y', $item['pubdate']).'</time></a>'."\n";
		echo '		<address>'."\n";
		if (isset($item['author']['uri'])) { // если есть ссылка на отправителя
			echo '			<a href="'.$item['author']['uri'].'">'.forum_htmlencode($item['author']['name']).'</a>'."\n";
		} else { // нет ссылки на отправителя
			echo '			'.forum_htmlencode($item['author']['name'])."\n";
		}
		echo '		</address>'."\n";
		echo '	</header>'."\n";
		echo '	'.$item['description']."\n";
		echo '</article>'."\n";
	}
}


	$show = isset($_GET['show']) ? intval($_GET['show']) : 15;
	if ($show < 1 || $show > 50)
		$show = 15;

	($hook = get_hook('ex_set_syndication_type')) ? eval($hook) : null;

	// Was a topic ID supplied?
	if (isset($_GET['tid']))
	{
		$tid = intval($_GET['tid']);

		// Fetch topic subject
		$query = array(
			'SELECT'	=> 't.subject, t.first_post_id',
			'FROM'		=> 'topics AS t',
			'JOINS'		=> array(
				array(
					'LEFT JOIN'		=> 'forum_perms AS fp',
					'ON'			=> '(fp.forum_id=t.forum_id AND fp.group_id='.$forum_user['g_id'].')'
				)
			),
			'WHERE'		=> '(fp.read_forum IS NULL OR fp.read_forum=1) AND t.moved_to IS NULL and t.id='.$tid
		);

		($hook = get_hook('ex_qr_get_topic_data')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		if (!$forum_db->num_rows($result))
		{
			http_authenticate_user();
			exit($lang_common['Bad request']);
		}

		$cur_topic = $forum_db->fetch_assoc($result);

		if (!defined('FORUM_PARSER_LOADED'))
			require FORUM_ROOT.'include/parser.php';

		if ($forum_config['o_censoring'] == '1')
			$cur_topic['subject'] = censor_words($cur_topic['subject']);

		// Setup the feed
		$feed = array(
			'title' 		=>	$forum_config['o_board_title'].$lang_common['Title separator'].$cur_topic['subject'],
			'link'			=>	forum_link($forum_url['topic'], array($tid, sef_friendly($cur_topic['subject']))),
			'description'	=>	sprintf($lang_common['RSS description topic'], $cur_topic['subject']),
			'items'			=>	array(),
			'type'			=>	'posts'
		);

		// Fetch $show posts
		$query = array(
			'SELECT'	=> 'p.id, p.poster, p.message, p.hide_smilies, p.posted, p.poster_id, u.email_setting, u.email, p.poster_email',
			'FROM'		=> 'posts AS p',
			'JOINS'		=> array(
				array(
					'INNER JOIN'	=> 'users AS u',
					'ON'		=> 'u.id = p.poster_id'
				)
			),
			'WHERE'		=> 'p.topic_id='.$tid,
			'ORDER BY'	=> 'p.posted DESC',
			'LIMIT'		=> $show
		);

		($hook = get_hook('ex_qr_get_posts')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		while ($cur_post = $forum_db->fetch_assoc($result))
		{
			if ($forum_config['o_censoring'] == '1')
				$cur_post['message'] = censor_words($cur_post['message']);

			$cur_post['message'] = parse_message($cur_post['message'], $cur_post['hide_smilies']);

			$item = array(
				'id'			=>	$cur_post['id'],
				'title'			=>	$cur_topic['first_post_id'] == $cur_post['id'] ? $cur_topic['subject'] : $lang_common['RSS reply'].$cur_topic['subject'],
				'link'			=>	forum_link($forum_url['post'], $cur_post['id']),
				'description'	=>	censor_words($cur_post['message']),
				'author'		=>	array(
					'name'	=> $cur_post['poster'],
				),
				'pubdate'		=>	$cur_post['posted']
			);

			if ($cur_post['poster_id'] > 1)
			{
				if ($cur_post['email_setting'] == '0' && !$forum_user['is_guest'])
					$item['author']['email'] = $cur_post['email'];

				$item['author']['uri'] = forum_link($forum_url['user'], $cur_post['poster_id']);
			}
			else if ($cur_post['poster_email'] != '' && !$forum_user['is_guest'])
				$item['author']['email'] = $cur_post['poster_email'];

			$feed['items'][] = $item;

			($hook = get_hook('ex_modify_cur_post_item')) ? eval($hook) : null;
		}

		($hook = get_hook('ex_pre_topic_output')) ? eval($hook) : null;

		$output_func = 'output_comments';
		$output_func($feed);
	}
	else
	{
		$forum_name = '';

		if (!defined('FORUM_PARSER_LOADED'))
			require FORUM_ROOT.'include/parser.php';

		// Were any forum ID's supplied?
		if (isset($_GET['fid']) && is_scalar($_GET['fid']) && $_GET['fid'] != '')
		{
			$fids = explode(',', forum_trim($_GET['fid']));
			$fids = array_map('intval', $fids);

			if (!empty($fids))
				$forum_sql = ' AND t.forum_id IN('.implode(',', $fids).')';

			if (count($fids) == 1)
			{
			// Fetch forum name
			$query = array(
				'SELECT'	=> 'f.forum_name',
				'FROM'		=> 'forums AS f',
				'JOINS'		=> array(
					array(
						'LEFT JOIN'		=> 'forum_perms AS fp',
						'ON'			=> '(fp.forum_id=f.id AND fp.group_id='.$forum_user['g_id'].')'
					)
				),
				'WHERE'		=> '(fp.read_forum IS NULL OR fp.read_forum=1) AND f.id='.$fids[0]
			);

			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
			if ($forum_db->num_rows($result))
				$forum_name = $lang_common['Title separator'].$forum_db->result($result);
			}
		}

		// Any forum ID's to exclude?
		if (isset($_GET['nfid']) && is_scalar($_GET['nfid']) && $_GET['nfid'] != '')
		{
			$nfids = explode(',', forum_trim($_GET['nfid']));
			$nfids = array_map('intval', $nfids);

			if (!empty($nfids))
				$forum_sql = ' AND t.forum_id NOT IN('.implode(',', $nfids).')';
		}

		// Setup the feed
		$feed = array(
			'title' 		=>	$forum_config['o_board_title'].$forum_name,
			'link'			=>	forum_link($forum_url['index']),
			'description'	=>	sprintf($lang_common['RSS description'], $forum_config['o_board_title']),
			'items'			=>	array(),
			'type'			=>	'topics'
		);

		// Fetch $show topics
		$query = array(
			'SELECT'	=> 't.id, t.poster, t.subject, t.last_post, t.last_poster, p.message, p.hide_smilies, u.email_setting, u.email, p.poster_id, p.poster_email',
			'FROM'		=> 'topics AS t',
			'JOINS'		=> array(
				array(
					'INNER JOIN'	=> 'posts AS p',
					'ON'			=> 'p.id=t.first_post_id'
				),
				array(
					'INNER JOIN'		=> 'users AS u',
					'ON'			=> 'u.id = p.poster_id'
				),
				array(
					'LEFT JOIN'		=> 'forum_perms AS fp',
					'ON'			=> '(fp.forum_id=t.forum_id AND fp.group_id='.$forum_user['g_id'].')'
				)
			),
			'WHERE'		=> '(fp.read_forum IS NULL OR fp.read_forum=1) AND t.moved_to IS NULL',
			'ORDER BY'	=> 't.last_post DESC',
			'LIMIT'		=> $show
		);

		if (isset($forum_sql))
			$query['WHERE'] .= $forum_sql;

		($hook = get_hook('ex_qr_get_topics')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		while ($cur_topic = $forum_db->fetch_assoc($result))
		{
			if ($forum_config['o_censoring'] == '1')
			{
				$cur_topic['subject'] = censor_words($cur_topic['subject']);
				$cur_topic['message'] = censor_words($cur_topic['message']);
			}

			$cur_topic['message'] = parse_message($cur_topic['message'], $cur_topic['hide_smilies']);

			$item = array(
				'id'			=>	$cur_topic['id'],
				'title'			=>	$cur_topic['subject'],
				'link'			=>	forum_link($forum_url['topic_new_posts'], array($cur_topic['id'], sef_friendly($cur_topic['subject']))),
				'description'	=>	$cur_topic['message'],
				'author'		=>	array(
					'name'	=> $cur_topic['last_poster']
				),
				'pubdate'		=>	$cur_topic['last_post']
			);

			if ($cur_topic['poster_id'] > 1)
			{
				if ($cur_topic['email_setting'] == '0' && !$forum_user['is_guest'])
					$item['author']['email'] = $cur_topic['email'];

				$item['author']['uri'] = forum_link($forum_url['user'], $cur_topic['poster_id']);
			}
			else if ($cur_topic['poster_email'] != '' && !$forum_user['is_guest'])
				$item['author']['email'] = $cur_topic['poster_email'];

			$feed['items'][] = $item;

			($hook = get_hook('ex_modify_cur_topic_item')) ? eval($hook) : null;
		}

		($hook = get_hook('ex_pre_forum_output')) ? eval($hook) : null;

		$output_func = 'output_comments';
		$output_func($feed);
	}

	exit;
