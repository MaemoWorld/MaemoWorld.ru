<?php
/**
 * @file AXResponse.php
 * @brief Contains class Ext_OpenID_AXResponse.
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


require_once 'Auth/OpenID/AX.php';
require_once 'Ext/OpenID/AttributeResponse.php';

/**
 * @brief Adapter class to provide unified access to attributes contained in Auth_OpenID_AX_FetchResponse.
 */
class Ext_OpenID_AXResponse implements Ext_OpenID_AttributeResponse
{
	/**
	 * @brief Instance of Auth_OpenID_AX_FetchResponse.
	 */
	protected $response = NULL;

	/**
	 * @brief Initializes new object by creating Auth_OpenID_AX_FetchResponse out of \p $response.
	 */
	public function __construct(Auth_OpenID_SuccessResponse $response)
	{
		$this->response = Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);
	}

	/**
	 * @brief Returns value of attribute \p $attribute.
	 * @param $attribute Attribute to be read.
	 * @return Attribute value or empty string if unknown attribute.
	 */
	public function get($attribute)
	{
		if ($this->response)
		{
			$result = $this->response->get($attribute);

			if (!($result instanceof Auth_OpenID_AX_Error) && isset($result[0]) && $result[0] != '')
			{
				return $result[0];
			}
		}

		return '';
	}
}
?>
