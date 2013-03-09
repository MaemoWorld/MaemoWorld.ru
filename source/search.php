<?php
$domain = $_SERVER['HTTP_HOST']; // имя домена

if (isset($_REQUEST['location'])): // если указана область поиска
	$location = strtolower($_REQUEST['location']); // область поиска
else:
	$location = 'google'; // область поиска по умолчанию
endif;

if ($location == 'google'): // если поиск в google
	if (isset($_REQUEST['site'])): // если указан сайт на котором искать
		$site = $_REQUEST['site']; // сайт
	else:
		$site = $domain	; // ищем в текущем домене
	endif;
endif;

$query = $_REQUEST['query']; // запрос поиска

if ($location == 'google'): // если поиск в google
//	Header('Location: http://www.google.ru/search?q='.$query.' site:'.$site.'&ie=utf-8&oe=utf-8&aq=t&rls='.$domain); // редирект
	Header('Location: http://www.google.com/webhp?rls='.$domain.'&domains='.$site.'&ie=UTF-8&oe=UTF-8&sitesearch='.$site.'#sclient=psy-ab&sitesearch='.$site.'&q='.$query.'&cx=partner-pub-0247061343724296:9160314993');
	exit;
//http://www.google.com/webhp?domains=http://meegos.ru&ie=UTF-8&oe=UTF-8&btnG=Search&sitesearch=http://meegos.ru#sclient=psy-ab&domains=http:%2F%2Fmeegos.ru&q=request&sitesearch=http:%2F%2Fmeegos.ru&fp=1
endif;
?>