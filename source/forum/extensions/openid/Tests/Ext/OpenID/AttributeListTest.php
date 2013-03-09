<?php
/**
 * @file AttributeListTest.php
 * @brief Contains test class Ext_OpenID_AttributeListTest for Ext_OpenID_AttributeList.
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
require_once 'Ext/OpenID/AttributeList.php';

/**
 * @brief Test class for Ext_OpenID_AttributeList.
 */
class Ext_OpenID_AttributeListTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_OpenID_AttributeList.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_OpenID_AttributeList, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_OpenID_AttributeList;
	}

	/**
	 * @brief Data provider: returns attributes that have to be accepted.
	 * @return Array of test data sets.
	 */
	public function validAttributes()
	{
		return array(
			array('test'),
			array('test/test'),
		);
	}

	/**
	 * @brief Data provider: returns attributes that have to be rejected.
	 * @return Array of test data sets.
	 */
	public function invalidAttributes()
	{
		return array(
			array(NULL),
			array(0),
			array(1),
			array(array()),
		);
	}

	/**
	 * @brief Tests addition of required attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider validAttributes
	 */
	public function testAdditionOfRequiredAttribute($attribute)
	{
		$this->object->addRequired($attribute);
		$this->assertTrue(in_array($attribute, $this->object->getRequired()));
		$this->assertTrue(!in_array($attribute, $this->object->getOptional()));
	}

	/**
	 * @brief Tests addition of optional attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider validAttributes
	 */
	public function testAdditionOfOptionalAttribute($attribute)
	{
		$this->object->addOptional($attribute);
		$this->assertTrue(in_array($attribute, $this->object->getOptional()));
		$this->assertTrue(!in_array($attribute, $this->object->getRequired()));
	}

	/**
	 * @brief Tests addition of duplicate required attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider validAttributes
	 */
	public function testDuplicateRequiredAttributesAreIgnored($attribute)
	{
		$this->object->addRequired($attribute);
		$this->object->addRequired($attribute);
		$count = array_count_values($this->object->getRequired());
		$this->assertEquals(1, $count[$attribute]);
	}

	/**
	 * @brief Tests addition of duplicate optional attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider validAttributes
	 */
	public function testDuplicateOptionalAttributesAreIgnored($attribute)
	{
		$this->object->addOptional($attribute);
		$this->object->addOptional($attribute);
		$count = array_count_values($this->object->getOptional());
		$this->assertEquals(1, $count[$attribute]);
	}

	/**
	 * @brief Tests addition of invalid required attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider invalidAttributes
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidAttributesCannotBeAddedAsRequired($attribute)
	{
		$this->object->addRequired($attribute);
	}

	/**
	 * @brief Tests addition of invalid optional attributes.
	 * @param $attribute Attribute to be added.
	 * @dataProvider invalidAttributes
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidAttributesCannotBeAddedAsOptional($attribute)
	{
		$this->object->addOptional($attribute);
	}
}
?>
