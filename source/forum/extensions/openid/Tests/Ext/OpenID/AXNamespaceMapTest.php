<?php
/**
 * @file AXNamespaceMapTest.php
 * @brief Contains test class Ext_OpenID_AXNamespaceMapTest for Ext_OpenID_AXNamespaceMap.
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
require_once 'Ext/OpenID/AXNamespaceMap.php';

/**
 * @brief Test class for Ext_OpenID_AXNamespaceMap.
 */
class Ext_OpenID_AXNamespaceMapTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_OpenID_AXNamespaceMap.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_OpenID_AXNamespaceMap, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_OpenID_AXNamespaceMap;
	}

	/**
	 * @brief Data provider: returns sets of attributes.
	 * @return Array of test data sets.
	 */
	public function dataWithoutPrefix()
	{
		return array(
			array('namePerson/friendly'),
			array('pref/timezone'),
			array('contact/email'),
			array('contact/country/home')
		);
	}

	/**
	 * @brief Data provider: returns sets of attributes already prefixed with namespace URIs.
	 * @return Array of test data sets.
	 */
	public function dataWithPrefix()
	{
		return array(
			array('http://axschema.org/namePerson/friendly'),
			array('http://schema.openid.net/pref/timezone'),
			array('http://example.com/contact/email'),
			array('https://example.org/contact/country/home')
		);
	}

	/**
	 * @brief Tests prefixing of namespace URIs.
	 * @param $attribute Attribute without prefix.
	 * @dataProvider dataWithoutPrefix
	 */
	public function testPrefixingOfNamespaceURIs($attribute)
	{
		$result = $this->object->map($attribute);

		$this->assertContains('http://axschema.org/'.$attribute, $result);
		$this->assertContains('http://schema.openid.net/'.$attribute, $result);
	}

	/**
	 * @brief Tests prefixing of namespace URIs.
	 * @param $attribute Attribute with prefix.
	 * @dataProvider dataWithPrefix
	 */
	public function testNoPrefixingOfNamespaceURIsIfAlreadyPresent($attribute)
	{
		$result = $this->object->map($attribute);
		$this->assertEquals($attribute, $result);
	}
}
?>
