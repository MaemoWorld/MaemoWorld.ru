<?php
/**
 * @file UserData.php
 * @brief Contains class Ext_PunBB_UserData.
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
 * @brief Holds user data of a PunBB user.
 * 
 * User data may be extracted from PunBB database or OpenID attribute request.
 */
class Ext_PunBB_UserData
{
	/**
	 * @brief Array of user data as stored in PunBB database.
	 */
	private $data = array(
		'id' => '',
		'group_id' => '',
		'password' => '',
		'salt' => '',
		'username' => '',
		'email' => '',
		'realname' => '',
		'location' => '',
		'language' => '',
		'timezone' => '',
		'dst' => '',
		'url' => '',
		'aim' => '',
		'icq' => '',
		'msn' => '',
		'yahoo' => '',
		'jabber' => ''
	);

	/**
	 * @brief Determines if current user is already known to PunBB database.
	 * @return True, if user is known (i.e. has a non empty/guest id).
	 */
	public function isKnownUser()
	{
		return ($this->data['id'] > 1);
	}

	/**
	 * @brief Loads user data associated with OpenID \p $identifier from PunBB database.
	 * @param $identifier OpenID identifier
	 */
	public function loadFromDatabase($identifier)
	{
		global $forum_db;

		$query = array(
			'SELECT'        => 'id, group_id, password, salt',
			'FROM'          => 'openid_map AS o',
			'WHERE'         => 'o.openid = \''.$forum_db->escape($identifier).'\'',
			'JOINS'			=> array(
				array(
					'INNER JOIN'	=> 'users AS u',
					'ON'			=> 'u.id = o.userid'
				)
			)
		);

		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		$data = $forum_db->fetch_assoc($result);

		if ($data)
		{
			$this->data['id'] = $data['id'];
			$this->data['group_id'] = $data['group_id'];
			$this->data['password'] = $data['password'];
			$this->data['salt'] = $data['salt'];
		}
		else
		{
			$this->data['id'] = '';
			$this->data['group_id'] = '';
			$this->data['password'] = '';
			$this->data['salt'] = '';
		}
	}

	/**
	 * @brief Loads user data from OpenID attribute request \p $response.
	 * @param $response Auth_OpenID_SuccessResponse
	 */
	public function loadFromAttributeResponse(Ext_OpenID_AttributeResponse $response)
	{
		$this->copyFromAttributeResponse($response, 'username');
		$this->copyFromAttributeResponse($response, 'email');
		$this->copyFromAttributeResponse($response, 'realname');
		$this->copyFromAttributeResponse($response, 'location', '/^[A-Z]{2}$/');
		$this->copyFromAttributeResponse($response, 'url');
		$this->copyFromAttributeResponse($response, 'aim');
		$this->copyFromAttributeResponse($response, 'icq', '/^[0-9]+$/');
		$this->copyFromAttributeResponse($response, 'msn');
		$this->copyFromAttributeResponse($response, 'yahoo');
		$this->copyFromAttributeResponse($response, 'jabber');

		$language = $response->get('language');
		if (preg_match('/^([a-zA-Z]{2,3})($|-)/', $language, $result))
		{
			// RFC 4646 language code
			// use only primary language subtag (should be sufficient?)
			$lang = $this->mapLanguage(strtolower($result[1]));

			if ($lang)
			{
				$this->data['language'] = $lang;
			}
		}
		elseif ($this->verifyLanguage($language))
		{
			// English language name
			// non-standard behaviour, supported nonetheless
			$this->data['language'] = $language;
		}

		try
		{
			// constructor of DateTimeZone throws Exception if timezone is invalid
			// if this happens, catch it and skip utc offset/dst calculation
			$timezone = new DateTimeZone($response->get('timezone'));
			$date_now = new DateTime('now', $timezone);
			$date_compare1 = new DateTime(date('Y-06-30'), $timezone);
			$date_compare2 = new DateTime(date('Y-12-31'), $timezone);
			$offset1 = $date_compare1->getOffset();
			$offset2 = $date_compare2->getOffset();

			if ($offset1 != $offset2 && $date_now->getOffset() == max($offset1, $offset2))
			{
				// we choose dates, one in the middle of the current year, one in the end
				// if the utc offset at both dates is different, timezone has dst
				// if the current utc offset is equal to the greater one of the comparison points
				// dst is now in effect
				$this->data['dst'] = '1';
			}

			$this->data['timezone'] = min($offset1, $offset2) / 3600;
		}
		catch (Exception $e)
		{
		}
	}

	/**
	 * @brief Read data in \p $field from attribute response \p $response and save in \a $data.
	 * 
	 * Optionally, validate data against regular expression in \p $regex.
	 * @param $response Ext_OpenID_AttributeResponse
	 * @param $field Field to be read.
	 * @param $regex Optional regular expression to validate value.
	 */
	protected function copyFromAttributeResponse(Ext_OpenID_AttributeResponse $response, $field, $regex=NULL)
	{
		$value = $response->get($field);

		if (!$this->data[$field] && (!$regex || preg_match($regex, $value)))
		{
			$this->data[$field] = $value;
		}
	}

	/**
	 * @brief Returns whole array of user data.
	 * @return Array of user data.
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @brief Provides easy access to single user data properties.
	 * @param $name Requested property.
	 * @exception InvalidArgumentException if property is unknown.
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->data))
		{
			return $this->data[$name];
		}
		else
		{
			throw new InvalidArgumentException('Unknown property');
		}
	}

	/**
	 * @brief Verify user-supplied language by checking that the language pack exists.
	 * @param $language Language string to be verified.
	 */
	public function verifyLanguage($language)
	{
		return file_exists(FORUM_ROOT.'lang/'.basename($language).'/common.php');
	}

	/**
	 * @brief Maps language code in \p $language to PunBB language name.
	 * 
	 * Keeps a static map to speed up multiple lookups.
	 * @param $language RFC 1766/ISO 639-1 compliant language code as required by HTML lang attribute.
	 * @return Language name or empty string if unknown language.
	 */
	protected function mapLanguage($language)
	{
		static $languages = array();

		if (!$languages)
		{
			$dir = @opendir(FORUM_ROOT.'lang');

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file != '.' && $file != '..' && is_dir(FORUM_ROOT.'lang/'.$file) && file_exists(FORUM_ROOT.'lang/'.$file.'/common.php'))
					{
						include FORUM_ROOT.'lang/'.$file.'/common.php';
						$languages[$lang_common['lang_identifier']] = $file;
					}
				}

				closedir($dir);
			}
		}

		return isset($languages[$language]) ? $languages[$language] : '';
	}
}
?>
