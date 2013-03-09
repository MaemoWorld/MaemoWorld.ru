<?php
/**
 * @file RequestStorage.php
 * @brief Contains class Ext_RequestStorage.
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
 * @brief Saves and restores global variables for use across requests.
 */
class Ext_RequestStorage
{
	/**
	 * @brief Key in $_SESSION to save data.
	 */
	protected $field = NULL;

	/**
	 * @brief Initializes new object.
	 * 
	 * @li Starts PHP session handling.
	 * 
	 * @param $field Key in $_SESSION to save data.
	 */
	public function __construct($field='request')
	{
		$this->field = $field;

		if (session_id() == '') session_start();
	}

	/**
	 * @brief Saves single global variable \p $name.
	 * @param $name Name of global variable.
	 */
	protected function saveGlobal($name)
	{
		if (isset($GLOBALS[$name]))
		{
			$_SESSION[$this->field]['GLOBALS'][$name] = $GLOBALS[$name];
		}
	}

	/**
	 * @brief Saves single entry in (super)global array \p $name referenced by \p $key.
	 * @param $name Name of (super)global array.
	 * @param $key Index in array.
	 */
	protected function saveSuperglobal($name, $key)
	{
		if (isset($GLOBALS[$name][$key]))
		{
			$_SESSION[$this->field][$name][$key] = $GLOBALS[$name][$key];
		}
	}

	/**
	 * @brief Saves arbitrary global variables for use across requests.
	 * @param $source Name of superglobal source array or name of global variable.
	 * @param $key Index in superglobal source array or empty string to access global variable.
	 */
	public function save($source, $key=NULL)
	{
		if ($key == NULL)
		{
			$this->saveGlobal($source);
		}
		else
		{
			$this->saveSuperglobal($source, $key);
		}
	}

	/**
	 * @brief Saves several global variables in \p $list at once.
	 * @param $list Array of a arrays of global variables.
	 */
	public function saveList($list)
	{
		foreach ($list as $key => $values)
		{
			if (is_string($key))
			{
				foreach ($values as $value)
				{
					$this->saveSuperglobal($key, $value);
				}
			}
			else
			{
				foreach ($values as $value)
				{
					$this->saveGlobal($value);
				}
			}
		}
	}

	/**
	 * @brief Restores saved variables (if any).
	 * 
	 * Existing values are not overridden.
	 * Variables have to be saved again to be available in next request.
	 */
	public function restore()
	{
		if (isset($_SESSION[$this->field]) && is_array($_SESSION[$this->field]))
		{
			foreach ($_SESSION[$this->field] as $source => $value)
			{
				$GLOBALS[$source] += $value;
			}

			$this->discard();
		}
	}

	/**
	 * @brief Discards saved variables.
	 */
	public function discard()
	{
		unset($_SESSION[$this->field]);
	}
}
?>
