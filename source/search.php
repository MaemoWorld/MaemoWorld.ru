<?php
$domain = $_SERVER['HTTP_HOST']; // ��� ������

if (isset($_REQUEST['location'])): // ���� ������� ������� ������
	$location = strtolower($_REQUEST['location']); // ������� ������
else:
	$location = 'google'; // ������� ������ �� ���������
endif;

if ($location == 'google'): // ���� ����� � google
	if (isset($_REQUEST['site'])): // ���� ������ ���� �� ������� ������
		$site = $_REQUEST['site']; // ����
	else:
		$site = $domain	; // ���� � ������� ������
	endif;
endif;

$query = $_REQUEST['query']; // ������ ������

if ($location == 'google'): // ���� ����� � google
//	Header('Location: http://www.google.ru/search?q='.$query.' site:'.$site.'&ie=utf-8&oe=utf-8&aq=t&rls='.$domain); // ��������
	Header('Location: http://www.google.com/webhp?rls='.$domain.'&domains='.$site.'&ie=UTF-8&oe=UTF-8&sitesearch='.$site.'#sclient=psy-ab&sitesearch='.$site.'&q='.$query.'&cx=partner-pub-0247061343724296:9160314993');
	exit;
//http://www.google.com/webhp?domains=http://meegos.ru&ie=UTF-8&oe=UTF-8&btnG=Search&sitesearch=http://meegos.ru#sclient=psy-ab&domains=http:%2F%2Fmeegos.ru&q=request&sitesearch=http:%2F%2Fmeegos.ru&fp=1
endif;
?>