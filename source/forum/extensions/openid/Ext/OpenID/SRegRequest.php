<?php
/**
 * @file SRegRequest.php
 * @brief Contains class Ext_OpenID_SRegRequest.
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


require_once 'Auth/OpenID/SReg.php';
require_once 'Ext/OpenID/AttributeList.php';
require_once 'Ext/OpenID/AttributeRequest.php';

/**
 * @brief Factory class for Auth_OpenID_SRegRequest.
 */
class Ext_OpenID_SRegRequest implements Ext_OpenID_AttributeRequest
{
	/**
	 * @brief Build Auth_OpenID_SRegRequest requesting attributes specified in \p $list.
	 * @param $list List of required and optional attributes.
	 * @return Auth_OpenID_Extension
	 */
	public function build(Ext_OpenID_AttributeList $list)
	{
		return Auth_OpenID_SRegRequest::build($list->getRequired(), $list->getOptional());
	}
}
?>
