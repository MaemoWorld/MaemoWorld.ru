<?php
/**
 * @file OpenIDHandler.php
 * @brief Contains class Ext_PunBB_OpenIDHandler.
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


require_once 'Auth/OpenID/FileStore.php';
require_once 'Ext/OpenID/AttributeRequestMapper.php';
require_once 'Ext/OpenID/AttributeResponseMapper.php';
require_once 'Ext/OpenID/AXNamespaceMap.php';
require_once 'Ext/OpenID/AXRequest.php';
require_once 'Ext/OpenID/AXResponse.php';
require_once 'Ext/OpenID/Handler.php';
require_once 'Ext/OpenID/SRegRequest.php';
require_once 'Ext/OpenID/SRegResponse.php';
require_once 'Ext/PunBB/AXAttributeMap.php';
require_once 'Ext/PunBB/SRegAttributeMap.php';
require_once 'Ext/PunBB/UserData.php';

/**
 * @brief Provides simple interface for PunBB to send and receive OpenID requests and handle related data.
 */
class Ext_PunBB_OpenIDHandler extends Ext_OpenID_Handler
{
	/**
	 * @brief Whether to request user attributes in following authentication request.
	 */
	private $requestAttributes = false;

	/**
	 * @brief Ext_PunBB_UserData holding user data associated with current request.
	 */
	protected $userData = NULL;

	/**
	 * @brief Last error message (localised).
	 */
	protected $lastError = NULL;

	/**
	 * @brief Initializes new object.
	 * @param $current_url URL of current site used for additional validity checks.
	 */
	public function __construct($current_url)
	{
		parent::__construct($this->adjustURL($current_url));
	}

	/**
	 * @brief Returns last error message (localised).
	 * @return Last error message (localised).
	 */
	public function getLastError()
	{
		return $this->lastError;
	}

	/**
	 * @brief Returns array containing last error message (if any).
	 * @return Array of \a $lastError or empty array.
	 */
	public function getLastErrorList()
	{
		if ($this->getLastError() == NULL)
		{
			return array();
		}
		else
		{
			return array($this->getLastError());
		}
	}

	/**
	 * @brief Returns object holding data of current user.
	 * @return Ext_PunBB_UserData
	 */
	public function getUserData()
	{
		if ($this->userData == NULL)
		{
			$this->userData = new Ext_PunBB_UserData;
		}

		return $this->userData;
	}

	public function setIdentifier($identifier)
	{
		parent::setIdentifier($identifier);

		if (!$this->request)
		{
			global $lang_openid;
			$this->lastError = sprintf($lang_openid['Invalid identifier'], forum_htmlencode($identifier));
		}
	}

	/**
	 * @brief Sets claimed identifier.
	 * 
	 * Reloads user data to reflect new identifier.
	 * @param $identifier Claimed identifier.
	 */
	protected function setClaimedIdentifier($identifier)
	{
		parent::setClaimedIdentifier($identifier);
		$this->getUserData()->loadFromDatabase($identifier);
	}

	/**
	 * @brief Setter for $requestAttributes.
	 * @param $value Boolean value to set.
	 */
	public function setRequestAttributes($value)
	{
		$this->requestAttributes = (bool)$value;
	}

	/**
	 * @brief Saves internal state for use across requests.
	 * 
	 * State gets restored automatically by __construct().
	 * Saved properties (in addition to parent):
	 * @li \a $userData
	 */
	public function saveState()
	{
		parent::saveState();
		$this->saveStateVariable('requestAttributes');
		$this->saveStateVariable('userData');
		$this->saveStateVariable('lastError');
	}

	/**
	 * @brief Resets object to discard result of parsed request.
	 * 
	 * @li Resets \a $lastError to NULL.
	 */
	public function reset()
	{
		parent::reset();
		$this->requestAttributes = false;
		$this->userData = NULL;
		$this->lastError = NULL;
	}

	public function redirect($return_to=NULL)
	{
		$_SESSION[$this->getFieldPrefix().'_cookie_test'] = '1';

		try
		{
			parent::redirect($this->adjustURL($return_to));
		}
		catch (Ext_OpenID_InvalidIdentifierException $e)
		{
			global $lang_openid;
			$this->lastError = sprintf($lang_openid['Invalid identifier'], forum_htmlencode($this->getClaimedIdentifier()));
		}
	}

