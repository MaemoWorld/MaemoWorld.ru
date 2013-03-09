<?php
/**
 * @file SRegAttributeMapTest.php
 * @brief Contains test class Ext_PunBB_SRegAttributeMapTest for Ext_PunBBD_SRegAttributeMap.
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
require_once 'Ext/PunBB/SRegAttributeMap.php';

/**
 * @brief Test class for Ext_PunBB_SRegAttributeMap.
 */
class Ext_PunBB_SRegAttributeMapTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_PunBB_SRegAttributeMap.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_PunBB_SRegAttributeMap, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_PunBB_SRegAttributeMap;
	}

	/**
	 * @brief Data provider: returns sets of PunBB database field names and corresponding OpenID SReg attributes.
	 * @return Array of test data sets.
	 */
	public function dataKnownValues()
	{
		return array(
			array('username', 'nickname'),
			array('email', 'email'),
			array('realname', 'fullname'),
			array('location', 'country'),
			array('language', 'language'),
			array('timezone', 'timezone'),
		);
	}

	/**
	 * @brief Data provider: returns strings not used as PunBB database field names.
	 * @return Array of test data sets.
	 */
	public function dataUnknownValues()
	{
		return array(
			array('url'),
			array('jabber'),
			array('foo'),
			array('bar')
		);
	}

	/**
	 * @brief Tests mapping of PunBB database field names to OpenID SReg attributes.
	 * @param $input PunBB database field name.
	 * @param $output Expected OpenID SReg attribute for \p $input.
	 * @dataProvider dataKnownValues
	 */
	public function testMappingOfKnownValues($input, $output)
	{
		$result = $this->object->map($input);
		$this->assertEquals($output, $result);
	}

	/**
	 * @brief Tests handling of values not known as PunBB database field names.
	 * @param $input Input string.
	 * @dataProvider dataUnknownValues
	 */
	public function testNoTamperingOfUnknownValues($input)
	{
		$result = $this->object->map($input);
		$this->assertEquals($input, $result);
	}
}
?>
