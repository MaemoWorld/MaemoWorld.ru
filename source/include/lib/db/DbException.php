<?php
/*******************************************************************************************************************************
*                                                                                                                              *
*  Класс, реализующий работу с исключениями баз данных.                                                                        *
*  Совместимость: PHP 5                                                                                                        *
*  by Кирилл Чувилин aka KiRiK (kirik-ch.ru)                                                                                   *
*                                                                                                                              *
*  Реализован в рамках проекта MaemoWorld.ru                                                                                   *
*                                                                                                                              *
*  Запрещено использование библиотеки или ее фрагментов:                                                                       *
*  - в коммерческих проектах                                                                                                   *
*  - без указания информации об авторстве                                                                                      *
*                                                                                                                              *
*  Для поддержки развития проекта или  просто благодарности можете пополнить яндекс-счет 41001384352607.                       *
*                                                                                                                              *
*******************************************************************************************************************************/

class DbException extends Exception {
	const CONNECTION = 1; // исключение при подключении к базе
	const QUERY      = 2; // исключение при выполнении запроса
	const SELECT_DB  = 3; // исключение при выборе базы
}