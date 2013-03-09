<?php
/**
 * @file AttributeResponseMapperTest.php
 * @brief Contains test class Ext_OpenID_AttributeResponseMapperTest for Ext_OpenID_AttributeResponseMapper.
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
require_once 'Ext/OpenID/AttributeResponseMapper.php';

/**
 * @brief Test class for Ext_OpenID_AttributeResponseMapper.
 */
class Ext_OpenID_AttributeResponseMapperTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Data provider: returns test data sets with mappings to single values.
	 * @return Array of test data sets.
	 */
	public function dataSingleValueMapping()
	{
		return array(
			array('foo', 'bar', 'test'),
			array('one', 'two', 'value'),
			array('test1', 'test2', '')
		);
	}

	/**
	 * @brief Data provider: returns test data sets with mappings to multiple values.
	 * @return Array of test data sets.
	 */
	public function dataMultipleValuesMapping()
	{
		return array(
			array('foobar', array('foo', 'bar'), 'result'),
			array('test', array('one', 'two', 'three'), '')
		);
	}

	/**
	 * @brief Tests mapping of \p $mapinput to \p $mapoutput (single value) and reading of \p $getoutput via get().
	 * @param $mapinput Input for get().
	 * @param $mapoutput Expected output of map.
	 * @param $getoutput Expected output of get().
	 * @dataProvider dataSingleValueMapping
	 */
	public function testUsageOfMapperReturningSingleValue($mapinput, $mapoutput, $getoutput)
	{
		$response = $this->getMock('Ext_OpenID_AttributeResponse');
		$response->expects($this->atLeastOnce())
			->method('get')
			->with($mapoutput)
			->will($this->returnValue($getoutput));
		$map = $this->getMockMap($mapinput, $mapoutput);

		$object = new Ext_OpenID_AttributeResponseMapper($response, $map);
		$this->assertEquals($getoutput, $object->get($mapinput));
	}

	/**
	 * @brief Tests mapping of \p $mapinput to \p $mapoutput (multiple values) and reading of \p $getoutput via get().
	 * @param $mapinput Input for get().
	 * @param $mapoutput Expected output of map.
	 * @param $getoutput Expected output of get().
	 * @dataProvider dataMultipleValuesMapping
	 */
	public function testUsageOfMapperReturningMultipleValues($mapinput, $mapoutput, $getoutput)
	{
		$response = $this->getMock('Ext_OpenID_AttributeResponse');
		$response->expects($this->atLeastOnce())
			->method('get')
			->will($this->returnValue($getoutput));
		$map = $this->getMockMap($mapinput, $mapoutput);

		$object = new Ext_OpenID_AttributeResponseMapper($response, $map);
		$this->assertEquals($getoutput, $object->get($mapinput));
	}

	/**
	 * @brief Returns Ext_OpenID_Map mock object returning \p $output for \p $input.
	 * @param $input Input parameter for map().
	 * @param $output Output parameter for map().
	 * @return Mock object.
	 */
	protected function getMockMap($input, $output)
	{
		$map = $this->getMock('Ext_OpenID_Map');
		$map->expects($this->atLeastOnce())
			->method('map')
			->with($input)
			->will($this->returnValue($output));
		return $map;
	}
}
?>
