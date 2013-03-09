<?php
/**
 * @file AXRequestTest.php
 * @brief Contains test class Ext_OpenID_AXRequestTest for Ext_OpenID_AXRequest.
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
require_once 'Ext/OpenID/AXRequest.php';

/**
 * @brief Test class for Ext_OpenID_AXRequest.
 */
class Ext_OpenID_AXRequestTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_OpenID_AttributeList.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_OpenID_AXRequest, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_OpenID_AXRequest;
	}

	/**
	 * @brief Data provider: returns sets of required and optional attributes.
	 * @return Array of test data sets.
	 */
	public function data()
	{
		return array(
			array(
				array('namePerson/friendly'),
				array('pref/timezone')
			),
			array(
				array('contact/email'),
				array()
			),
			array(
				array(),
				array('namePerson', 'contact/country/home')
			)
		);
	}

	/**
	 * @brief Tests build process of Auth_AX_FetchRequest.
	 * @param $required Array of requested required attributes.
	 * @param $optional Array of requested optional attributes.
	 * @dataProvider data
	 */
	public function testBuildRequest($required, $optional)
	{
		$list = $this->getMock('Ext_OpenID_AttributeList');
		$list->expects($this->atLeastOnce())
			->method('getRequired')
			->will($this->returnValue($required));
		$list->expects($this->atLeastOnce())
			->method('getOptional')
			->will($this->returnValue($optional));

		$request = $this->object->build($list);

		$this->assertObjectHasAttribute('requested_attributes', $request);

		foreach ($required as $element)
		{
			$this->assertArrayHasKey($uri.$element, $request->requested_attributes);
			$this->assertTrue($request->requested_attributes[$uri.$element]->required);
		}

		foreach ($optional as $element)
		{
			$this->assertArrayHasKey($uri.$element, $request->requested_attributes);
			$this->assertFalse($request->requested_attributes[$uri.$element]->required);
		}
	}
}
?>
