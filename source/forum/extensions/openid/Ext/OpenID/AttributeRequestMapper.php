<?php
/**
 * @file AttributeRequestMapper.php
 * @brief Contains class Ext_OpenID_AttributeRequestMapper.
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


require_once 'Ext/OpenID/AttributeRequest.php';
require_once 'Ext/OpenID/AttributeList.php';
require_once 'Ext/OpenID/Map.php';

/**
 * @brief Wrapper class for Ext_OpenID_AttributeRequest to trap calls and map values using Ext_OpenID_Map.
 */
class Ext_OpenID_AttributeRequestMapper implements Ext_OpenID_AttributeRequest
{
	/**
	 * @brief Instance of Ext_OpenID_AttributeRequest.
	 */
	protected $request = NULL;

	/**
	 * @brief Instance of Ext_OpenID_Map.
	 */
	protected $map = NULL;

	/**
	 * @brief Initializes new object.
	 * @param $request Ext_OpenID_AttributeRequest to be wrapped.
	 * @param $map Ext_OpenID_Map used to map arguments of trapped function calls.
	 */
	public function __construct(Ext_OpenID_AttributeRequest $request, Ext_OpenID_Map $map)
	{
		$this->request = $request;
		$this->map = $map;
	}

	/**
	 * @brief Maps attributes contained in \p $list using \a $map. New list is passed on to wrapped \a $request.
	 * @param $list Ext_OpenID_AttributeList containing attributes to be requested.
	 * @return Auth_OpenID_Extension
	 */
	public function build(Ext_OpenID_AttributeList $list)
	{
		$nlist = new Ext_OpenID_AttributeList;
		$this->processList($list, $nlist, 'getOptional', 'addOptional');
		$this->processList($list, $nlist, 'getRequired', 'addRequired');

		return $this->request->build($nlist);
	}

	/**
	 * @brief Maps all values in \p $oldlist to one or more values in \p $newlist.
	 * @param $oldlist Reference to Ext_OpenID_AttributeList to read values from.
	 * @param $newlist Reference to Ext_OpenID_AttributeList to add values to.
	 * @param $getter Name of function used to read values from \p $oldlist.
	 * @param $setter Name of function used to add values to \p $newlist.
	 */
	protected function processList(Ext_OpenID_AttributeList &$oldlist, Ext_OpenID_AttributeList &$newlist, $getter, $setter)
	{
		foreach ($oldlist->$getter() as $element)
		{
			$result = $this->map->map($element);

			if (is_array($result))
			{
				foreach ($result as $newelement)
				{
					$newlist->$setter($newelement);
				}
			}
			else
			{
				$newlist->$setter($result);
			}
		}
	}
}
?>
