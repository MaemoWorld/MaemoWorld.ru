<?php
/*******************************************************************************
*                                                                              *
*  Работа с баркодом.                                                          *
*                                                                              *
*  Copyright (C) 2010-2012 Kirill Chuvilin.                                    *
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

require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/Punbb.php'; // работа с punbb

General::$data['barcode'] = array(); // параметры баркода

if (isset($_GET['url'])) { // если указана ссылка
	General::$data['barcode']['action'] = 'url'; // действие для обработки ссылки
	General::$data['barcode']['value'] = $_GET['url'];
} elseif (isset($_REQUEST['text'])) { // если указана ссылка
	General::$data['barcode']['action'] = 'text'; // действие для обработки ссылки
	General::$data['barcode']['value'] =  $_GET['text'];
} else {
	General::$data['barcode']['action'] = null; // действие по умолчанию
	General::$data['barcode']['value'] =  '';
}

General::$data['barcode']['image_url'] = General::barcodeImageUrl(General::$data['barcode']['value']);

switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
case 'json':
	echo json_encode(General::$data['barcode']); // вывести результат
	exit;
case 'html':
default:
	General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
		'name' => 'Баркод',
		'link' => barcode_url(false)
	);
	Template::generatePage('barcode'); // сгенерировать страницу
	exit;
}
