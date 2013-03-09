<?php
/**
 * @file English/openid.php
 * @brief Contains PunBB language information for OpenID extension (English).
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


if (!defined('FORUM')) die();

/**
 * @brief English language strings.
 */
$lang_openid = array(
	'OpenID'						=> 'OpenID',
	'OpenID login'					=> 'You may log in by either supplying your OpenID or username and password.',
	'OpenID registration'			=> '<a href="%s">Log in with an OpenID</a> to register automatically.',
	'OpenID password change'		=> 'In order to change your password, you have to either supply your old password or authenticate using your OpenID.',
	'OpenID email change'			=> 'In order to change your e-mail address, you have to either supply your old password or authenticate using your OpenID.',
	'OpenID update profile'			=> 'Request identity details via OpenID',
	'OpenID manage'					=> 'In order to protect your account, adding new OpenIDs to your account or removing existing OpenIDs from your account needs to be confirmed by either your password or another OpenID associated with your account.',
	'override data'					=> 'Existing data will be overridden.',
	'Manage your OpenIDs'			=> 'Modify the OpenIDs associated with your account',
	'Manage user OpenIDs'			=> 'Modify the OpenIDs associated with %s\'s account',
	'New OpenID'					=> 'New OpenID',
	'Existing OpenID'				=> 'Existing OpenID',
	'Add OpenID'					=> 'Add',
	'Remove OpenID'					=> 'Remove',
	'Authentication failure'		=> 'OpenID authentication failed: %s',
	'Unknown failure'				=> 'Unknown failure.',
	'Invalid identifier'			=> 'OpenID \'%s\' is invalid.',
	'Identifier already registered'	=> 'OpenID \'%s\' is already registered.',
	'Choose another OpenID'			=> 'You cannot authenticate using the OpenID you want to remove.',
	'Error inexistent directory'	=> 'Directory \'%s\' could not be created.',
	'Error not a directory'			=> 'File \'%s\' is not a directory.',
	'Error not writable'			=> 'Directory \'%s\' is not writable.',
);
?>