	public function parse()
	{
		parent::parse();

		if (isset($_SESSION[$this->getFieldPrefix().'_cookie_test']))
		{
			unset($_SESSION[$this->getFieldPrefix().'_cookie_test']);
		}
		else
		{
			global $lang_common;
			message($lang_common['No cookie']);
		}

		if ($this->getRequestStatus() == self::REQUEST_STATUS_FAILURE)
		{
			global $lang_openid;
			$this->lastError = sprintf($lang_openid['Authentication failure'], (($this->getFailureMessage() != NULL)?$this->getFailureMessage():$lang_openid['Unknown failure']));
		}
	}

	/**
	 * @brief Applies some tweaks to supplied \p $url.
	 * 
	 * Used by both redirect() and parse().
	 * @li Replaces HTML entity '\&amp;' with '&'.
	 * 
	 * @param $url URL to modify.
	 * @return Modified URL.
	 */
	private function adjustURL($url)
	{
		if ($url != NULL)
		{
			$url = str_replace('&amp;', '&', $url);
			$url .= ((strpos($url, '?') === false) ? '?' : '&').'csrf_token='.generate_form_token('openid');
		}

		return $url;
	}

	protected function getRealm()
	{
		global $base_url;
		return $base_url;
	}

	/**
	 * @brief Builds new Auth_OpenID_OpenIDStore.
	 * 
	 * Returns FileStore saved in extension directory.
	 * @return Auth_OpenID_FileStore
	 */
	protected function buildStore()
	{
		global $ext_info;
		return new Auth_OpenID_FileStore($ext_info['path'].'/oid_store');
	}

	/**
	 * @brief Adds extensions to request attributes to \p $request before redirecting.
	 * 
	 * Requests attributes using Simple Registration Extension:
	 * @li nickname (marked required)
	 * @li email (marked required)
	 * @li fullname
	 * @li country
	 * @li timezone
	 * 
	 * Requests attributes using Attribute Exchange Extension:
	 * @li namePerson/friendly (marked required)
	 * @li contact/email (marked required)
	 * @li namePerson
	 * @li contact/country/home
	 * @li pref/timezone
	 * @li contact/web/default
	 * @li contact/IM/AIM
	 * @li contact/IM/ICQ
	 * @li contact/IM/MSN
	 * @li contact/IM/Yahoo
	 * @li contact/IM/Jabber
	 * 
	 * @param $request Auth_OpenID_AuthRequest to which extensions are added.
	 */
	protected function addExtensions(Auth_OpenID_AuthRequest &$request)
	{
		if ($this->requestAttributes)
		{
			$attributes = new Ext_OpenID_AttributeList;
			$attributes->addRequired('username');
			$attributes->addRequired('email');
			$attributes->addOptional('realname');
			$attributes->addOptional('location');
			$attributes->addOptional('language');
			$attributes->addOptional('timezone');

			$sreg_request = new Ext_OpenID_AttributeRequestMapper(new Ext_OpenID_SRegRequest, new Ext_PunBB_SRegAttributeMap);
			$request->addExtension($sreg_request->build($attributes));

			// add additional attributes only supported by AX
			$attributes->addOptional('url');
			$attributes->addOptional('aim');
			$attributes->addOptional('icq');
			$attributes->addOptional('msn');
			$attributes->addOptional('yahoo');
			$attributes->addOptional('jabber');

			$ax_request = new Ext_OpenID_AttributeRequestMapper(new Ext_OpenID_AttributeRequestMapper(new Ext_OpenID_AXRequest, new Ext_OpenID_AXNamespaceMap), new Ext_PunBB_AXAttributeMap);
			$request->addExtension($ax_request->build($attributes));
		}
	}

	/**
	 * @brief Parses extension responses received with \p $response.
	 * 
	 * Parses Simple Registration and Attribute Exchange Extension responses.
	 * @param $response Auth_OpenID_SuccessResponse
	 */
	protected function parseExtensions(Auth_OpenID_SuccessResponse &$response)
	{
		$this->getUserData()->loadFromAttributeResponse(new Ext_OpenID_AttributeResponseMapper(new Ext_OpenID_SRegResponse($response), new Ext_PunBB_SRegAttributeMap));
		$this->getUserData()->loadFromAttributeResponse(new Ext_OpenID_AttributeResponseMapper(new Ext_OpenID_AttributeResponseMapper(new Ext_OpenID_AXResponse($response), new Ext_OpenID_AXNamespaceMap), new Ext_PunBB_AXAttributeMap));
	}
}
?>
