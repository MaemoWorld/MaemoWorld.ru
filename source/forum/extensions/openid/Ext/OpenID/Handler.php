<?php
/**
 * @file Handler.php
 * @brief Contains class Ext_OpenID_Handler.
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


require_once 'Auth/OpenID/Message.php';
require_once 'Ext/OpenID/InvalidIdentifierException.php';
require_once 'Ext/RequestStorage.php';

/**
 * @brief Provides simple generic interface to send and receive OpenID requests and handle related data.
 * 
 * Should be subclassed to configure project specific behaviour.
 */
class Ext_OpenID_Handler
{
	/**
	 * @brief No request received or not yet parsed.
	 */
	const REQUEST_STATUS_NONE = 0;

	/**
	 * @brief Authentication request was successful.
	 */
	const REQUEST_STATUS_SUCCESS = 1;

	/**
	 * @brief Authentication request has failed.
	 */
	const REQUEST_STATUS_FAILURE = 2;

	/**
	 * @brief Authentication request was cancelled.
	 */
	const REQUEST_STATUS_CANCEL = 3;

	/**
	 * @brief Authentication request was successful, but no session data was received.
	 */
	const REQUEST_STATUS_INCOMPLETE = 4;

	/**
	 * @brief Claimed OpenID identifier (discovered from user input).
	 */
	protected $claimedIdentifier = '';

	/**
	 * @brief Status of authentication request.
	 */
	protected $requestStatus = self::REQUEST_STATUS_NONE;

	/**
	 * @brief Failure message of OpenID request.
	 */
	protected $failureMessage = NULL;

	/**
	 * @brief Object to save gloabal variables across requests.
	 */
	protected $requestStorage = NULL;

	/**
	 * @brief URL of current page.
	 */
	protected $current_url = NULL;

	/**
	 * @brief Auth_OpenID_AuthRequest.
	 */
	protected $request = NULL;
	
	/**
	 * @brief Initializes new object.
	 * 
	 * @li Registers namespace alias to get SReg extension working.
	 * @li Starts PHP session handling.
	 * @li Reads user-supplied OpenID identifier.
	 * 
	 * @param $current_url URL of current site used for additional validity checks.
	 */
	public function __construct($current_url)
	{
		$this->current_url = $current_url;
		$this->requestStorage = new Ext_RequestStorage($this->getFieldPrefix().'_request');

		// workaround to get SReg extension working
		// requires Auth/OpenID/Message.php
		Auth_OpenID_registerNamespaceAlias('http://openid.net/extensions/sreg/1.1', 'sreg');

		// start PHP session handling
		if (session_id() == '') session_start();

		// restore internal state
		$this->restoreState();

		// begin request handling
		if ($this->isBeginRequest())
		{
			$this->setIdentifier($_POST['openid_identifier']);
		}
		elseif ($this->isCompleteRequest())
		{
			$this->parse();

			if ($this->requestStatus != self::REQUEST_STATUS_CANCEL)
			{
				$this->requestStorage->restore();
			}
		}
	}

	/**
	 * @brief Returns claimed OpenID identifier.
	 * @return Claimed OpenID identifier.
	 */
	public function getClaimedIdentifier()
	{
		return $this->claimedIdentifier;
	}

	/**
	 * @brief Performs discovery on user-supplied OpenID identifier and sets claimed identifier.
	 * 
	 * If discovery was not successful, claimed identifier is user-supplied identifier.
	 * Saves AuthRequest for later use in redirect().
	 * @param $identifier User-supplied OpenID identifier.
	 */
	public function setIdentifier($identifier)
	{
		$this->reset();
		$consumer = $this->buildConsumer();
		$this->request = $consumer->begin($identifier);
		$this->setClaimedIdentifier($this->request ? $this->request->endpoint->claimed_id : $identifier);
	}

