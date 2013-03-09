<?php
require_once 'include.php'; // ���� ��� ������������ ������
require_once 'config.php'; // ���������
require_once 'lib/punbb.php'; // ������ � punbb


if (isset($_REQUEST['name'])): // ���� ������� ���
	$tags = Punbb::getTagsbyName($_REQUEST['name']); // ������������� ���� ����������
	if (count($tags) > 0) { // ���� ���� ���� � ����� id
		$tagIds = array_keys($tags);
		$yagId = $tagIds[0];
	} else { // ���� ��� ����� � ����� id
		$tadId = false;
	}
else:
	$tagId = false;
endif;

if (isset($_REQUEST['catalog'])): // ���� ������ �������
	$catalog = $_REQUEST['catalog']; // ������������� ��������
else:
	$catalog = 'apps'; // �� ��������� ���� � ����������
endif;

$domain = $_SERVER['HTTP_HOST']; // ��� ������
Header('Location: http://'.$domain.'/navigator.php?catalog='.$catalog.'&tags%5B%5D='.$tagId); // ��������
exit;
