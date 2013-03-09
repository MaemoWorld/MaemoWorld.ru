<?php
require_once 'include.php'; // пути для подключаемых файлов
require_once 'config.php'; // найтройки
require_once 'lib/punbb.php'; // работа с punbb

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