	/**
	 * @brief Sets claimed identifier.
	 * @param $identifier Claimed identifier.
	 */
	protected function setClaimedIdentifier($identifier)
	{
		$this->claimedIdentifier = $identifier;
	}

	/**
	 * @brief Returns status of authentication request.
	 * @return Status of authentication request.
	 */
	public function getRequestStatus()
	{
		return $this->requestStatus;
	}

	/**
	 * @brief Returns failure message of OpenID request.
	 * @return Failure message of OpenID request.
	 */
	public function getFailureMessage()
	{
		return $this->failureMessage;
	}

	/**
	 * @brief Returns object to save gloabal variables across requests.
	 * @return Object to save gloabal variables across requests.
	 */
	public function getRequestStorage()
	{
		return $this->requestStorage;
	}

	/**
	 * @brief Returns prefix to be used for all information stored in global scope to prevent naming conflicts.
	 * 
	 * By default, returns 'openid'.
	 * May be overridden by subclasses to provide own value.
	 * @return Prefix.
	 */
	public function getFieldPrefix()
	{
		return 'openid';
	}

	/**
	 * @brief Returns true if user wants to start OpenID authorization.
	 * @return true, if \a $_POST['openid_identifier'] is set
	 */
	public static function isBeginRequest()
	{
		return (isset($_POST['openid_identifier']) && $_POST['openid_identifier'] != '');
	}

	/**
	 * @brief Returns true if OpenID response received.
	 * @return true, if \a $_POST['openid_mode'] or $_GET['openid_mode'] is set
	 */
	public static function isCompleteRequest()
	{
		return (isset($_POST['openid_mode']) || isset($_GET['openid_mode']));
	}

	/**
	 * @brief Returns true if successful OpenID response received.
	 * @return true, if \a $requestStatus is Ext_OpenID_Handler::REQUEST_STATUS_SUCCESS.
	 */
	public function isSuccessRequest()
	{
		return ($this->getRequestStatus() == self::REQUEST_STATUS_SUCCESS);
	}

	/**
	 * @brief Saves internal state for use across requests.
	 * 
	 * State gets restored automatically by __construct().
	 * Saved properties:
	 * @li \a $identifier
	 * @li \a $requestStatus
	 * @li \a $failureMessage
	 */
	public function saveState()
	{
		$this->saveStateVariable('claimedIdentifier');
		$this->saveStateVariable('requestStatus');
		$this->saveStateVariable('failureMessage');
		$this->saveStateVariable('current_url');
	}

	/**
	 * @brief Saves internal state variable in \a $_SESSION.
	 * @param $name Name of variable.
	 */
	protected function saveStateVariable($name)
	{
		if (property_exists($this, $name))
		{
			$_SESSION[$this->getFieldPrefix()]['state'][$name] = $this->$name;
		}
	}

	/**
	 * @brief Restores saved state (if any).
	 * 
	 * State has to be saved again to be available in next request.
	 */
	protected function restoreState()
	{
		if (isset($_SESSION[$this->getFieldPrefix()]['state']))
		{
			foreach ($_SESSION[$this->getFieldPrefix()]['state'] as $source => $value)
			{
				if (property_exists($this, $source))
				{
					$this->$source = $value;
				}
			}
			unset($_SESSION[$this->getFieldPrefix()]['state']);
		}
	}

	/**
	 * @brief Resets object to discard result of parsed request.
	 * 
	 * @li Resets \a $requestStatus to REQUEST_STATUS_NONE.
	 * @li Resets \a $failureMessage to NULL.
	 */
	public function reset()
	{
		$this->requestStatus = self::REQUEST_STATUS_NONE;
		$this->failureMessage = NULL;
	}

