<?php
/**
 * @file SRegRequestTest.php
 * @brief Contains test class Ext_OpenID_SRegRequestTest for Ext_OpenID_SRegRequest.
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
require_once 'Ext/OpenID/SRegRequest.php';

/**
 * @brief Test class for Ext_OpenID_SRegRequest.
 */
class Ext_OpenID_SRegRequestTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_OpenID_AttributeList.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_OpenID_SRegRequest, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_OpenID_SRegRequest;
	}

	/**
	 * @brief Data provider: returns sets of required and optional attributes.
	 * @return Array of test data sets.
	 */
	public function data()
	{
		return array(
			array(
				array('nickname'),
				array('timezone')
			),
			array(
				array('email'),
				array()
			),
			array(
				array(),
				array('fullname', 'country')
			)
		);
	}

	/**
	 * @brief Tests build process of Auth_AX_FetchRequest.
	 * @param $required Array of requested required attributes.
	 * @param $optional Array of requested optional attributes.
	 * @dataProvider data
	 */
	public function testBuildExtension($required, $optional)
	{
		$list = $this->getMock('Ext_OpenID_AttributeList');
		$list->expects($this->any())
			->method('getRequired')
			->will($this->returnValue($required));
		$list->expects($this->any())
			->method('getOptional')
			->will($this->returnValue($optional));

		$request = $this->object->build($list);

		foreach ($required as $element)
		{
			$this->assertContains($element, $request->required);
		}

		foreach ($optional as $element)
		{
			$this->assertContains($element, $request->optional);
		}
	}
}
?>
