<?php
/**
 * @file RequestStorageTest.php
 * @brief Contains test class Ext_RequestStorageTest for Ext_RequestStorage.
 */

/*
 *      Copyright 2009 Alexander Steffen <devel.20.webmeister@spamgourmet.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


require_once 'PHPUnit/Framework.php';
require_once 'Ext/RequestStorage.php';

/**
 * @brief Test class for Ext_RequestStorage.
 */
class Ext_RequestStorageTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_RequestStorage.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_RequestStorage, saved in \a $object.
	 */
	protected function setUp()
	{
		// pretend that a session has already been started
		session_id('test');

		$this->object = new Ext_RequestStorage;
	}

	/**
	 * @brief Data provider: returns key/value pairs used as global variables.
	 * @return Array of test data sets.
	 */
	public function dataGlobals()
	{
		return array(
			array('key', 'value'),
			array('flag', true),
			array('number', 42),
			array('object', new stdClass),
		);
	}

	/**
	 * @brief Data provider: returns key/value pairs used as data of superglobal variables.
	 * @return Array of test data sets.
	 */
	public function dataSuperglobals()
	{
		return array(
			array('_GET', 'key', 'value'),
			array('_POST', 'flag', true),
			array('_POST', 'number', 42),
			array('_POST', 'object', new stdClass),
		);
	}

	/**
	 * @brief Tests whether values of global variables are successfully saved and restored.
	 * @param $key Name of global variable.
	 * @param $value Value used for testing.
	 * @dataProvider dataGlobals
	 */
	public function testSaveAndRestoreOfGlobalVariables($key, $value)
	{
		$GLOBALS[$key] = $value;
		$this->object->save($key);
		unset($GLOBALS[$key]);
		$this->object->restore();
		$this->assertEquals($value, $GLOBALS[$key]);
	}

	/**
	 * @brief Tests whether values of superglobal variables are successfully saved and restored.
	 * @param $source Name of superglobal variable.
	 * @param $key Key in superglobal variable.
	 * @param $value Value used for testing.
	 * @dataProvider dataSuperglobals
	 */
	public function testSaveAndRestoreOfSuperglobalVariables($source, $key, $value)
	{
		$GLOBALS[$source][$key] = $value;
		$this->object->save($source, $key);
		unset($GLOBALS[$source][$key]);
		$this->object->restore();
		$this->assertEquals($value, $GLOBALS[$source][$key]);
	}
}
?>
