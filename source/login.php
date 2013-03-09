<?php
/*******************************************************************************
*                                                                              *
*  ���������� ������������.                                                    *
*                                                                              *
*  Copyright (C) 2012 Kirill Chuvilin.                                         *
*  Contact: Kirill Chuvilin (kirill.chuvilin@gmail.com, kirill.chuvilin.pro)   *
*                                                                              *
*  This file is a part of the MaemoWorld.ru project.                           *
*  https://github.com/MaemoWorld/MaemoWorld.ru                                 *
*                                                                              *
*  $QT_BEGIN_LICENSE:GPL$                                                      *
*                                                                              *
*  GNU General Public License Usage                                            *
*  Alternatively, this file may be used under the terms of the GNU General     *
*  Public License version 3.0 as published by the Free Software Foundation     *
*  and appearing in the file LICENSE.GPL included in the packaging of this     *
*  file. Please review the following information to ensure the GNU General     *
*  Public License version 3.0 requirements will be met:                        *
*  http://www.gnu.org/copyleft/gpl.html.                                       *
*                                                                              *
*  This file is distributed in the hope that it will be useful, but WITHOUT    *
*  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or       *
*  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for    *
*  more details.                                                               *
*                                                                              *
*  $QT_END_LICENSE$                                                            *
*                                                                              *
*******************************************************************************/

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
