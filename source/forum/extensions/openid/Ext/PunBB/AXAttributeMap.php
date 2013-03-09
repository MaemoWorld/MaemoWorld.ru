<?php
/**
 * @file AXAttributeMap.php
 * @brief Contains class Ext_PunBB_AXAttributeMap.
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
 * @brief Map used to map PunBB database field names to OpenID AX attributes.
 */
class Ext_PunBB_AXAttributeMap implements Ext_OpenID_Map
{
	/**
	 * @brief Maps PunBB database field names to OpenID AX attributes.
	 * 
	 * Mapped database fields:
	 * @li username: namePerson/friendly
	 * @li email: contact/email
	 * @li realname: namePerson
	 * @li location: contact/country/home
	 * @li language: pref/language
	 * @li timezone: pref/timezone
	 * @li url: contact/web/default
	 * @li aim: contact/IM/AIM
	 * @li icq: contact/IM/ICQ
	 * @li msn: contact/IM/MSN
	 * @li yahoo: contact/IM/Yahoo
	 * @li jabber: contact/IM/Jabber
	 * @param $attribute Attribute to be mapped.
	 * @return OpenID AX attribute (without namespace).
	 */
	public function map($attribute)
	{
		switch ($attribute)
		{
			case 'username':
				return 'namePerson/friendly';
			case 'email':
				return 'contact/email';
			case 'realname':
				return 'namePerson';
			case 'location':
				return 'contact/country/home';
			case 'language':
				return 'pref/language';
			case 'timezone':
				return 'pref/timezone';
			case 'url':
				return 'contact/web/default';
			case 'aim':
				return 'contact/IM/AIM';
			case 'icq':
				return 'contact/IM/ICQ';
			case 'msn':
				return 'contact/IM/MSN';
			case 'yahoo':
				return 'contact/IM/Yahoo';
			case 'jabber':
				return 'contact/IM/Jabber';
			default:
				return $attribute;
		}
	}
}
?>
