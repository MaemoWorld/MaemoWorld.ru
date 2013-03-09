<?php
/**
 * @file AXNamespaceMap.php
 * @brief Contains class Ext_OpenID_AXNamespaceMap.
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
 * @brief Map used to prefix namespace URIs to OpenID AX attributes.
 */
class Ext_OpenID_AXNamespaceMap implements Ext_OpenID_Map
{
	/**
	 * @brief Returns array of \p $attribute prefixed with namespace URIs.
	 * 
	 * Namespace URIs used for prefixing:
	 * @li http://axschema.org/
	 * @li http://schema.openid.net/
	 * 
	 * If there already seems to be a namespace URI, no prefixing is done.
	 * @param $attribute Attribute to be mapped.
	 * @return Array of or single complete attribute URI.
	 */
	public function map($attribute)
	{
		if (strpos($attribute, '://') === false)
		{
			return array('http://axschema.org/'.$attribute, 'http://schema.openid.net/'.$attribute);
		}
		else
		{
			return $attribute;
		}
	}
}
?>
