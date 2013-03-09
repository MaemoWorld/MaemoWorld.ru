<?php
require_once 'include.php'; // ���� ��� ������������ ������
require_once 'config.php'; // ���������
require_once 'lib/punbb.php'; // ������ � punbb


switch ($_GET['action']) { // � ����������� �� ���������� ���� ��������
	case 'in':
	case 'out':
		$action = $_GET['action']; // ��������� ���������� ��� ��������
		break;
	default:
		$action = null; // ��� ��������
}


$userEmail = General::trim($_GET['email']); // e-mail ��� ������
$userPassword = General::trim($_GET['password']); // ������ ��� ������


switch ($action) { // � ����������� �� ���� ��������
case 'in':
	if (Punbb::$user->isGuest()) Punbb::authenticateUser(Punbb::getAuthenticatedUser($userEmail, $userPassword)); // �������� ����������� ������������, ���� ������������ ��� �� �����������
	switch (General::$contentType) { // � ����������� �� ���� ������������� ������
	case 'json':
		echo json_encode(Punbb::$user->isGuest() ? false : Punbb::$user); // ������� ��������� �����������
		exit;
	case 'html':
	default:
		if (Punbb::$user->isGuest()) { // ���� ����������� ������ ���������
			General::setNextRedirect(General::$redirect); // � ��������� ��� ����� ��������������� ����� ��� ��
			Templates::$page = 'login'; // �������� �����������
			Templates::generatePage(); // ������������� ��������
		} else { // ���� ����������� �������
			General::redirect(); // ������� �� ���������
		}
	}
	break;
case 'out':
//		if (Punbb::$user->isGuest()) General::redirect(); // ������� �� ���������, ���� ������������ �� �����������
	break;
default:
//		if (!Punbb::$user->isGuest()) General::redirect(); // ������� �� ���������, ���� ������������ ��� �����������
	switch (General::$contentType) {
	case 'json':
		echo json_encode(Punbb::$user);
		break;
	case 'html':
	default:
		// todo
	}
}
