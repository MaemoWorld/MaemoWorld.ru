<?php
/**
 * @file SRegAttributeMap.php
 * @brief Contains class Ext_PunBB_SRegAttributeMap.
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


require_once 'Ext/OpenID/Map.php';

/**
 * @brief Map used to map PunBB database field names to OpenID SReg attributes.
 */
class Ext_PunBB_SRegAttributeMap implements Ext_OpenID_Map
{
	/**
	 * @brief Maps PunBB database field names to OpenID SReg attributes.
	 * 
	 * Mapped database fields:
	 * @li username: nickname
	 * @li email: email
	 * @li realname: fullname
	 * @li location: country
	 * @li language: language
	 * @li timezone: timezone
	 * @param $attribute Attribute to be mapped.
	 * @return OpenID SReg attribute.
	 */
	public function map($attribute)
	{
		switch ($attribute)
		{
			case 'username':
				return 'nickname';
			case 'email':
				return 'email';
			case 'realname':
				return 'fullname';
			case 'location':
				return 'country';
			case 'language':
				return 'language';
			case 'timezone':
				return 'timezone';
			default:
				return $attribute;
		}
	}
}
?>
