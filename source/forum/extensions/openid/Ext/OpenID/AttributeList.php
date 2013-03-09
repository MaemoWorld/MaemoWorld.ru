<?php
/**
 * @file AttributeList.php
 * @brief Contains class Ext_OpenID_AttributeList.
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


/**
 * @brief List of required and optional attributes.
 */
class Ext_OpenID_AttributeList
{
	/**
	 * @brief Array of required attributes.
	 */
	private $required = array();

	/**
	 * @brief Array of optional attributes.
	 */
	private $optional = array();

	/**
	 * @brief Adds \p $attribute to array \a $target, if not contained in \a $required or \a $optional.
	 * @param $attribute Attribute to be added.
	 * @param $target Reference to either \a $required or \a $optional.
	 * @exception InvalidArgumentException thrown if \p $attribute is not a string.
	 */
	private function add($attribute, &$target)
	{
		if (!is_string($attribute)) throw new InvalidArgumentException('$attribute is not of expected type string.');
		if (!in_array($attribute, $this->required) && !in_array($attribute, $this->optional))
			$target[] = $attribute;
	}

	/**
	 * @brief Adds \p $attribute to list marked as required.
	 * @param $attribute Attribute to be added.
	 * @exception InvalidArgumentException thrown if \p $attribute is not a string.
	 */
	public function addRequired($attribute)
	{
		$this->add($attribute, $this->required);
	}

	/**
	 * @brief Adds \p $attribute to list marked as optional.
	 * @param $attribute Attribute to be added.
	 * @exception InvalidArgumentException thrown if \p $attribute is not a string.
	 */
	public function addOptional($attribute)
	{
		$this->add($attribute, $this->optional);
	}

	/**
	 * @brief Returns required attributes.
	 * @return Array of required attributes.
	 */
	public function getRequired()
	{
		return $this->required;
	}

	/**
	 * @brief Returns optional attributes.
	 * @return Array of optional attributes.
	 */
	public function getOptional()
	{
		return $this->optional;
	}
}
?>
