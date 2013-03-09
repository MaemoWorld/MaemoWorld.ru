<?php
/**
 * @file AttributeResponseMapper.php
 * @brief Contains class Ext_OpenID_AttributeResponseMapper.
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


require_once 'Ext/OpenID/AttributeResponse.php';
require_once 'Ext/OpenID/Map.php';

/**
 * @brief Wrapper class for Ext_OpenID_AttributeResponse to trap calls and map values using Ext_OpenID_Map.
 */
class Ext_OpenID_AttributeResponseMapper implements Ext_OpenID_AttributeResponse
{
	/**
	 * @brief Instance of Ext_OpenID_AttributeResponse.
	 */
	protected $response = NULL;

	/**
	 * @brief Instance of Ext_OpenID_Map.
	 */
	protected $map = NULL;

	/**
	 * @brief Initializes new object.
	 * @param $response Ext_OpenID_AttributeResponse to be wrapped.
	 * @param $map Ext_OpenID_Map used to map arguments of trapped function calls.
	 */
	public function __construct(Ext_OpenID_AttributeResponse $response, Ext_OpenID_Map $map)
	{
		$this->response = $response;
		$this->map = $map;
	}

	/**
	 * @brief Maps requested \p $attribute using \a $map. New attribute is passed on to wrapped \a $response.
	 * 
	 * If \a $map maps \p $attribute to more than one value, the first non-empty value returned by \a $response is returned.
	 * @param $attribute Attribute to be read.
	 * @return Attribute value.
	 */
	public function get($attribute)
	{
		$result = $this->map->map($attribute);

		if (is_array($result))
		{
			foreach ($result as $element)
			{
				$value = $this->response->get($element);

				if ($value != '')
				{
					return $value;
				}
			}

			return '';
		}
		else
		{
			return $this->response->get($result);
		}
	}
}
?>