	/**
	 * @brief Begins new OpenID request and redirects user to provider.
	 * 
	 * Uses addExtensions() to add extensions to request before redirecting.
	 * @param $return_to URL that receives response from provider.
	 * @exception Ext_OpenID_InvalidIdentifierException thrown if claimed identifier could not be resolved to an endpoint.
	 */
	public function redirect($return_to=NULL)
	{
		if (!$this->request)
		{
			throw new Ext_OpenID_InvalidIdentifierException;
		}

		$this->addExtensions($this->request);

		header('Location: '.$this->request->redirectURL($this->getRealm(), (($return_to != NULL) ? $return_to : $this->current_url)));
		exit;
	}

	/**
	 * @brief Parses OpenID response.
	 * @return \a $requestStatus.
	 */
	public function parse()
	{
		// read response and get status
		$consumer = $this->buildConsumer();
		$response = $consumer->complete($this->current_url);
		$this->setClaimedIdentifier($response->identity_url);
		$this->requestStatus = self::mapStatusCode($response->status);

		if ($this->requestStatus == self::REQUEST_STATUS_SUCCESS)
		{
			$this->parseExtensions($response);
		}
		elseif ($this->requestStatus == self::REQUEST_STATUS_FAILURE)
		{
			$this->failureMessage = $response->message;
		}

		return $this->requestStatus;
	}

	/**
	 * @brief Returns autorization realm.
	 * 
	 * By default, tries to determine realm using current URL.
	 * May be overridden by subclasses to provide an own value.
	 * @return Autorization realm.
	 */
	protected function getRealm()
	{
		$realm = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		{
			$realm .= 's';
		}
		$realm .= '://';
		$realm .= $_SERVER['SERVER_NAME'];
		$realm .= ':';
		$realm .= $_SERVER['SERVER_PORT'];
		$realm .= dirname($_SERVER['PHP_SELF']);

		return $realm;
	}

	/**
	 * @brief Builds new Auth_OpenID_OpenIDStore.
	 * 
	 * By default, returns Auth_OpenID_DumbStore with empty secret phrase.
	 * Should be overridden by subclasses to provide advanced store.
	 * @return Auth_OpenID_DumbStore
	 */
	protected function buildStore()
	{
		return new Auth_OpenID_DumbStore('');
	}

	/**
	 * @brief Builds new Auth_OpenID_Consumer.
	 * @return Auth_OpenID_Consumer
	 */
	protected function buildConsumer()
	{
		return new Auth_OpenID_Consumer($this->buildStore());
	}

	/**
	 * @brief Adds extensions to \p $request before redirecting.
	 * 
	 * By default, adds no extensions.
	 * May be overridden by subclasses to add own extensions.
	 * @param $request Auth_OpenID_AuthRequest to which extensions are added.
	 */
	protected function addExtensions(Auth_OpenID_AuthRequest &$request)
	{
	}

	/**
	 * @brief Parses extension responses received with \p $response.
	 * 
	 * By default, does nothing.
	 * May be overridden by subclasses to parse own extensions added via addExtensions().
	 * @param $response Auth_OpenID_SuccessResponse
	 */
	protected function parseExtensions(Auth_OpenID_SuccessResponse &$response)
	{
	}

	/**
	 * @brief Maps Auth_OpenID status codes to own status codes.
	 * @param $code One of Auth_OpenID_SUCCESS, Auth_OpenID_CANCEL, Auth_OpenID_FAILURE.
	 * @return One of Ext_OpenID_Handler::REQUEST_STATUS_SUCCESS,
	 * Ext_OpenID_Handler::REQUEST_STATUS_CANCEL,
	 * Ext_OpenID_Handler::REQUEST_STATUS_FAILURE.
	 */
	private static function mapStatusCode($code)
	{
		switch ($code)
		{
			case Auth_OpenID_SUCCESS:
				return self::REQUEST_STATUS_SUCCESS;
			case Auth_OpenID_CANCEL:
				return self::REQUEST_STATUS_CANCEL;
			case Auth_OpenID_FAILURE:
			default:
				return self::REQUEST_STATUS_FAILURE;
		}
	}
}
?>
