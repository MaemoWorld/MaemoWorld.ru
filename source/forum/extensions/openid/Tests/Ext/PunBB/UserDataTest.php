<?php
/**
 * @file UserDataTest.php
 * @brief Contains test class Ext_PunBB_UserDataTest for Ext_PunBBD_UserData.
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
require_once 'Ext/PunBB/UserData.php';

/**
 * @brief Test class for Ext_PunBB_UserData.
 */
class Ext_PunBB_UserDataTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @brief Object under test.
	 * Instance of Ext_PunBB_UserData.
	 */
	protected $object;

	/**
	 * @brief Sets up the fixture.
	 * 
	 * Instantiates new Ext_PunBB_UserData, saved in \a $object.
	 */
	protected function setUp()
	{
		$this->object = new Ext_PunBB_UserData;
	}

	/**
	 * @brief Data provider: returns sets of PunBB user data.
	 * @return Array of test data sets.
	 */
	public function dataLoadUserDataFromDatabase()
	{
		return array(
			array('http://example.com/', '1', '1', 'password', 'salt'),
			array('http://id.example.org/', '123', '123', 'amuchlongerpasswordthatmightbeused', 'andamuchlongersalttoo')
		);
	}

	/**
	 * @brief Data provider: returns sets of PunBB user data.
	 * @return Array of test data sets.
	 */
	public function dataLoadUserDataFromAttributeResponse()
	{
		return array(
			array('foobar', array('location', 'icq', 'language', 'timezone', 'dst')),
			array('DE', array('icq', 'language', 'timezone', 'dst')),
			array('123456789', array('location', 'language', 'timezone', 'dst')),
			array('Europe/Berlin', array('location', 'icq', 'language'), array('timezone' => 1, 'dst' => NULL)),
		);
	}

	/**
	 * @brief Data provider: returns valid PunBB user data field names.
	 * @return Array of test data sets.
	 */
	public function dataValidUserDataFieldNames()
	{
		return array(
			array('id'),
			array('group_id'),
			array('password'),
			array('salt'),
			array('username'),
			array('email'),
			array('realname'),
			array('location'),
			array('language'),
			array('timezone'),
			array('dst'),
			array('url'),
			array('aim'),
			array('icq'),
			array('msn'),
			array('yahoo'),
			array('jabber')
		);
	}

	/**
	 * @brief Data provider: returns invalid PunBB user data field names.
	 * @return Array of test data sets.
	 */
	public function dataInvalidUserDataFieldNames()
	{
		return array(
			array('foo'),
			array('bar'),
			array('foobar'),
			array('123')
		);
	}

	/**
	 * @brief Tests loading of user data from database.
	 * @param $openid OpenID identifier.
	 * @param $userid PunBB user id.
	 * @param $groupid PunBB group id.
	 * @param $password PunBB password.
	 * @param $salt PunBB salt.
	 * @dataProvider dataLoadUserDataFromDatabase
	 */
	public function testLoadUserDataFromDatabase($openid, $userid, $groupid, $password, $salt)
	{
		$data = array(
			'id'		=> $userid,
			'group_id'	=> $groupid,
			'password'	=> $password,
			'salt'		=> $salt
		);

		global $forum_db;
		$forum_db = $this->getMock('DBLayer');
		$forum_db->expects($this->atLeastOnce())
			->method('escape')
			->with($openid)
			->will($this->returnValue($openid));
		$forum_db->expects($this->atLeastOnce())
			->method('query_build')
			->will($this->returnValue(true));
		$forum_db->expects($this->atLeastOnce())
			->method('fetch_assoc')
			->will($this->returnValue($data));

		$this->object->loadFromDatabase($openid);
		$this->assertEquals($userid, $this->object->id);
		$this->assertEquals($groupid, $this->object->group_id);
		$this->assertEquals($password, $this->object->password);
		$this->assertEquals($salt, $this->object->salt);

		$result = $this->object->getData();
		$this->assertEquals($userid, $result['id']);
		$this->assertEquals($groupid, $result['group_id']);
		$this->assertEquals($password, $result['password']);
		$this->assertEquals($salt, $result['salt']);
	}

	/**
	 * @brief Tests loading of user data from attribute response.
	 * @param $input Data returned from attribute response.
	 * @param $empty List of fields expected to be empty.
	 * @param $values List of fields and expected value or NULL for dontcare.
	 * @dataProvider dataLoadUserDataFromAttributeResponse
	 */
	public function testLoadUserDataFromAttributeResponse($input, $empty=array(), $values=array())
	{
		$response = $this->getMock('Ext_OpenID_AttributeResponse');
		$response->expects($this->atLeastOnce())
			->method('get')
			->will($this->returnValue($input));

		$this->object->loadFromAttributeResponse($response);
		$result = $this->object->getData();
		foreach ($result as $key => $data)
		{
			if (array_key_exists($key, $values))
			{
				if ($values[$key] != NULL)
				{
					$this->assertEquals($values[$key], $data);
					$this->assertEquals($values[$key], $this->object->$key);
				}
			}
			elseif (!in_array($key, array_merge(array('id', 'group_id', 'password', 'salt'), $empty)))
			{
				$this->assertEquals($input, $data);
				$this->assertEquals($input, $this->object->$key);
			}
		}

		foreach ($empty as $key)
		{
			$this->assertEquals('', $result[$key]);
			$this->assertEquals('', $this->object->$key);
		}
	}

	/**
	 * @brief Tests access of valid user data fields.
	 * @param $field Name of field.
	 * @dataProvider dataValidUserDataFieldNames
	 */
	public function testAccessValidUserDataFields($field)
	{
		$result = $this->object->getData();
		$this->assertEquals('', $result[$key]);
		$this->assertEquals('', $this->object->$field);
	}

	/**
	 * @brief Tests access of invalid user data fields.
	 * @param $field Name of field.
	 * @expectedException InvalidArgumentException
	 * @dataProvider dataInvalidUserDataFieldNames
	 */
	public function testAccessInvalidUserDataFields($field)
	{
		$result = $this->object->getData();
		$this->assertArrayNotHasKey($key, $result);
		$tmp = $this->object->$field;
	}
}

/**
 * Substitute for PunBB class DBLayer used to create mock object.
 * Class DBLayer is not available in this scope.
 * This block of code is exluded from documentation.
 * @cond
 */
interface DBLayer
{
	public function escape($arg);
	public function query_build($arg);
	public function fetch_assoc($arg);
}
/**
 * @endcond
 */
?>
