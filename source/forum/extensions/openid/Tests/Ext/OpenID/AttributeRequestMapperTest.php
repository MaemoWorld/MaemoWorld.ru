<?php
/**
 * @file AttributeRequestMapperTest.php
 * @brief Contains test class Ext_OpenID_AttributeRequestMapperTest for Ext_OpenID_AttributeRequestMapper.
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
require_once 'Ext/OpenID/AttributeRequestMapper.php';

/**
 * @brief Test class for Ext_OpenID_AttributeRequestMapper.
 */
class Ext_OpenID_AttributeRequestMapperTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Data provider: returns test data sets.
	 * @return Array of test data sets.
	 */
	public function data()
	{
		return array(
			array('foo', 'bar'),
			array('one', 'two'),
			array('test1', 'test2'),
			array('foobar', array('foo', 'bar')),
			array('test', array('one', 'two', 'three'))
		);
	}

	/**
	 * @brief Tests mapping of \p $mapinput to \p $mapoutput for required attributes.
	 * @param $mapinput Input for get().
	 * @param $mapoutput Expected output of map.
	 * @dataProvider data
	 */
	public function testUsageOfMapperForRequiredAttributes($mapinput, $mapoutput)
	{
		$list = $this->getMock('Ext_OpenID_AttributeList');
		$list->expects($this->atLeastOnce())
			->method('getRequired')
			->will($this->returnValue(array($mapinput)));
		$list->expects($this->atLeastOnce())
			->method('getOptional')
			->will($this->returnValue(array()));
		$request = $this->getMockRequest();
		$map = $this->getMockMap($mapinput, $mapoutput);

		$object = new Ext_OpenID_AttributeRequestMapper($request, $map);
		$result = $object->build($list);

		$this->assertEquals(is_array($mapoutput)?$mapoutput:array($mapoutput), $result->getRequired());
		$this->assertEquals(array(), $result->getOptional());
	}

	/**
	 * @brief Tests mapping of \p $mapinput to \p $mapoutput for optional attributes.
	 * @param $mapinput Input for get().
	 * @param $mapoutput Expected output of map.
	 * @dataProvider data
	 */
	public function testUsageOfMapperForOptionalAttributes($mapinput, $mapoutput)
	{
		$list = $this->getMock('Ext_OpenID_AttributeList');
		$list->expects($this->atLeastOnce())
			->method('getRequired')
			->will($this->returnValue(array()));
		$list->expects($this->atLeastOnce())
			->method('getOptional')
			->will($this->returnValue(array($mapinput)));
		$request = $this->getMockRequest();
		$map = $this->getMockMap($mapinput, $mapoutput);

		$object = new Ext_OpenID_AttributeRequestMapper($request, $map);
		$result = $object->build($list);

		$this->assertEquals(array(), $result->getRequired());
		$this->assertEquals(is_array($mapoutput)?$mapoutput:array($mapoutput), $result->getOptional());
	}

	/**
	 * @brief Returns Ext_OpenID_AttributeRequest mock object returning first argument for build() call.
	 * @return Mock object.
	 */
	protected function getMockRequest()
	{
		$request = $this->getMock('Ext_OpenID_AttributeRequest');
		$request->expects($this->atLeastOnce())
			->method('build')
			->will($this->returnArgument(0));
		return $request;
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
