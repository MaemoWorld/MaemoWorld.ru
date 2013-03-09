<?php
/**
 * @file AXAttributeMapTest.php
 * @brief Contains test class Ext_PunBB_AXAttributeMapTest for Ext_PunBBD_AXAttributeMap.
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
require_once 'Ext/PunBB/AXAttributeMap.php';

/**
 * @brief Test class for Ext_PunBB_AXAttributeMap.
 */
class Ext_PunBB_AXAttributeMapTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_PunBB_AXAttributeMap.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_PunBB_AXAttributeMap, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_PunBB_AXAttributeMap;
	}

	/**
	 * @brief Data provider: returns sets of PunBB database field names and corresponding OpenID AX attributes.
	 * @return Array of test data sets.
	 */
	public function dataKnownValues()
	{
		return array(
			array('username', 'namePerson/friendly'),
			array('email', 'contact/email'),
			array('realname', 'namePerson'),
			array('location', 'contact/country/home'),
			array('language', 'pref/language'),
			array('timezone', 'pref/timezone'),
			array('url', 'contact/web/default'),
			array('aim', 'contact/IM/AIM'),
			array('icq', 'contact/IM/ICQ'),
			array('msn', 'contact/IM/MSN'),
			array('yahoo', 'contact/IM/Yahoo'),
			array('jabber', 'contact/IM/Jabber')
		);
	}

	/**
	 * @brief Data provider: returns strings not used as PunBB database field names.
	 * @return Array of test data sets.
	 */
	public function dataUnknownValues()
	{
		return array(
			array('http://axschema.org/namePerson/friendly'),
			array('http://schema.openid.net/pref/timezone'),
			array('foo'),
			array('bar')
		);
	}

	/**
	 * @brief Tests mapping of PunBB database field names to OpenID AX attributes.
	 * @param $input PunBB database field name.
	 * @param $output Expected OpenID AX attribute for \p $input.
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
